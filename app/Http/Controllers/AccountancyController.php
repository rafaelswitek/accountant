<?php

namespace App\Http\Controllers;

use App\Models\Accountancy;
use App\Services\CFCService;

class AccountancyController extends Controller
{
    public function getAccountancy()
    {
        $skip = 0;
        $take = 10;

        $service = new CFCService();

        do {
            $result = $service->accountancy('AC', $skip, $take);
            Accountancy::storeFromCFC($result['data']);
            $skip += $take;
        } while ($skip <= $result['totalCount']);
    }
}
