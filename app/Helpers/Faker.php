<?php

namespace App\Helpers;

final class Faker
{
    public static function getImageUser(): string
    {
        $types = array("women", "men");

        $indice = array_rand($types);
        $id = rand(1, 100);
        return "https://randomuser.me/api/portraits/{$types[$indice]}/{$id}.jpg";
    }
}
