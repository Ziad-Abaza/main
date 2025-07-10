@props([
'name',
'label' => 'Tags',
'value' => '',
'placeholder' => 'Add a tag...',
])

@php
$initialTags = old($name, $value);
$initialTags = is_array($initialTags) ? $initialTags : explode(',', $initialTags);
@endphp

<div class="mb-4">
    <label class="form-label fw-bold">{{ $label }}</label>

    <div class="d-flex mb-2 gap-2">
        <input type="text" class="form-control form-control-sm" id="{{ $name }}-input" placeholder="{{ $placeholder }}">
        <button type="button" class="btn btn-dark btn-sm" onclick="addTag_{{ $name }}()">+</button>
    </div>

    <div id="{{ $name }}-tags" class="d-flex flex-wrap gap-2 mb-2">
        @foreach ($initialTags as $tag)
        @if (trim($tag) !== '')
        <span class="badge bg-dark text-white px-3 py-1 rounded-pill" onclick="removeTag_{{ $name }}(this)">
            {{ $tag }} &times;
        </span>
        @endif
        @endforeach
    </div>

    <input type="hidden" name="{{ $name }}" id="{{ $name }}-hidden" value="{{ implode(',', $initialTags) }}">
</div>

@push('scripts')
<script>
    function addTag_{{ $name }}() {
        const input = document.getElementById('{{ $name }}-input');
        const tagsContainer = document.getElementById('{{ $name }}-tags');
        const hiddenInput = document.getElementById('{{ $name }}-hidden');
        let tags = hiddenInput.value ? hiddenInput.value.split(',') : [];

        const newTag = input.value.trim();
        if (newTag && !tags.includes(newTag)) {
            tags.push(newTag);
            hiddenInput.value = tags.join(',');

            const tagElement = document.createElement('span');
            tagElement.className = 'badge bg-dark text-white px-3 py-1 rounded-pill';
            tagElement.innerHTML = `${newTag} &times;`;
            tagElement.onclick = function() { removeTag_{{ $name }}(tagElement); };

            tagsContainer.appendChild(tagElement);
        }

        input.value = '';
    }

    function removeTag_{{ $name }}(element) {
        const hiddenInput = document.getElementById('{{ $name }}-hidden');
        let tags = hiddenInput.value ? hiddenInput.value.split(',') : [];
        const removedTag = element.textContent.replace('×', '').trim();

        tags = tags.filter(tag => tag !== removedTag);
        hiddenInput.value = tags.join(',');
        element.remove();
    }
</script>
@endpush
