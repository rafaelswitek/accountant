<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function get(Request $request)
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

    public function show(int $id)
    {
        $customFields = CustomField::with(['values' => function ($query) use ($id) {
            $query->where('company_id', $id);
        }])->where('status', true)->get();
        $company = Company::find($id);

        return view('company.show', compact('company', 'customFields'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();

        $customFields = array_filter($data, function ($key) {
            return strpos($key, 'custom_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $filteredFields = array_reduce(array_keys($customFields), function ($result, $key) use ($customFields) {
            $newKey = str_replace('custom_', '', $key);
            $result[$newKey] = $customFields[$key];
            return $result;
        }, []);


        $company = Company::find($id);
        $company->fill($data);
        $company->update();

        foreach ($filteredFields as $key => $value) {
            $data = [
                'field_id' => $key,
                'company_id' => $id,
                'info' => ['value' => $value],
            ];

            $condition = ['field_id' => $key, 'company_id' => $id];

            $product = CustomFieldValue::updateOrCreate($condition, $data);
        }

        $customFields = CustomField::with(['values' => function ($query) use ($id) {
            $query->where('company_id', $id);
        }])->where('status', true)->get();

        return view('company.show', compact('company', 'customFields'));
    }
}
