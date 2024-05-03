<?php

namespace App\Helpers;

final class FromTo
{
    public static function colorStatusDeal(string $status): string
    {
        $statusColors = [
            'opened' => 'blue',
            'won' => 'green',
            'lost' => 'red'
        ];

        return $statusColors[$status];
    }

    public static function statusDeal(string $status): string
    {
        $statusColors = [
            'opened' => __('Opened'),
            'won' => __('Won'),
            'lost' => __('Lost')
        ];

        return $statusColors[$status];
    }
}
