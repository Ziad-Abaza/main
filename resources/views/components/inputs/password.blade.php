@props([
'name',
'label' => '',
'value' => '',
'placeholder' => '',
'required' => false,
])

<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>
{{-- <i class="material-symbols-rounded input-icon">lock_outline</i> --}}
<input type="password" name="{{ $name }}" id="{{ $name }}"
    class="form-control input-outline border rounded-pill px-5 py-3 shadow-sm @error($name) is-invalid @enderror"
    placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }}>


@error($name)
<span class="invalid-feedback">{{ $message }}</span>
@enderror
