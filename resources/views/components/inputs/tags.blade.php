@props([
'name',
'label' => '',
'value' => [],
'placeholder' => '',
'class' => ''
])

@php
$tags = is_string($value) ? explode(',', $value) : (array) $value;
@endphp

<div {{ $attributes->merge(['class' => 'mb-3']) }}
    x-data='{
    tags: @json($tags),
    addTag(newTag) {
    newTag = newTag.trim();
    if (newTag && !this.tags.includes(newTag)) {
    this.tags.push(newTag);
    }
    },
    removeTag(index) {
    this.tags.splice(index, 1);
    }
    }'>
    @if($label)
    <label class="form-label fw-bold" for="{{ $name }}">{{ $label }}</label>
    @endif

    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
        <template x-for="(tag, index) in tags" :key="index">
            <div class="badge bg-secondary d-flex align-items-center">
                <span x-text="tag"></span>
                <button type="button" class="btn-close btn-close-white btn-sm ms-1" aria-label="Close"
                    @click="removeTag(index)"></button>
                <input type="hidden" :name="'{{ $name }}[]'" :value="tag">
            </div>
        </template>
    </div>

    <input type="text" class="form-control border border-2 border-secondary rounded-2 py-2 px-3 {{ $class }}" placeholder="{{ $placeholder }}"
        @keydown.enter.prevent="addTag($event.target.value); $event.target.value = ''" />
        <!-- User instruction -->
        <div class="form-text text-muted mt-1">
            Type a tag and press <kbd class="rounded-5 bg-light text-dark fw-bold">Enter</kbd> to add it to the list.
        </div>

    @error($name)
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
