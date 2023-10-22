@if(is_bool($setting->value))
    {{-- Trick to get all time the input name in the request input even when not checked --}}
    <input type="hidden" name="{{ $setting->key }}" value="0" />
    <x-checkbox
        :name="$setting->key"
        :label="$setting->label"
        :text="$setting->text"
        :checked="$setting->value"
        :label-info="$setting->label_info"
    />
@endif

@if(is_int($setting->value))
    <x-input
        type="number"
        :name="$setting->key"
        :label="$setting->label"
        :value="$setting->value"
        :label-info="$setting->label_info"
    />
@endif

@if(is_float($setting->value))
    <x-input
        type="number"
        :name="$setting->key"
        :label="$setting->label"
        :value="$setting->value"
        :label-info="$setting->label_info"
        step=0.01
    />
@endif

@if(is_string($setting->value))
    <x-textarea
        type="text"
        :name="$setting->key"
        :label="$setting->label"
        :value="$setting->value"
        :label-info="$setting->label_info"
    >{{ $setting->value }}</x-textarea>
@endif
