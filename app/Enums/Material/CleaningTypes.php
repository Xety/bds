<?php

namespace BDS\Enums\Material;

enum CleaningTypes: string
{
    case Daily = 'daily';
    case Monthly = 'monthly';
    case Yearly = 'yearly';

    public function label(): string
    {
        return match ($this) {
            CleaningTypes::Daily => 'Jour(s)',
            CleaningTypes::Monthly => 'Mois',
            CleaningTypes::Yearly => 'An(s)'
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

        foreach (CleaningTypes::cases() as $case) {
            $array[] = [
                'id' => $case->value,
                'name' => $case->label(),
            ];
        }
        return $array;
    }
}
