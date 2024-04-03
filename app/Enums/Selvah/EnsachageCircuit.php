<?php

namespace BDS\Enums\Selvah;

enum EnsachageCircuit: string
{
    case BPF1 = 'bpf1';
    case BPF2 = 'bpf2';
    case Big_Bag = 'big-bag';
    case Non_Applicable = 'non-applicable';

    public function label(): string
    {
        return match ($this) {
            static::BPF1 => 'BPF1',
            static::BPF2 => 'BPF2',
            static::Big_Bag => 'Big-Bag',
            static::Non_Applicable => 'Non-Applicable',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            static::BPF1 => 'BPF1',
            static::BPF2 => 'BPF2',
            static::Big_Bag => 'Big-Bag',
            static::Non_Applicable => '<svg class="inline h-7 w-7 text-primary" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M6.87,18.23h1.94v-3.64h0.02l2.05,3.64h1.99v-6.66h-1.94v3.55h-0.02l-1.94-3.55h-2.1V18.23z M13.39,18.38h1.43l2.61-6.97 h-1.42L13.39,18.38z M16.26,18.23h2.07l0.29-0.95h2.12l0.28,0.95h2.13l-2.43-6.66h-2.01L16.26,18.23z M19.07,15.84l0.64-2.04h0.03 l0.6,2.04H19.07z"></path></svg>',
        };
    }
}
