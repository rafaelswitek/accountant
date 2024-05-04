<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Stage;

class DealController extends Controller
{
    public function show(int $id)
    {
        $deal = Deal::with('stage')->find($id);
        $stages = Stage::where('funnel_id', $deal->stage->funnel_id)->get();
        return view('deal.show', compact('deal', 'stages'));
    }
}
