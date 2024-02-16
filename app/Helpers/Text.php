<?php

namespace App\Helpers;

final class Text
{
    public static function sanitize(string $string): string
    {
        $string = preg_replace('/[\x00-\x1F\x7F]/u', '', $string);
        $string = trim($string);

        return $string;
    }
}
