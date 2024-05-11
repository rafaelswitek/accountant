<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Deal;
use App\Models\Funnel;
use App\Models\Stage;
use Exception;
use Illuminate\Contracts\View\View;
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
        return view('pipeline.create');
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

                return redirect()->route('pipeline.index', ['id' => $funnel->id]);
            });
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while saving the funnel: ' . $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'stages' => 'required|array',
                'stages.*' => 'string|required|distinct',
            ]);

            $funnel = Funnel::find($id);

            return DB::transaction(function () use ($request, $funnel) {
                $funnel->update($request->only('name'));

                $existingStages = $funnel->stages()->pluck('id')->toArray();

                foreach ($request->input('stages') as $order => $stage) {
                    $stageModel = Stage::updateOrCreate(
                        ['funnel_id' => $funnel->id, 'order' => $order],
                        ['name' => $stage]
                    );

                    $key = array_search($stageModel->id, $existingStages);
                    if ($key !== false) {
                        unset($existingStages[$key]);
                    }
                }

                Stage::destroy($existingStages);

                return redirect()->route('pipeline.index', ['id' => $funnel->id])->with('success', 'Funnel updated successfully.');
            });
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $id): View
    {
        $funnel = Funnel::find($id);
        $stages = Stage::where('funnel_id', $id)->get();

        return view('pipeline.create', compact('funnel', 'stages'));
    }

    public function updateDeal(Request $request)
    {
        $deal = Deal::find($request->get('dealId'));
        $deal->stage_id = $request->get('stageId');
        $deal->update();

        return true;
    }
}
