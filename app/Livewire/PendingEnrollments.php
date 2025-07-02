<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;

class PendingEnrollments extends Component
{
    public $pendingEnrollments;

    public function mount()
    {
        $this->fetchEnrollments();
    }

    public function fetchEnrollments()
    {
        $this->pendingEnrollments = CourseEnrollment::with(['user', 'course'])
            ->whereHas('course', fn($query) => $query->where('instructor_id', Auth::id()))
            ->where('status', 'pending')
            ->get();
    }

    public function approve($id)
    {
        $enrollment = CourseEnrollment::findOrFail($id);

        if ($enrollment->course->instructor_id !== Auth::id()) return;

        $enrollment->status = 'approved';
        $enrollment->save();

        \App\Models\UserCourseProgress::create([
            'user_id' => $enrollment->user_id,
            'course_id' => $enrollment->course_id,
            'completion_percentage' => 0,
            'last_accessed' => now(),
        ]);

        $this->fetchEnrollments();
    }

    public function reject($id)
    {
        $enrollment = CourseEnrollment::findOrFail($id);

        if ($enrollment->course->instructor_id !== Auth::id()) return;

        $enrollment->forceDelete();

        $this->fetchEnrollments();
    }

    public function render()
    {
        return view('livewire.pending-enrollments');
    }
}
