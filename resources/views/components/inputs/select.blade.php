@props([
'name',
'label',
'options' => [],
'placeholder' => 'Select an option',
'value' => old($name),
'class' => '',
'multiple' => false,
'selected' => null,
'size' => null,
])

@php
$inputClasses = "form-select border border-2 border-secondary rounded-2 py-2 px-3 {$class}";
if ($errors->has($name)) {
$inputClasses .= ' is-invalid';
}

$isMultiple = $multiple ? true : str_ends_with($name, '[]');

if ($isMultiple && !is_array($value)) {
$value = (array) $value;
}

// Handle selected attribute if provided
if ($selected !== null) {
    $value = $selected;
}

// Set size for multiple selects to show more options
if ($isMultiple && $size === null) {
    $size = min(count($options), 8); // Show up to 8 options, but not more than available
}
@endphp

<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>

@php
// Safely handle attributes to prevent trim() errors
$safeAttributes = collect();
foreach ($attributes as $key => $value) {
    if (is_array($value)) {
        // Skip array values or convert them to string representation
        continue;
    } elseif (is_string($value)) {
        $safeAttributes->put($key, $value);
    } else {
        // Convert other types to string
        $safeAttributes->put($key, (string) $value);
    }
}
@endphp

<select name="{{ $name }}" id="{{ $name }}" {{ $safeAttributes->merge(['class' => $inputClasses]) }}
    {{ $isMultiple ? 'multiple' : '' }}
    {{ $size ? "size=\"{$size}\"" : '' }}>

    @unless($isMultiple)
    <option value="">{{ $placeholder }}</option>
    @endunless

    @foreach ($options as $key => $option)
    <option value="{{ $key }}" {{ $isMultiple ? (in_array($key, $value) ? 'selected' : '' ) : ($value==$key ? 'selected'
        : '' ) }}>
        {{ $option }}
    </option>
    @endforeach
</select>

@if($isMultiple)
<div class="form-text mt-1">
    <small class="text-muted">
        <i class="material-symbols-rounded fs-6 me-1">info</i>
        Hold Ctrl (or Cmd on Mac) to select multiple courses
    </small>
</div>
@endif

@error($name)
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror
