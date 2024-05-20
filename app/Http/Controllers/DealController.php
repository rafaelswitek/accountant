<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CustomField;
use App\Models\Deal;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Redirect;

class DealController extends Controller
{
    public function show(int $id)
    {
        $deal = Deal::with(['stage', 'company:id,document,name,trade,phone,email'])->find($id);
        $stages = Stage::where('funnel_id', $deal->stage->funnel_id)->get();
        $funnels = Stage::with('funnel')->orderBy('funnel_id')->get();
        $customFields = $this->getCustomFields($deal->company_id);
        $scheduled = Activity::where('finished', false)->get();
        $completed = Activity::where('finished', true)->get();

        return view('deal.show', compact('deal', 'stages', 'funnels', 'customFields', 'scheduled', 'completed'));
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $stage = Stage::find($data['dealStageId']);

        Deal::create([
            'stage_id' => $data['dealStageId'],
            'user_id' => auth()->user()->id,
            'company_id' => $data['dealCompanyId'],
            'name' => $data['dealName'],
        ]);

        return Redirect::route('pipeline.index', ['id' => $stage->funnel_id]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();

        $deal = Deal::find($id);
        $deal->name = $data['dealName'] ?? $deal->name;
        $deal->stage_id = $data['stageId'] ?? $deal->stage_id;
        $deal->status = $data['dealStatus'] ?? $deal->status;
        $deal->save();

        return Redirect::route('pipeline.deal', compact('id'))->with('status', 'deal-updated')->with('message', __('Saved.'));
    }

    public function destroy(int $id)
    {
        $deal = Deal::find($id);
        $deal->delete();

        return Redirect::route('pipeline.index');
    }

    private function getCustomFields(int $companyId): Collection
    {
        return CustomField::with(['values' => function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        }])->where('status', true)->get();
    }
}
