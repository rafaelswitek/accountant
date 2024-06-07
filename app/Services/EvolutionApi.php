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

    public function createInstance(): array
    {
        $data = [
            "instanceName" => "Teste",
            "token" => env('EVO_TOKEN'),
            "qrcode" => true,
            "mobile" => false,
            "integration" => "WHATSAPP-BAILEYS"
        ];

        return $this->makeRequest('post', 'instance/create', $data);
    }

    public function getConnectionState(): array
    {
        return $this->makeRequest('get', 'instance/connectionState/Teste');
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
