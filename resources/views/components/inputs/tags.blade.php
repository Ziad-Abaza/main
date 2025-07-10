@props([
'name',
'label' => 'Tags',
'value' => '',
'placeholder' => 'Add a tag...',
])

@php
$initialTags = old($name, $value);
$initialTags = is_array($initialTags) ? $initialTags : array_filter(array_map('trim', explode(',', $initialTags)));
@endphp

<div class="mb-4">
    <label for="{{ $name }}" class="form-label fw-bold">{{ $label }}</label>

    <!-- Input + Add Button -->
    <div class="d-flex mb-2 gap-2">
        <input type="text" id="{{ $name }}-input" class="form-control form-control-sm" placeholder="{{ $placeholder }}"
            onkeypress="handleTagKeyPress(event, '{{ $name }}')">
        <button type="button" class="btn btn-dark btn-sm" onclick="addTag('{{ $name }}')">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <!-- Tags Display -->
    <div id="{{ $name }}-tags" class="d-flex flex-wrap gap-2 mb-2">
        @foreach ($initialTags as $tag)
        <span class="badge bg-dark text-white px-3 py-1 rounded-pill d-inline-flex align-items-center"
            onclick="removeTag(this, '{{ $name }}')">
            {{ $tag }} <span class="ms-2">×</span>
        </span>
        @endforeach
    </div>

    <!-- Hidden Input -->
    <input type="hidden" name="{{ $name }}" id="{{ $name }}-hidden" value="{{ implode(',', $initialTags) }}">
</div>

@once
@push('scripts')
<script>
    function handleTagKeyPress(event, name) {
    if (event.key === 'Enter') {
        event.preventDefault();
        addTag(name);
    }
}

function addTag(name) {
    const input = document.getElementById(name + '-input');
    const tagsContainer = document.getElementById(name + '-tags');
    const hiddenInput = document.getElementById(name + '-hidden');

    let tags = hiddenInput.value ? hiddenInput.value.split(',').filter(Boolean) : [];
    const newTag = input.value.trim();

    if (newTag && !tags.includes(newTag)) {
        tags.push(newTag);
        updateTags(tags, tagsContainer, hiddenInput, name);
        input.value = '';
    }
}

function removeTag(element, name) {
    const hiddenInput = document.getElementById(name + '-hidden');
    let tags = hiddenInput.value ? hiddenInput.value.split(',').filter(Boolean) : [];
    const removedTag = element.textContent.replace('×', '').trim();

    tags = tags.filter(tag => tag !== removedTag);
    updateTags(tags, document.getElementById(name + '-tags'), hiddenInput, name);
    element.remove();
}

function updateTags(tags, container, hiddenInput, name) {
    hiddenInput.value = tags.join(',');
}
</script>
@endpush
@endonce
