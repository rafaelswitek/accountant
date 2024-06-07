<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use App\Services\EvolutionApi;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class IntegrationController extends Controller
{
    public function __construct(
        private EvolutionApi $evolutionApi
    ) {
    }

    public function index(): View
    {
        $whatsapp = Integration::where('source', 'whatsapp')->first();

        return view('integration.index', [
            'whatsapp' => $whatsapp,
        ]);
    }

    public function createInstance(): JsonResponse
    {
        try {
            $response = $this->evolutionApi->createInstance();

            $whatsapp = Integration::create([
                'source' => 'whatsapp',
                'payload' => [
                    'instanceId' => $response['instance']['instanceId'],
                    'state' => "connecting",
                    'qrCode' => $response['qrcode']['base64'],
                ]
            ]);

            return response()->json($whatsapp);
        } catch (Exception $e) {
            Log::error('Failed to create instance', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Failed to create instance',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getConnectionState(): JsonResponse
    {
        try {
            $response = $this->evolutionApi->getConnectionState();

            $whatsapp = Integration::where('source', 'whatsapp')->first();
            $payload = $whatsapp->payload;
            $payload['state'] = $response['instance']['state'];

            $whatsapp->update([
                'payload' => $payload
            ]);

            return response()->json($whatsapp);
        } catch (Exception $e) {
            Log::error('Failed to get state', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Failed to get state',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
