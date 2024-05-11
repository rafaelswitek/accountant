<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Deal;
use App\Models\Funnel;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PipelineController extends Controller
{
    public function index(Request $request)
    {
        $funnelId = $request->get('id') ?? 1;
        $funnelSelected = Funnel::find($funnelId);

        if (!$funnelSelected) {
            return Redirect::route('pipeline');
        }

        $status = $request->get('status') ?? 'opened';

        $funnels = Funnel::all();
        $stages = Stage::with(['deals' => function ($query) use ($status) {
            if ($status && $status != 'all') {
                $query->where('status', $status);
            }
        }])->where('funnel_id', $funnelId)->get();
        $companies = Company::limit(10)->get();
        $stageFunnels = Stage::with('funnel')->orderBy('funnel_id')->get();

        return view('pipeline.show', compact('funnels', 'stages', 'funnelSelected', 'companies', 'stageFunnels', 'status'));
    }

    public function updateDeal(Request $request)
    {
        $deal = Deal::find($request->get('dealId'));
        $deal->stage_id = $request->get('stageId');
        $deal->update();

        return true;
    }
}
