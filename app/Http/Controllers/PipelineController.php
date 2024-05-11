<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Deal;
use App\Models\Funnel;
use App\Models\Stage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PipelineController extends Controller
{
    public function index(Request $request)
    {
        $funnelId = $request->get('id') ?? 1;
        $funnelSelected = Funnel::find($funnelId);

        if (!$funnelSelected) {
            return Redirect::route('pipeline.index');
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

    public function create()
    {
        return view('pipeline.store');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'stages' => 'array',
                'stages.*' => 'string|distinct',
            ]);

            return DB::transaction(function () use ($request) {
                $funnel = Funnel::create($request->only('name'));

                $stages = collect($request->input('stages'))->map(function ($stage, $order) use ($funnel) {
                    return ['funnel_id' => $funnel->id, 'order' => $order, 'name' => $stage];
                });

                $funnel->stages()->createMany($stages->toArray());

                return redirect()->route('pipeline', ['id' => $funnel->id]);
            });
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while saving the funnel: ' . $e->getMessage());
        }
    }

    public function updateDeal(Request $request)
    {
        $deal = Deal::find($request->get('dealId'));
        $deal->stage_id = $request->get('stageId');
        $deal->update();

        return true;
    }
}
