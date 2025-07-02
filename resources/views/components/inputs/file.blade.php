@props([
'name',
'label',
'accept' => '*',
'class' => '',
'note' => null,
'old' => null,
])

<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>
<input type="file" name="{{ $name }}" id="{{ $name }}"
    class="form-control border border-2 border-secondary rounded-2 py-2 px-3 {{ $class }} @error($name) is-invalid @enderror"
    accept="{{ $accept }}" {{ $attributes }}>
@if ($note)
<small class="text-muted">{{ $note }}</small>
@endif

@error($name)
<div class="invalid-feedback">{{ $message }}</div>
@enderror
