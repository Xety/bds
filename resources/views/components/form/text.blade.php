@props([
    'label' => false,
    'name' => '',
    'value' => '',
    'info' => false,
    'infoText' => '',
])

{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
    $hasError = $errors->has($errorName) || ($errors->has('slug') && in_array($errorName, ['title', 'name'])) ? true : false;
@endphp

<div class="form-control">
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

    <input type="text" {{ $name ? 'name=' . $name . ' id=' . $name : '' }} {{ $attributes->merge(['class' => $hasError ? 'input input-bordered input-error w-full' : 'input input-bordered w-full']) }} value="{{ $value ? $value : old($name) }}" />

    @error($errorName)
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror

    @if ($errors->has('slug') && in_array($errorName, ['title', 'name']))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first('slug') }}</span>
        </label>
    @endif
</div>
