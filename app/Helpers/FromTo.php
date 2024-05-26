<?php

namespace App\Helpers;

use Illuminate\Support\Str;

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

    public static function historyLabel(string $text): string
    {
        $fields = [
            'document' => 'CNPJ',
            'name' => 'Razão Social',
            'trade' => 'Nome Fantasia',
            'phone' => 'Telefone',
            'required' => 'Obrigatorio',
        ];

        return $fields[$text] ?? Str::ucfirst($text);
    }

    public static function status(string $field, ?string $value): ?string
    {
        return match ($field) {
            'status' => $value ? 'Ativo' : 'Inativo',
            'required' => $value ? 'Sim' : 'Não',
            default => $value
        };
    }
}
