<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvolutionApi
{
    private string $url;

    public function __construct()
    {
        $this->url = 'http://localhost:8080';
    }

    public function createInstance(string $instanceName): array
    {
        $data = [
            "instanceName" => $instanceName,
            "token" => env('EVO_TOKEN'),
            "qrcode" => true,
            "mobile" => false,
            "integration" => "WHATSAPP-BAILEYS"
        ];

        return $this->makeRequest('post', 'instance/create', $data);
    }

    public function getConnectionState(string $instanceName): array
    {
        return $this->makeRequest('get', "instance/connectionState/{$instanceName}");
    }

    public function getInstanceByName(string $instanceName): array
    {
        return $this->makeRequest('get', "instance/fetchInstances?instanceName={$instanceName}");
    }

    public function getProfile(string $instanceName, string $number): array
    {
        $data = ['number' => $number];
        return $this->makeRequest('post', "chat/fetchProfile/{$instanceName}", $data);
    }

    public function getMessages(string $instanceName, ?string $number = null): array
    {
        if ($number) {
            $data = [
                "where" => [
                    "key" => [
                        "remoteJid" => $number
                    ]
                ]
            ];
        }
        return $this->makeRequest('post', "chat/findMessages/{$instanceName}", $data);
    }

    public function getContacts(string $instanceName): array
    {
        return $this->makeRequest('post', "chat/findContacts/{$instanceName}");
    }

    public function getChats(string $instanceName): array
    {
        $data = [
            "sort" => [
                "pushName" => true
            ]
        ];
        return $this->makeRequest('post', "chat/findChats/{$instanceName}");
    }

    private function makeRequest(string $method, string $path, array $data = []): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'apikey' => env('EVO_KEY'),
        ];

        try {
            $response = Http::withOptions(["verify" => false])
                ->withHeaders($headers)
                ->$method("{$this->url}/{$path}", $data);

            $this->handleResponseErrors($response);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('HTTP request failed', [
                'method' => $method,
                'url' => "{$this->url}/{$path}",
                'data' => $data,
                'error' => $e->getMessage(),
                'status_code' => $e->getCode(),
            ]);

            throw $e;
        }
    }

    private function handleResponseErrors($response): void
    {
        if ($response->failed()) {
            $status = $response->status();
            if ($status >= 400 && $status < 500) {
                throw new Exception('Client error: ' . $response->body(), $status);
            } elseif ($status >= 500) {
                throw new Exception('Server error: ' . $response->body(), $status);
            } else {
                throw new Exception('Unexpected error: ' . $response->body(), $status);
            }
        }
    }
}
