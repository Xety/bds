<?php

namespace BDS\Enums\Selvah;

enum Conformes: string
{
    case Conforme = 'conforme';
    case Non_Conforme = 'non-conforme';
    case Non_Applicable = 'non-applicable';

    public function label(): string
    {
        return match ($this) {
            Conformes::Conforme => 'Conforme',
            Conformes::Non_Conforme => 'Non-Conforme',
            Conformes::Non_Applicable => 'Non-Applicable',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            Conformes::Conforme => '<svg class="inline h-4 w-4 text-success" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path></svg>',
            Conformes::Non_Conforme => '<svg class="inline h-4 w-4 text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>',
            Conformes::Non_Applicable => '<svg class="inline h-7 w-7 text-primary" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M6.87,18.23h1.94v-3.64h0.02l2.05,3.64h1.99v-6.66h-1.94v3.55h-0.02l-1.94-3.55h-2.1V18.23z M13.39,18.38h1.43l2.61-6.97 h-1.42L13.39,18.38z M16.26,18.23h2.07l0.29-0.95h2.12l0.28,0.95h2.13l-2.43-6.66h-2.01L16.26,18.23z M19.07,15.84l0.64-2.04h0.03 l0.6,2.04H19.07z"></path></svg>',
        };
    }
}
