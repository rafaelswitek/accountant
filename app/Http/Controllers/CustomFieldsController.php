<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CustomFieldsController extends Controller
{
    public function index(): View
    {
        return view('fields.index');
    }
}
