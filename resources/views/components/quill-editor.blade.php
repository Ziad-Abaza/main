@props([
'name',
'label' => '',
'value' => '',
'required' => false,
'id' => null,
'height' => '300px'
])

@php
$id = $id ?? $name;
@endphp

<div class="mb-3">
    @if($label)
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control text-editor @error($name) is-invalid @enderror"
        rows="10" style="display: none;">{!! old($name, $value) !!}</textarea>

    <!-- Quill Editor -->
    <div id="{{ $id }}-editor" style="min-height: {{ $height }};"></div>

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@once
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        min-height: 200px;
        direction: rtl;
        text-align: right;
        font-family: 'Segoe UI', 'Arial', 'Tahoma', sans-serif !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.text-editor').forEach(function (textarea) {
                    const id = textarea.id;
                    const editorDiv = document.getElementById(id + '-editor');

                    const quill = new Quill(editorDiv, {
                        theme: 'snow',
                        placeholder: 'Type your content here...',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                                ['link', 'image'],
                                ['clean']
                            ]
                        }
                    });

                    quill.root.innerHTML = textarea.value;
                    quill.on('text-change', function () {
                        textarea.value = quill.root.innerHTML;
                    });
                });
            });
</script>
@endpush
@endonce
