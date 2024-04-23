<?php

namespace BDS\Enums\Selvah;

enum Postes: string
{
    case Matin = 'matin';
    case Apres_Midi = 'apres-midi';
    case Nuit = 'nuit';
    case Journee = 'journee';

    public function label(): string
    {
        return match ($this) {
            Postes::Matin => 'Matin',
            Postes::Apres_Midi => 'Après-Midi',
            Postes::Nuit => 'Nuit',
            Postes::Journee => 'Journée',
        };
    }

    public static function toSelectArray(): array
    {
        $array[] = [
            'id' => '',
            'name' => 'Tous les postes',
        ];

        foreach (Postes::cases() as $case) {
            $array[] = [
                'id' => $case->value,
                'name' => $case->label(),
            ];
        }
        return $array;
    }
}
