<?php

namespace BDS\Enums\Incident;

enum Impacts: string
{
    case Mineur = 'mineur';
    case Moyen = 'moyen';
    case Critique = 'critique';

    public function label(): string
    {
        return match ($this) {
            Impacts::Mineur => 'Mineur',
            Impacts::Moyen => 'Moyen',
            Impacts::Critique => 'Critique'
        };
    }

    public function color(): string
    {
        return match ($this) {
            Impacts::Mineur => 'text-green-500',
            Impacts::Moyen => 'text-yellow-500',
            Impacts::Critique => 'text-red-500',
        };
    }

    public static function toSelectArray(bool $all = true): array
    {
        $array = [];

        if ($all) {
            $array[] = [
                'id' => '',
                'name' => 'Tous les impacts',
            ];
        }

        foreach (Impacts::cases() as $case) {
            $array[] = [
                'id' => $case->value,
                'name' => $case->label(),
            ];
        }
        return $array;
    }
}
