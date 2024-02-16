<?php

namespace App\Http\Controllers;

use App\Models\Accountancy;
use App\Services\ReadTXTService;

class AccountancyController extends Controller
{
    public function getAccountancy()
    {
        $txtService = new ReadTXTService();
        $result = $txtService->readFile('app/contabilidades.txt');

        Accountancy::storeFromCFC($result['data']);

        return Accountancy::paginate(10);
    }
}
