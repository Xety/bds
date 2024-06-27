<?php

namespace BDS\Enums\Maintenance;

enum Types: string
{
    case Curative = 'curative';
    case Preventive = 'preventive';

    public function label(): string
    {
        return match ($this) {
            Types::Curative => 'Curative',
            Types::Preventive => 'Préventive'
        };
    }

    public function color(): string
    {
        return match ($this) {
            Types::Curative => 'text-red-500',
            Types::Preventive => 'text-green-500'
        };
    }

    public static function toSelectArray(bool $all = true): array
    {
        $array = [];

        if ($all) {
            $array[] = [
                'id' => '',
                'name' => 'Tous les types',
            ];
        }

        foreach (Types::cases() as $case) {
            $array[] = [
                'id' => $case->value,
                'name' => $case->label(),
            ];
        }
        return $array;
    }
}
