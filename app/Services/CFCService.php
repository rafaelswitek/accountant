<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CFCService
{
    private string $url;

    public function __construct()
    {
        $this->url = 'https://www3.cfc.org.br/spw/apis/consultacadastralcfc/CFC';
    }

    public function accountant(int $skip = 0, int $take = 10)
    {
        return $this->makeRequest('ListarProfissional', $skip, $take);
    }

    public function accountancy(int $skip = 0, int $take = 10)
    {
        return $this->makeRequest('ListarEmpresa', $skip, $take);
    }

    private function makeRequest(string $path, int $skip = 0, int $take = 10)
    {
        $sort = urlencode('[{"selector":"Nome","desc":false}]');
        $filter = urlencode('[["SituacaoCadastral","contains","Ativo"]]');

        $response = Http::withHeaders([
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'Accept-Language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Cookie' => '_ga=GA1.1.933943028.1707930081; _ga_38VHCFH9HD=GS1.1.1707930081.1.1.1707930798.0.0.0',
            'DNT' => '1',
            'Pragma' => 'no-cache',
            'Referer' => 'https://www3.cfc.org.br/SPW/ConsultaNacionalCFC/cfc/consultaempresa',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
            'sec-ch-ua' => '"Not A(Brand";v="99", "Google Chrome";v="121", "Chromium";v="121"',
            'sec-ch-ua-mobile' => '?0',
            'sec-ch-ua-platform' => '"Linux"'
        ])->get("{$this->url}/{$path}", [
            'skip' => $skip,
            'take' => $take,
            'requireTotalCount' => true,
            'sort' => $sort,
            'filter' => $filter,
            '_' => 1707962227797,
        ]);

        if (!$response->ok()) {
            throw new \Exception('Erro na requisição');
        }

        return $response->json();
    }
}
