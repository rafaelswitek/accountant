<?php

namespace App\Http\Controllers;

use App\Models\Deal;

class DealController extends Controller
{
    public function show(int $id)
    {
        $deal = Deal::find($id);
        return view('deal.show', compact('deal'));
    }
}
