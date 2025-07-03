@props([
'name',
'label',
'value' => old($name),
'class' => '',
'min' => null,
'max' => null,
'required' => false,
'note' => null,
])

<label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>
<input type="datetime-local" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" @if($min) min="{{ $min }}"
    @endif @if($max) max="{{ $max }}" @endif
    class="form-control border border-2 border-secondary rounded-2 py-2 px-3 {{ $class }} @error($name) is-invalid @enderror"
    {{ $required ? 'required' : '' }} {{ $attributes }}>

@if ($note)
<small class="text-muted">{{ $note }}</small>
@endif

@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
