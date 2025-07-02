@props([
'name',
'value' => 1,
'label' => '',
'id' => Str::uuid(),
'checked' => false,
'required' => false,
])

<div class="form-check">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }} {{
        $required ? 'required' : '' }} {{ $attributes->class(['form-check-input']) }}
    >
    @if($label)
    <label for="{{ $id }}" class="form-check-label">
        {{ $label }}
    </label>
    @endif
</div>
