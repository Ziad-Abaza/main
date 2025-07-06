@props([
'name',
'label' => null,
'value' => '',
'placeholder' => '',
'required' => false,
'class' => '',
])



<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>
<input type="email" name="{{ $name }}" id="{{ $name }}"
    class="form-control border border-2 border-secondary rounded-2 py-2 px-3 {{ $class }} @error($name) is-invalid @enderror"
    value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $required
    ? 'required' : '' }}>

@error($name)
<div class="invalid-feedback">{{ $message }}</div>
@enderror
