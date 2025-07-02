<div class="card border-radius-lg overflow-hidden shadow-lg">
    <!-- Card Header -->
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center bg-white py-3">
        <h5 class="text-gradient text-dark mb-md-0 mb-0 mb-2">Children Students Management</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('console.children-students.create') }}" class="btn btn-success btn-sm px-4">
                <i class="material-symbols-rounded fs-6 me-1">add</i> Upload Excel
            </a>
            <a href="{{ route("console.children-students.export") }}" class="btn btn-success btn-sm px-4">
                <i class="material-symbols-rounded fs-6 me-1">file_download</i> Export Excel
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="px-4 py-3">
        <input wire:model.live="search" type="text" class="form-control form-control-sm border-light border-1 w-auto border" placeholder="Search by name or email...">
    </div>

    <!-- Table -->
    <div class="table-responsive p-0">
        <table class="align-items-center mb-0 table">
            <thead class="bg-gradient bg-light text-dark">
                <tr>
                    <th class="py-3 ps-4">Student Name</th>
                    <th class="py-3">Code</th>
                    <th class="py-3">Email</th>
                    @foreach ($dynamicFields as $field)
                    <th class="text-capitalize py-3">{{ ucwords(str_replace("_", " ", $field)) }}</th>
                    @endforeach
                    <th class="py-3">Password</th>
                    <th class="py-3 pe-4 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr class="align-middle">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="material-symbols-rounded text-primary fs-4">child_care</i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ $student->user->name }}</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-gradient-info d-inline-flex align-items-center">
                            {{ $student->code }}
                        </span>
                    </td>
                    <td>
                        <p class="text-muted mb-0 text-sm">{{ $student->user->email }}</p>
                    </td>
                    @foreach ($dynamicFields as $field)
                    <td>{{ $student->meta[$field] ?? "-" }}</td>
                    @endforeach
                    @php
                    try {
                    $decryptedPassword = decrypt($student->password);
                    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    $decryptedPassword = 'invalid password';
                    }
                    @endphp

                    <td>
                        <div class="d-flex align-items-center">
                            <span class="me-2 password-field" data-password="{{ $decryptedPassword }}">********</span>
                            <button class="btn btn-sm btn-outline-primary toggle-password">
                                <i class="material-symbols-rounded fs-6">visibility</i>
                            </button>
                        </div>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route("console.children-students.edit", $student) }}"
                                class="btn btn-sm btn-icon btn-outline-primary">
                                <i class="material-symbols-rounded fs-6">edit</i>
                            </a>
                            <button wire:click="$set('studentToDeleteId', @js($student->id))"
                                class="btn btn-sm btn-icon btn-outline-danger">
                                <i class="material-symbols-rounded fs-6">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ 5 + count($dynamicFields) }}" class="py-5 text-center">
                        <i class="material-symbols-rounded fs-1 text-muted mb-2">child_care</i>
                        <h6 class="text-muted mb-0">No students found</h6>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center align-items-center gap-2 py-3">
        @php
            $currentPage = $students->currentPage();
            $lastPage = $students->lastPage();
            $pages = [];
            $pages[] = 1;
            if ($currentPage > 3) $pages[] = '...';
            for ($i = max(2, $currentPage - 2); $i <= min($lastPage - 1, $currentPage + 2); $i++) {
                $pages[] = $i;
            }
            if ($currentPage < $lastPage - 2) $pages[] = '...';
            if ($lastPage > 1) $pages[] = $lastPage;
        @endphp

        @if ($students->onFirstPage())
            <button class="btn btn-sm btn-outline-secondary disabled" tabindex="-1" aria-disabled="true">
                Previous
            </button>
        @else
            <a href="{{ $students->previousPageUrl() }}" class="btn btn-sm btn-outline-primary" wire:navigate>
                Previous
            </a>
        @endif

        @foreach ($pages as $page)
            @if ($page === '...')
                <span class="px-2">&hellip;</span>
            @elseif ($page == $students->currentPage())
                <button class="btn btn-sm btn-primary px-2 py-1" disabled>{{ $page }}</button>
            @else
                <a href="{{ $students->url($page) }}" class="btn btn-sm btn-outline-primary px-2 py-1" wire:navigate>
                    {{ $page }}
                </a>
            @endif
        @endforeach

        @if ($students->hasMorePages())
            <a href="{{ $students->nextPageUrl() }}" class="btn btn-sm btn-outline-primary" wire:navigate>
                Next
            </a>
        @else
            <button class="btn btn-sm btn-outline-secondary disabled" tabindex="-1" aria-disabled="true">
                Next
            </button>
        @endif
    </div>

    <!-- Delete All -->
    <div class="border-top px-4 py-3">
        <form wire:submit.prevent="deleteAll" class="d-flex align-items-center gap-2">
            <input wire:model="confirmationCode" type="text" placeholder="security code" required
                class="form-control form-control-sm border-light border-1 w-auto border">
            <button type="submit" class="btn btn-sm btn-danger m-0">
                <i class="material-symbols-rounded fs-6 me-1">delete_forever</i>Delete All
            </button>
        </form>
    </div>
    <!-- Modal Confirmation -->
    @if($studentToDeleteId)
    <div id="deleteModal" class="modal fade show d-block" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title">هل أنت متأكد؟</h5>
                    <button type="button" class="btn-close" onclick="hideDeleteModal()" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <p>سيتم حذف هذا الطالب بشكل دائم.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideDeleteModal()">إلغاء</button>
                    <button wire:click="deleteStudent(@js($studentToDeleteId))" class="btn btn-danger">
                        تأكيد الحذف
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .modal {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', () => {
                const passwordSpan = button.previousElementSibling;
                const isHidden = passwordSpan.innerText.includes('*');

                if (isHidden) {
                    passwordSpan.innerText = passwordSpan.dataset.password;
                    button.querySelector('i').innerText = 'visibility_off';
                } else {
                    passwordSpan.innerText = '********';
                    button.querySelector('i').innerText = 'visibility';
                }
            });
        });
    });

        function hideDeleteModal() {
            @this.set('studentToDeleteId', null);
        }

</script>
