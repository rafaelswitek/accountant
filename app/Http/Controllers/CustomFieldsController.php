<?php

namespace App\Http\Controllers;

use App\Models\ChangeHistory;
use App\Models\CustomField;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomFieldsController extends Controller
{
    public function index(): View
    {
        return view('fields.index');
    }

    public function create(): View
    {
        $changes = [];
        return view('fields.edit', compact('changes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $field = new CustomField;
        $field->status = (bool) $request->status;
        $field->info = [
            'type' => $request->type,
            'label' => $request->label,
            'required' => $request->required,
            'placeholder' => $request->placeholder,
        ];
        $field->save();

        return Redirect::route('fields.index');
    }

    public function list(Request $request): LengthAwarePaginator
    {
        $param = $request->param;

        return CustomField::when($param, function ($query) use ($param) {
            return $query->whereRaw('LOWER(info) LIKE LOWER(?)', ["%{$param}%"]);
        })->paginate(10);
    }

    public function edit(int $id): View
    {
        $fields = CustomField::findOrFail($id);
        $changes = ChangeHistory::where('table', 'custom_fields')
            ->where('payload', 'like', '%"id": ' . $id . '%')
            ->get();

        return view('fields.edit', compact('fields', 'changes'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $field = CustomField::findOrFail($id);
        $old = $field->toArray();
        $field->status = (bool) $request->status;
        $field->info = [
            'type' => $request->type,
            'label' => $request->label,
            'required' => $request->required,
            'placeholder' => $request->placeholder,
        ];
        $field->update();

        $new = $field->toArray();

        $old = [
            'id' => $old['id'],
            'status' => $old['status'],
            'label' => $old['info']->label,
            'required' => $old['info']->required,
            'placeholder' => $old['info']->placeholder,
        ];
        $new = [
            'id' => $new['id'],
            'status' => $new['status'],
            'label' => $new['info']->label,
            'required' => $new['info']->required,
            'placeholder' => $new['info']->placeholder,
        ];

        ChangeHistory::log('custom_fields', $old, $new);

        return Redirect::route('fields.edit', compact('id'))->with('status', 'field-updated');
    }
}
