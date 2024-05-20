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

    public static function extractInitial($name)
    {
        $words = explode(" ", $name);

        $initials = "";

        if (count($words) == 1) {
            $initials = strtoupper($name[0]) . strtoupper($name[1]);
        } else {
            if (!empty($words[0])) {
                $initials .= strtoupper($words[0][0]);
            }

            if (count($words) > 1 && !empty($words[count($words) - 1])) {
                $initials .= strtoupper($words[count($words) - 1][0]);
            }
        }

        return $initials;
    }
}
