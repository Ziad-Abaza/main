@extends('dashboard.layouts.app')
@section('title', 'Upload Excel or Add Child - Children Students')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">

        <!-- بطاقة رفع ملف الاكسل -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white d-flex align-items-center py-3">
                    <i class="material-symbols-rounded fs-4 text-primary me-2">upload_file</i>
                    <h5 class="mb-0">Upload Excel File for Children Students</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('console.children-students.store') }}" method="POST"
                        enctype="multipart/form-data" id="importForm">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Select Excel File</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls,.csv">
                            <small class="text-muted">Supported formats: XLSX, XLS, CSV</small>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="material-symbols-rounded fs-6 me-1">import_export</i>Import Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- زر لإظهار/إخفاء النموذج اليدوي -->
        <div class="col-md-8 mb-3 text-center">
            <button id="toggleManualForm" class="btn btn-outline-primary">
                <i class="material-symbols-rounded fs-6 me-1">person_add</i> Add Child Manually
            </button>
        </div>

        <!-- نموذج الإدخال اليدوي (مخفي افتراضياً) -->
        <div class="col-md-8" id="manualFormContainer" style="display: none;">
            <div class="card shadow-lg border-radius-lg">
                <div class="card-header bg-white d-flex align-items-center py-3">
                    <i class="material-symbols-rounded fs-4 text-success me-2">person</i>
                    <h5 class="mb-0">Add Child Manually</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('console.children-students.store') }}" method="POST" id="manualForm">
                        @csrf
                        <!-- حقول أساسية -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $code . '@children.org' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Code *</label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ $code }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input type="text" name="password" id="password" class="form-control"
                                value="{{ $password }}" readonly>
                            <small class="text-muted">You can change the password after creation.</small>
                        </div>

                        <!-- حقول meta الديناميكية -->
                        <div class="mb-3">
                            <label class="form-label">Additional Info (Meta)</label>
                            <div id="metaFieldsContainer">
                                <!-- مثال حقل ميتا -->
                                <!-- حقول الميتا المستخرجة من قاعدة البيانات -->
                                @foreach ($metaKeys ?? [] as $key)
                                <div class="input-group mb-2 meta-field-row">
                                    <input type="text" name="meta_keys[]" value="{{ $key }}" class="form-control" readonly>
                                    <input type="text" name="meta_values[]" placeholder="Value for {{ $key }}" class="form-control">
                                    <button type="button" class="btn btn-danger btn-sm removeMetaField">✕</button>
                                </div>
                                @endforeach

                                <!-- حقل مبدئي فارغ لإضافة ميتا جديدة -->
                                <div class="input-group mb-2 meta-field-row">
                                    <input type="text" name="meta_keys[]" placeholder="Field Name" class="form-control">
                                    <input type="text" name="meta_values[]" placeholder="Value" class="form-control">
                                    <button type="button" class="btn btn-danger btn-sm removeMetaField">✕</button>
                                </div>
                            </div>
                            <button type="button" id="addMetaFieldBtn" class="btn btn-sm btn-outline-secondary">
                                + Add More Fields
                            </button>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="material-symbols-rounded fs-6 me-1">save</i> Save Child
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleManualForm');
    const manualFormContainer = document.getElementById('manualFormContainer');
    const addMetaBtn = document.getElementById('addMetaFieldBtn');
    const metaContainer = document.getElementById('metaFieldsContainer');

    toggleBtn.addEventListener('click', () => {
        if (manualFormContainer.style.display === 'none') {
            manualFormContainer.style.display = 'block';
            toggleBtn.textContent = 'Hide Manual Add Form';
        } else {
            manualFormContainer.style.display = 'none';
            toggleBtn.textContent = 'Add Child Manually';
        }
    });

    addMetaBtn.addEventListener('click', () => {
        const div = document.createElement('div');
        div.classList.add('input-group', 'mb-2', 'meta-field-row');
        div.innerHTML = `
            <input type="text" name="meta_keys[]" placeholder="Field Name" class="form-control" required>
            <input type="text" name="meta_values[]" placeholder="Value" class="form-control" required>
            <button type="button" class="btn btn-danger btn-sm removeMetaField">✕</button>
        `;
        metaContainer.appendChild(div);
    });

    metaContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('removeMetaField')) {
            e.target.closest('.meta-field-row').remove();
        }
    });
});
</script>
@endsection
