<?php

namespace App\Http\Controllers;

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
        return view('fields.edit');
    }

    public function store(Request $request): RedirectResponse
    {
        $field = new CustomField;
        $field->status = $request->status;
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

        return view('fields.edit', compact('fields'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $field = CustomField::findOrFail($id);
        $field->status = $request->status;
        $field->info = [
            'type' => $request->type,
            'label' => $request->label,
            'required' => $request->required,
            'placeholder' => $request->placeholder,
        ];
        $field->update();

        return Redirect::route('fields.edit', compact('id'))->with('status', 'field-updated');
    }
}
