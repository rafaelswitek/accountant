<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Deal;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $companiesCounts = Company::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $dealsCounts = Deal::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $companyActives = $companiesCounts[0] ?? 0;
        $companyInactives = $companiesCounts[1] ?? 0;

        $dealWon = $dealsCounts['won'] ?? 0;
        $dealLost = $dealsCounts['lost'] ?? 0;
        $dealOpened = $dealsCounts['opened'] ?? 0;

        $stats = [
            ['title' => 'Negócios em aberto', 'data' => $dealOpened],
            ['title' => 'Negócios ganhos', 'data' => $dealWon],
            ['title' => 'Negócios perdidos', 'data' => $dealLost],
            ['title' => 'Total de negócios', 'data' => array_sum($dealsCounts)],

            ['title' => 'Empresas ativas', 'data' => $companyActives],
            ['title' => 'Empresas inativas', 'data' => $companyInactives],
            ['title' => 'Total de empresas', 'data' => array_sum($companiesCounts)],
        ];

        return view('dashboard', compact('stats'));
    }
}
