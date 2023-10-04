@props([
    'label' => false,
    'name' => '',
    'value' => '',
    'info' => false,
    'infoText' => '',
    'join' => false,
    'joinIcon' => '',
])

{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
    $hasError = $errors->has($errorName) || ($errors->has('slug') && in_array($errorName, ['title', 'name'])) ? true : false;
@endphp

<div
    x-data="{ value: @entangle($attributes->wire('model')) }"
    x-on:change="value = $event.target.value"
    x-init="flatpickr($refs.input, {disableMobile: true, enableTime: true, dateFormat: 'd-m-Y H:i', time_24hr: true, monthSelectorType: 'static', prevArrow: '{{ "<svg class=\"fill-current\" width=\"7\" height=\"11\" viewBox=\"0 0 7 11\"><path d=\"M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z\" /></svg>" }}', nextArrow: '{{ "<svg class=\"fill-current\" width=\"7\" height=\"11\" viewBox=\"0 0 7 11\"><path d=\"M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z\" /></svg>" }}', defaultDate: '{{ $value ? $value : \Carbon\Carbon::now()->format('d-m-Y H:i') }}' })"
    class="form-control w-full"
>
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
            @if ($info == true)
                <span class="label-text-alt">
                    <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                        <label tabindex="0" class="hover:cursor-pointer text-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </label>
                        <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                            <div class="card-body">
                                <p>{!! $infoText !!}</p>
                            </div>
                        </div>
                    </div>
                </span>
            @endif
        </label>
    @endif

    @if ($join == true)
        <div class="join">
            <button class="btn btn-disabled join-item"><i class="{{ $joinIcon }} dark:text-current"></i></button>
    @endif

    <input
        {{ $attributes->whereDoesntStartWith('wire:model') }}
        x-ref="input"
        x-bind:value="value"
        type="text"
        {{ $attributes->merge(['class' => $hasError ? 'input input-bordered input-error join-item w-full' : 'input input-bordered join-item w-full']) }}
        value="{{ $value ? $value : old($name) }}"
    />

    @if ($join == true)
        </div>
    @endif

    @error($errorName)
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror


</div>