<?php

namespace App\Helpers;

class Mask
{
    public static function CnjpOuCpf($str)
    {
        return strlen($str) > 11 ? self::CNPJ($str) : self::CPF($str);
    }

    public static function CPF($str)
    {
        $mask = '###.###.###-##';
        return Mask::handle($mask, $str);
    }

    public static function CNPJ($str)
    {
        $mask = '##.###.###/####-##';
        return Mask::handle($mask, $str);
    }

    public static function CEP($str)
    {
        $mask = '##.###-###';
        return Mask::handle($mask, $str);
    }

    public static function Telefone($str)
    {
        $mask = strlen($str) == 11 ? '(##) #####-####' : '(##) ####-####';
        return Mask::handle($mask, $str);
    }

    public static function handle($mask, $str)
    {
        if (empty($str)) return null;
        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;
    }
}
