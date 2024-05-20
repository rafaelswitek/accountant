<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
{
    public function store(Request $request, string $id): RedirectResponse
    {
        $activity = new Activity();
        $activity->user_id = auth()->user()->id;
        $activity->deal_id = $id;
        $activity->title = $request->activityTitle;
        $activity->description = $request->activityDescription;
        $activity->date = Carbon::createFromFormat('d/m/Y H:i', "{$request->activityDate} {$request->activityTime}");
        $activity->finished = isset($request->activityFinished) ? 1 : 0;

        $activity->save();

        return Redirect::route('pipeline.deal', compact('id'));
    }
}
