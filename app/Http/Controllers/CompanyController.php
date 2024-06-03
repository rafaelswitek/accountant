<?php

namespace App\Http\Controllers;

use App\Helpers\Mask;
use App\Models\ChangeHistory;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\RegistrationLog;
use App\Services\CnpjWsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CompanyController extends Controller
{
    public function index(): View
    {
        return view('company.index');
    }

    public function create(): View
    {
        $customFields = $this->getCustomFields(0);
        $changes = [];
        $logCFC =  [];
        $logCNPJWS = [];
        return view('company.edit', compact('customFields', 'changes', 'logCFC', 'logCNPJWS'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();

        $company = new Company;
        $company->fill($data);
        $company->origin = 'Manual';

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $photo = file_get_contents($image);

            $company->photo = $photo;
        }

        $company->save();

        CustomField::updateCustomFields($data, $company->id);

        return redirect()->route('company.index');
    }

    public function list(Request $request): LengthAwarePaginator
    {
        $param = $request->param ?? null;

        return DB::table('companies')
            ->select('id', 'document', 'name', 'trade', 'phone', 'email', 'status', 'keys', 'origin')
            ->when($param, function ($query) use ($param) {
                return $query->where(function ($query) use ($param) {
                    $query->whereRaw('LOWER(document) LIKE LOWER(?)', ["%{$param}%"])
                        ->orWhereRaw('LOWER(name) LIKE LOWER(?)', "%{$param}%")
                        ->orWhereRaw('LOWER(trade) LIKE LOWER(?)', "%{$param}%");
                });
            })
            ->paginate(10);
    }

    public function search(Request $request): array
    {
        $param = explode(' - ', $request->param);
        return Company::select('id', 'document', 'name', 'trade')
            ->when($param[0], function ($query) use ($param) {
                return $query->search($param[0]);
            })
            ->when(isset($param[1]), function ($query) use ($param) {
                return $query->search($param[1]);
            })
            ->limit(100)
            ->get()
            ->toArray();
    }

    public function edit(int $id): View
    {
        $company = Company::findOrFail($id);
        $customFields = $this->getCustomFields($id);
        $changes = ChangeHistory::where('table', 'companies')
            ->where('payload', 'like', '%"id": ' . $id . '%')
            ->get();
        $maskCnpj = Mask::CNPJ($company->document);
        $logCFC = RegistrationLog::where('payload', 'like', '%' . $maskCnpj . '%')->limit(1)->orderByDesc('id')->pluck('payload');
        $logCNPJWS = RegistrationLog::where('payload', 'like', '%' . $company->document . '%')->limit(1)->orderByDesc('id')->pluck('payload');

        return view('company.edit', compact('company', 'customFields', 'changes', 'logCFC', 'logCNPJWS'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->all();

        $company = Company::findOrFail($id);

        DB::transaction(function () use ($company, $data, $request) {
            $old = $company->toArray();
            $company->fill($data);

            if ($request->hasFile('image')) {
                $company->photo = $this->updateImage($request->file('image'));
            }

            $company->save();

            $new = $company->fresh()->toArray();
            $custom = CustomField::updateCustomFields($data, $company->id);

            ChangeHistory::log('companies', array_merge($old, $custom['old']), array_merge($new, $custom['new']));
        });

        return redirect()->route('company.edit', ['id' => $id])->with('status', 'company-updated');
    }

    public function showImage(Request $request)
    {
        $company = Company::find($request->id);

        if (!$company || !$company->photo) {
            $imagePath = public_path('img' . DIRECTORY_SEPARATOR . 'company.png');
            $image = file_get_contents($imagePath);

            return response()->make($image, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="imagem.png"',
            ]);
        }

        return Response::make($company->photo, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="imagem.jpg"',
        ]);
    }

    public function sync(int $id)
    {
        try {
            $company = Company::find($id);
            if ($company->updated_at->diffInDays(Carbon::now()) > 7) {
                $api = new CnpjWsService();
                $result = $api->get($company->document);
                $company->updateFromCNPJWS($result);
                return response()->json($result, 200);
            }

            return response()->json(['message' => 'Já está atualizado'], 406);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function getCustomFields(int $companyId): Collection
    {
        return CustomField::with(['values' => function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        }])->where('status', true)->get();
    }

    private function updateImage($image)
    {
        return file_get_contents($image);
    }
}
