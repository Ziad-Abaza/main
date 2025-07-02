@props([
'name',
'label',
'rows' => 3,
'value' => old($name),
'placeholder' => '',
'class' => '',
])

<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>
<textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
    class="form-control border border-2 border-secondary rounded-2 py-2 px-3 {{ $class }} @error($name) is-invalid @enderror"
    placeholder="{{ $placeholder }}" {{ $attributes }}>{{ old($name, $value) }}</textarea>

@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
