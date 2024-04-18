<?php

namespace App\Http\Controllers;

use App\Models\Accountancy;

class AccountancyController extends Controller
{
    public function getAccountancy()
    {
        return Accountancy::paginate(10);
    }
}
