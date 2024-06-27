<?php

namespace BDS\Enums\Maintenance;

enum Realizations: string
{
    case Internal = 'internal';
    case External = 'external';
    case Both = 'both';

    public function label(): string
    {
        return match ($this) {
            Realizations::Internal => 'Interne',
            Realizations::External => 'Externe',
            Realizations::Both => 'Interne et Externe'
        };
    }

    public function color(): string
    {
        return match ($this) {
            Realizations::Internal => 'text-green-500',
            Realizations::External => 'text-red-500',
            Realizations::Both => 'text-yellow-500',
        };
    }

    public static function toSelectArray(bool $all = true): array
    {
        $array = [];

        if ($all) {
            $array[] = [
                'id' => '',
                'name' => 'Toutes les réalisations',
            ];
        }

        foreach (Realizations::cases() as $case) {
            $array[] = [
                'id' => $case->value,
                'name' => $case->label(),
            ];
        }
        return $array;
    }
}
