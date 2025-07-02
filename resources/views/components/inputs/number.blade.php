@props([
'name',
'label',
'value' => old($name),
'min' => 0,
'step' => 1,
'placeholder' => '',
'class' => '',
])

<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>

<input type="number" name="{{ $name }}" id="{{ $name }}"
    class="form-control border border-2 border-secondary rounded-2 py-2 px-3 {{ $class }} @error($name) is-invalid @enderror"
    value="{{ old($name, $value) }}" min="{{ $min }}" step="{{ $step }}" placeholder="{{ $placeholder }}" {{ $attributes
    }}>

@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
