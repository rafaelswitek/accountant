<?php

namespace App\Http\Controllers;

use App\Models\Accountant;

class AccountantController extends Controller
{
    public function getAccountant()
    {
       return Accountant::paginate(10);
    }
}
