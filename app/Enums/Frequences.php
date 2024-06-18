<?php

namespace BDS\Enums;

enum Frequences: string
{
    case Daily = 'daily';
    case Weekly = 'weekly';
    case Bimonthly = 'bimonthly';
    case Monthly = 'monthly';
    case Quarterly = 'quarterly';
    case Biannual = 'biannual';
    case Annual = 'annual';
    case Casual = 'casual';

    public function label(): string
    {
        return match ($this) {
            Frequences::Daily => 'Journalier',
            Frequences::Weekly => 'Hebdomadaire',
            Frequences::Bimonthly => 'Bi-mensuel',
            Frequences::Monthly => 'Mensuel',
            Frequences::Quarterly => 'Trimestrielle',
            Frequences::Biannual => 'Bi-annuel',
            Frequences::Annual => 'Annuel',
            Frequences::Casual => 'Occasionnel',
        };
    }

    public static function toSelectArray(bool $all = true): array
    {
        if ($all) {
            $array[] = [
                'id' => '',
                'name' => 'Toutes les fréquences',
            ];
        }

        foreach (Frequences::cases() as $case) {
            $array[] = [
                'id' => $case->value,
                'name' => $case->label(),
            ];
        }
        return $array;
    }
}
