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

    public function accountant(string $uf, int $skip = 0, int $take = 10)
    {
        return $this->makeRequest('ListarProfissional', $uf, $skip, $take);
    }

    public function accountancy(string $uf, int $skip = 0, int $take = 10)
    {
        return $this->makeRequest('ListarEmpresa', $uf, $skip, $take);
    }

    private function makeRequest(string $path, string $uf, int $skip, int $take)
    {
        $sort = urlencode('[{"selector":"Nome","desc":false}]');
        $filter = urlencode("[['EstadoConselho','contains','{$uf}'],'and',['SituacaoCadastral','contains','Ativo']]");

        $response = Http::get("{$this->url}/{$path}?requireTotalCount=true&skip={$skip}&take={$take}&sort={$sort}&filter={$filter}");

        if (!$response->ok()) {
            throw new \Exception('Erro na requisição');
        }

        return $response->json();
    }
}
