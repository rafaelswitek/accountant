<?php

namespace App\Http\Controllers;

use App\Services\EvolutionApi;
use Illuminate\Contracts\View\View;

class IntegrationController extends Controller
{
    public function __construct(
        private EvolutionApi $evolutionApi
    ) {
    }

    public function index(): View
    {
        return view('integration.index', [
            'integrated' => true,
            'showQrCode' => true,
        ]);
    }

    public function createInstance()
    {
        return $this->evolutionApi->createInstance();
    }

    public function getConnectionState()
    {
        return $this->evolutionApi->getConnectionState();
    }
}
