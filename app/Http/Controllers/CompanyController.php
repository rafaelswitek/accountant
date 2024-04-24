<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
                    $query->where('document', 'like',"%{$param}%")
                        ->orWhere('name', 'like',"%{$param}%")
                        ->orWhere('trade', 'like',"%{$param}%");
                });
            })
            ->paginate(10);
    }

    public function show(int $id)
    {
        $company = Company::find($id);
        return view('company.show', $company);
    }
}
