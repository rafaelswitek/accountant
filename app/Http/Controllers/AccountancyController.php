<?php

namespace App\Http\Controllers;

use App\Models\Accountancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountancyController extends Controller
{
    public function index()
    {
        $name = null;
        $registros = Accountancy::limit(10)->get();
        return view('dashboard', compact('registros', 'name'));
    }

    public function filtrar(Request $request)
    {
        $name = $request->name ?? null;

        return DB::table('accountancies')
            ->where('registry', 'like', "GO%")
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->paginate(10);
    }
}
