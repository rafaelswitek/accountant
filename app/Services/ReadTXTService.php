<?php

namespace App\Services;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

use Exception;

class ReadTXTService
{
    public function readFile(string $path)
    {
        $filePath = storage_path($path);
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);

        if ($data === null) {
            throw new Exception('Erro ao decodificar o JSON');
        }

        return $data;
    }
}
