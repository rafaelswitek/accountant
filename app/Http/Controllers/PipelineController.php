<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Funnel;
use App\Models\Stage;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index(Request $request)
    {
        $funnelId = $request->get('id') ?? 1;
        $funnels = Funnel::all();
        $funnelSelected = Funnel::find($funnelId);
        $stages = Stage::with('deals')->where('funnel_id', $funnelId)->get();
        return view('pipeline.show', compact('funnels', 'stages', 'funnelSelected'));
    }

    public function updateDeal(Request $request)
    {
        $deal = Deal::find($request->get('dealId'));
        $deal->stage_id = $request->get('stageId');
        $deal->update();

        return true;
    }
}
