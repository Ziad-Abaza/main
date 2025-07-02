@props([
'name',
'label' => null,
'value' => old($name),
'placeholder' => '',
'class' => '',
])

@if($label !== null)
<label for="{{ $name }}" class="form-label fw-bold text-dark">{{ $label }}</label>
@endif
<input type="text" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
    class="form-control border border-2 border-secondary rounded-2 py-2 px-3 {{ $class }} @error($name) is-invalid @enderror"
    {{ $attributes }}>


@error($name)
<div class="invalid-feedback d-block mt-1">
    {{ $message }}
</div>
@enderror
