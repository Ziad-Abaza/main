<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseEnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_enrollments']);
    }
    /**
     * Display a listing of pending course enrollments for the instructor's courses.
     */
    public function index()
    {
        return view('instructor.enrollments.index');
    }
}
