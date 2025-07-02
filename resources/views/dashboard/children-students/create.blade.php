@extends('dashboard.layouts.app')
@section('title', 'Children Student Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <!-- Main Card Container -->
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <!-- Header Section -->
                <div class="card-header bg-gradient-to-r from-primary-50 to-blue-50 p-4">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-gradient-primary rounded-circle me-3">
                            <i class="material-symbols-rounded text-white fs-4">child_care</i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-gray-800">Children Student Management</h4>
                            <p class="mb-0 text-muted small">Add students via Excel or manually</p>
                        </div>
                    </div>
                </div>

                <!-- Body Content -->
                <div class="card-body p-4">
                    <!-- Excel Upload Section -->
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="material-symbols-rounded fs-5 me-2">upload_file</i>
                                Upload Excel File
                            </h5>
                            <span class="badge bg-light text-primary fw-medium">Recommended</span>
                        </div>

                        <div class="border rounded-3 p-4 bg-light-subtle">
                            <form action="{{ route('console.children-students.store') }}" method="POST"
                                enctype="multipart/form-data" id="importForm" class="needs-validation" novalidate>
                                @csrf

                                <div class="mb-4">
                                    <label for="file" class="form-label fw-medium">Select Excel File</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control @error('file') is-invalid @enderror"
                                        accept=".xlsx,.xls,.csv" required>
                                    <div class="form-text">
                                        Supported formats: XLSX, XLS, CSV (Max size: 10MB)
                                    </div>
                                    @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex flex-column flex-md-row gap-2 pt-2">
                                    <button type="submit"
                                        class="btn btn-primary px-4 d-flex align-items-center justify-content-center">
                                        <i class="material-symbols-rounded fs-6 me-2">import_export</i>
                                        Import Students
                                    </button>

                                    <a href="#"
                                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                        <i class="material-symbols-rounded fs-6 me-2">download</i>
                                        Download Template
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="position-relative my-5">
                        <hr class="text-muted opacity-50">
                        <div class="position-absolute top-50 start-50 translate-middle px-4 bg-white rounded-pill z-2">
                            <span class="text-muted small fw-medium">OR</span>
                        </div>
                    </div>

                    <!-- Manual Entry Section -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="material-symbols-rounded fs-5 me-2">person_add</i>
                                Add Child Manually
                            </h5>

                            <button id="toggleManualForm"
                                class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                <i class="material-symbols-rounded fs-6 me-1" id="manualFormToggleIcon">expand_more</i>
                                Show Form
                            </button>
                        </div>

                        <!-- Manual Entry Form (Initially Hidden) -->
                        <div id="manualFormContainer" class="collapse">
                            <div class="border rounded-3 p-4 bg-white shadow-sm">
                                <form action="{{ route('console.children-students.store') }}" method="POST"
                                    id="manualForm" class="needs-validation" novalidate>
                                    @csrf

                                    <!-- Student Information -->
                                    <h6 class="fw-semibold mb-3 pb-2 border-bottom">Student Information</h6>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label fw-medium">Full Name *</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Enter full name" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid name.
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="code" class="form-label fw-medium">Student Code *</label>
                                            <input type="text" name="code" id="code"
                                                class="form-control @error('code') is-invalid @enderror"
                                                value="{{ old('code') ?? ($code ?? '') }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-medium">Email Address *</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') ?? ($code ?? '') . '@children.org' }}" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address.
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password" class="form-label fw-medium">Password *</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    value="{{ old('password') ?? ($password ?? '') }}" readonly>
                                                <button type="button"
                                                    class="btn btn-outline-secondary generate-password"
                                                    title="Generate New Password">
                                                    <i class="material-symbols-rounded fs-6">autorenew</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information -->
                                    <h6 class="fw-semibold mb-3 mt-4 pb-2 border-bottom">Additional Information</h6>

                                    <div class="mb-4">
                                        <div id="metaFieldsContainer">
                                            <!-- Static Example Field -->
                                            <div class="row g-2 mb-3 dynamic-meta-field">
                                                <div class="col-md-5">
                                                    <input type="text" name="meta_keys[]" class="form-control"
                                                        placeholder="Field Name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="meta_values[]" class="form-control"
                                                        placeholder="Field Value" required>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger remove-meta-field" disabled
                                                        title="Remove Field">
                                                        <i class="material-symbols-rounded fs-6">remove</i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Dynamic Fields Will Be Added Here -->
                                            @if(isset($metaKeys))
                                            @foreach($metaKeys as $key)
                                            <div class="row g-2 mb-3 dynamic-meta-field">
                                                <div class="col-md-5">
                                                    <input type="text" name="meta_keys[]" class="form-control"
                                                        value="{{ $key }}" readonly required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="meta_values[]" class="form-control"
                                                        placeholder="Value for {{ $key }}" required>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger remove-meta-field"
                                                        title="Remove Field">
                                                        <i class="material-symbols-rounded fs-6">remove</i>
                                                    </button>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>

                                        <div class="mt-3">
                                            <button type="button" id="addMetaFieldBtn"
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                                <i class="material-symbols-rounded fs-6 me-1">add</i>
                                                Add More Fields
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="submit" class="btn btn-success px-4 d-flex align-items-center">
                                            <i class="material-symbols-rounded fs-6 me-2">save</i>
                                            Save Student
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleManualForm');
    const manualFormContainer = document.getElementById('manualFormContainer');
    const manualFormToggleIcon = document.getElementById('manualFormToggleIcon');
    const metaContainer = document.getElementById('metaFieldsContainer');
    const addMetaBtn = document.getElementById('addMetaFieldBtn');

    // Toggle manual form visibility
    toggleBtn.addEventListener('click', () => {
        const bsCollapse = new bootstrap.Collapse(manualFormContainer);

        if (manualFormContainer.classList.contains('show')) {
            toggleBtn.textContent = 'Show Form';
            manualFormToggleIcon.textContent = 'expand_more';
        } else {
            toggleBtn.textContent = 'Hide Form';
            manualFormToggleIcon.textContent = 'expand_less';
        }

        bsCollapse.toggle();
    });

    // Add new meta field
    addMetaBtn.addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'row g-2 mb-3 dynamic-meta-field';
        div.innerHTML = `
            <div class="col-md-5">
                <input type="text"
                       name="meta_keys[]"
                       class="form-control"
                       placeholder="Field Name"
                       required>
            </div>
            <div class="col-md-6">
                <input type="text"
                       name="meta_values[]"
                       class="form-control"
                       placeholder="Field Value"
                       required>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button"
                        class="btn btn-sm btn-danger remove-meta-field"
                        title="Remove Field">
                    <i class="material-symbols-rounded fs-6">remove</i>
                </button>
            </div>
        `;

        metaContainer.appendChild(div);
    });

    // Remove meta field
    metaContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-meta-field')) {
            const row = e.target.closest('.dynamic-meta-field');
            if (metaContainer.querySelectorAll('.dynamic-meta-field').length > 1) {
                row.remove();
            }
        }
    });

    // Generate new password
    document.querySelector('.generate-password')?.addEventListener('click', () => {
        const passwordInput = document.getElementById('password');
        const name = document.getElementById('name').value;

        if (!name.trim()) {
            alert('Please enter a student name first.');
            return;
        }

        const initials = name.slice(0, 2).toUpperCase();
        const randomNums = Math.floor(100 + Math.random() * 900);
        const today = new Date().getDate();
        const newPassword = `${initials}${randomNums}${today}`;

        passwordInput.value = newPassword;
    });
});
</script>
@endpush
@endsection
