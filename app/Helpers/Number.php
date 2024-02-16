<?php

namespace App\Helpers;

final class Number
{
    public static function onlyNumbers(?string $string): string
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}
