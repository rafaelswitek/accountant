<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CnpjWsService
{
    private string $url;

    public function __construct()
    {
        $this->url = 'https://comercial.cnpj.ws/cnpj';
    }

    public function get(string $document)
    {
        return $this->makeRequest($document);
    }

    private function makeRequest(string $path)
    {
        $headers = [
            'x_api_token' => env('CNPJ_WS'),
        ];

        $response = Http::withOptions(["verify" => false])
            ->withHeaders($headers)
            ->get("{$this->url}/{$path}");

        if (!$response->ok()) {
            throw new \Exception('Erro na requisição');
        }

        return $response->json();
    }
}
