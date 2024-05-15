<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.index');
    }

    public function create()
    {
        $customFields = $this->getCustomFields(0);
        return view('company.edit', compact('customFields'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $company = new Company;
        $company->fill($data);
        $company->origin = 'Manual';
        $company->save();

        $this->updateCustomFields($company->id, $data);

        return Redirect::route('company.index');
    }

    public function list(Request $request): LengthAwarePaginator
    {
        $param = $request->param ?? null;

        return DB::table('companies')
            ->when($param, function ($query) use ($param) {
                return $query->where(function ($query) use ($param) {
                    $query->whereRaw('LOWER(document) LIKE LOWER(?)', ["%{$param}%"])
                        ->orWhereRaw('LOWER(name) LIKE LOWER(?)', "%{$param}%")
                        ->orWhereRaw('LOWER(trade) LIKE LOWER(?)', "%{$param}%");
                });
            })
            ->paginate(10);
    }

    public function search(Request $request): array
    {
        $param = explode(' - ', $request->param);
        return Company::select('id', 'document', 'name')
            ->when($param[0], function ($query) use ($param) {
                return $query->search($param[0]);
            })
            ->when(isset($param[1]), function ($query) use ($param) {
                return $query->search($param[1]);
            })
            ->get()
            ->toArray();
    }

    public function edit(int $id): View
    {
        $company = Company::find($id);
        $customFields = $this->getCustomFields($id);

        return view('company.edit', compact('company', 'customFields'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->all();

        $company = Company::find($id);
        $company->fill($data);
        $company->update();

        $this->updateCustomFields($id, $data);

        return Redirect::route('company.edit', compact('id'))->with('status', 'company-updated');
    }

    private function getCustomFields(int $companyId): Collection
    {
        return CustomField::with(['values' => function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        }])->where('status', true)->get();
    }

    private function updateCustomFields(int $companyId, array $data): void
    {
        $customFields = $this->extractCustomFields($data);

        foreach ($customFields as $key => $value) {
            $condition = ['field_id' => $key, 'company_id' => $companyId];
            $data = array_merge($condition, ['info' => ['value' => $value]]);


            CustomFieldValue::updateOrCreate($condition, $data);
        }
    }

    private function extractCustomFields(array $data): array
    {
        $customFields = array_filter($data, function ($key) {
            return strpos($key, 'custom_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $filteredFields = array_reduce(array_keys($customFields), function ($result, $key) use ($customFields) {
            $newKey = str_replace('custom_', '', $key);
            $result[$newKey] = $customFields[$key];
            return $result;
        }, []);

        return $filteredFields;
    }
}
