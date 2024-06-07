<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EvolutionApi
{
    private string $url;

    public function __construct()
    {
        $this->url = 'http://localhost:8080';
    }

    public function createInstance()
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

    public function getConnectionState()
    {
        return $this->makeRequest('get', 'instance/connectionState/Teste');
    }

    private function makeRequest(string $method, string $path, array $data = [])
    {
        $headers = [
            'Content-Type' => 'application/json',
            'apikey' => env('EVO_KEY'),
        ];

        $response = Http::withOptions(["verify" => false])
            ->withHeaders($headers)
            ->$method("{$this->url}/{$path}", $data);

        if (!$response->successful()) {
            return response($response->json() ?? 'Erro não identificado', $response->status() ?? 500);
        }

        return $response->json();
    }
}
