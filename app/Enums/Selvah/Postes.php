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
            static::Matin => 'Matin',
            static::Apres_Midi => 'Après-Midi',
            static::Nuit => 'Nuit',
            static::Journee => 'Journée',
        };
    }
}
