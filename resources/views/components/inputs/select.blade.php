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

// دعم multiple
$isMultiple = $multiple || str_ends_with($name, '[]');

// اجعل القيمة Array إذا كان select متعدد
if ($isMultiple && !is_array($value)) {
$value = (array) $value;
}

// إذا تم تمرير selected يدويًا
if ($selected !== null) {
$value = $selected;
}

// تحديد الحجم المناسب للمضاعف
if ($isMultiple && $size === null) {
$size = min(count($options), 8); // حتى 8 خيارات فقط
}

// التأكد من تنسيق الـ attributes لمنع مشاكل htmlspecialchars
$safeAttributes = collect();
foreach ($attributes as $key => $val) {
if (is_array($val)) continue;
$safeAttributes->put($key, is_string($val) ? $val : (string) $val);
}
@endphp

<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>

<select name="{{ $name }}{{ $isMultiple && !str_ends_with($name, '[]') ? '[]' : '' }}" id="{{ $name }}" {{
    $safeAttributes->merge(['class' => $inputClasses]) }}
    {{ $isMultiple ? "multiple size={$size}" : '' }}
    >
    @unless($isMultiple)
    <option value="">{{ $placeholder }}</option>
    @endunless

    @foreach ($options as $key => $option)
    <option value="{{ $key }}" {{ $isMultiple ? (in_array((string)$key, (array)old($name, $value)) ? 'selected' : '' ) :
        ((string)old($name, $value)===(string)$key ? 'selected' : '' ) }}>
        {{ $option }}
    </option>
    @endforeach
</select>

@if ($isMultiple)
<div class="form-text mt-1">
    <small class="text-muted">
        <i class="material-symbols-rounded fs-6 me-1">info</i>
        Hold Ctrl (or Cmd on Mac) to select multiple options
    </small>
</div>
@endif

@error($name)
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror
