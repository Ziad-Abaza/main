@extends('instructor.layouts.app')
@section('title', 'Absences')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Recorded Absences</h6>
                    <a href="{{ route('dashboard.absences.scan') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-qrcode me-2"></i>Scan QR Code
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Recorded By</th>
                                    @if(auth()->user()->hasRole('admin'))
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absences as $absence)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if ($absence->childUniversity->image)
                                                    <img src="{{ asset($absence->childUniversity->image) }}" class="avatar avatar-sm me-3" alt="user image">
                                                @else
                                                    <img src="{{ asset('public/assets/image/default-avatar.png') }}" class="avatar avatar-sm me-3" alt="default image">
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $absence->childUniversity->user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $absence->childUniversity->code }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($absence->time)->format('h:i A') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $absence->instructor->name ?? 'Unknown' }}</p>
                                    </td>
                                    @if(auth()->user()->hasRole('admin') || $absence->instructor_id == auth()->id())
                                    <td class="text-center">
                                        @if(auth()->user()->hasRole('admin'))
                                        <a href="{{ route('console.absences.edit', $absence->id) }}" class="btn btn-sm btn-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                        <form action="{{ auth()->user()->hasRole('admin') ? route('console.absences.delete', $absence->id) : route('dashboard.absences.record') }}" method="POST" class="d-inline delete-absence-form">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="absence_id" value="{{ $absence->id }}">
                                            <button type="button" class="btn btn-sm btn-danger delete-absence-btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="text-sm mb-0">No absences recorded yet.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $absences->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notyf = new Notyf({
        duration: 3000,
        position: { x: 'right', y: 'top' },
        types: [
            {
                type: 'delete-confirm',
                background: '#6c757d', // Bootstrap gray
                icon: {
                    className: 'fas fa-trash-alt',
                    tagName: 'i',
                    text: ''
                }
            }
        ]
    });
    let lastClickedBtn = null;
    let confirmTimeout = null;
    document.querySelectorAll('.delete-absence-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (lastClickedBtn === btn) {
                btn.closest('form').submit();
                lastClickedBtn = null;
                clearTimeout(confirmTimeout);
            } else {
                notyf.open({ type: 'delete-confirm', message: 'Click again to confirm delete' });
                lastClickedBtn = btn;
                clearTimeout(confirmTimeout);
                confirmTimeout = setTimeout(function() {
                    lastClickedBtn = null;
                }, 3000);
            }
        });
    });
});
</script>
@endpush
