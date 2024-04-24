<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function get(Request $request): LengthAwarePaginator
    {
        $param = $request->param ?? null;
        $state = $request->state ?? null;

        return DB::table('companies')
            ->when($param, function ($query) use ($param) {
                return $query->where(function ($query) use ($param) {
                    $query->where('document', 'like', "%{$param}%")
                        ->orWhere('name', 'like', "%{$param}%")
                        ->orWhere('trade', 'like', "%{$param}%");
                });
            })
            ->paginate(10);
    }

    public function show(int $id): View
    {
        $company = Company::find($id);
        $customFields = $this->getCustomFields($id);

        return view('company.show', compact('company', 'customFields'));
    }

    public function update(Request $request, int $id): View
    {
        $data = $request->all();

        $company = Company::find($id);
        $company->fill($data);
        $company->update();

        $this->updateCustomFields($id, $data);

        $customFields = $this->getCustomFields($id);

        return view('company.show', compact('company', 'customFields'));
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
