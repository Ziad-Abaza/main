<div>
    @if($pendingEnrollments->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-hover align-items-center mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>User Name</th>
                        <th>Course Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingEnrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->user->name ?? 'N/A' }}</td>
                            <td>{{ $enrollment->course->title ?? 'N/A' }}</td>
                            <td>
                                <button wire:click="approve('{{ $enrollment->enrollment_id }}')"
                                        class="btn btn-success btn-sm">Approve</button>
                                <button wire:click="reject('{{ $enrollment->enrollment_id }}')"
                                        class="btn btn-danger btn-sm">Reject</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted text-center my-4">No pending enrollments.</p>
    @endif
</div>
