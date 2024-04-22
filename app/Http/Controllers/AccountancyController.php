<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountancyController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function get(Request $request)
    {
        $param = $request->param ?? null;
        $state = $request->state ?? null;

        return DB::table('accountancies')
            ->when($state, function ($query) use ($state) {
                return $query->where('registry', 'like', "{$state}%");
            })
            ->when($param, function ($query) use ($param) {
                return $query->where('name', 'like', "%{$param}%");
            })
            ->paginate(10);
    }
}
