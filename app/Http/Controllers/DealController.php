<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DealController extends Controller
{
    public function show(int $id)
    {
        $deal = Deal::with('stage')->find($id);
        $stages = Stage::where('funnel_id', $deal->stage->funnel_id)->get();
        $funnels = Stage::with('funnel')->orderBy('funnel_id')->get();
        return view('deal.show', compact('deal', 'stages', 'funnels'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();

        $deal = Deal::find($id);
        $deal->name = $data['dealName'] ?? $deal->name;
        $deal->stage_id = $data['stageId'] ?? $deal->stage_id;
        $deal->status = $data['dealStatus'] ?? $deal->status;
        $deal->save();

        return Redirect::route('pipeline.deal', compact('id'))->with('status', 'deal-updated');
    }
}
