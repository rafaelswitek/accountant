<?php

namespace App\Http\Controllers;

use App\Helpers\Mask;
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
            'whatsapp' => $whatsapp->payload,
        ]);
    }

    public function createInstance(): JsonResponse
    {
        try {
            $response = $this->evolutionApi->createInstance(auth()->user()->email);

            $whatsapp = Integration::where('source', 'whatsapp')->first();
            $payload = $whatsapp->payload;

            $payload->state = $response['instance']['state'] ?? $payload->state;
            $payload->qrCode = $response['qrcode']['base64'] ?? $payload->qrCode;
            $payload->instance->id = $response['instance']['instanceId'] ?? $payload->instance->id;
            $payload->instance->name = $response['instance']['instanceName'] ?? $payload->instance->name;

            $whatsapp->update([
                'payload' => $payload
            ]);

            return response()->json($whatsapp->payload);
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
            $whatsapp = Integration::where('source', 'whatsapp')->first();
            $payload = $whatsapp->payload;

            $response = $this->evolutionApi->getConnectionState($payload->instance->name);

            $payload->state = $response['instance']['state'] ?? $payload->state;

            if ($payload->state == 'open') {
                $payload->qrCode = null;
                try {
                    $this->getProfileData($payload);
                } catch (Exception $e) {
                    Log::error('Failed to get profile', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }

            $whatsapp->update([
                'payload' => $payload
            ]);

            return response()->json($whatsapp->payload);
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

    public function getMessages(): JsonResponse
    {
        try {
            $whatsapp = Integration::where('source', 'whatsapp')->first();
            $payload = $whatsapp->payload;

            $response = $this->evolutionApi->getMessages($payload->instance->name);

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Failed to get messages', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Failed to get messages',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getContacts(): View
    {
        $whatsapp = Integration::where('source', 'whatsapp')->first();
        $payload = $whatsapp->payload;

        $response = $this->evolutionApi->getContacts($payload->instance->name);

        return view('integration.contacts', [
            'contacts' => $response,
        ]);
    }

    public function getChats(): View
    {
        $whatsapp = Integration::where('source', 'whatsapp')->first();
        $payload = $whatsapp->payload;

        $response = $this->evolutionApi->getChats($payload->instance->name);

        return view('integration.chats', [
            'chats' => $response,
        ]);
    }

    private function getProfileData(object &$payload): void
    {
        $response = $this->evolutionApi->getInstanceByName($payload->instance->name);
        if (is_array($response) && isset($response[0]['instance'])) {
            $instance = $response[0]['instance'];

            $payload->user->number = Mask::numberFromOwner($instance['owner']) ?? $payload->user->number;
            $payload->user->picture = $instance['profilePictureUrl'] ?? $payload->user->picture;
            $payload->user->status = $instance['profileStatus'] ?? $payload->user->status;
            $payload->user->name = $instance['profileName'] ?? $payload->user->name;
        }
    }
}
