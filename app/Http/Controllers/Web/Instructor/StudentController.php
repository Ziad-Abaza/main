<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildrenUniversity;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage_users')->only(['index', 'list']);
        $this->middleware('can:manage_users')->only(['show']);
        $this->middleware('can:manage_absences')->only(['scan']);
    }

    // Show scan form (main page)
    public function index()
    {
        return view('instructor.students.index');
    }

    // Process scan/code input
    public function scan(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $student = ChildrenUniversity::with('user', 'level')
            ->where('code', $request->code)
            ->first();

        if (!$student) {
            return back()->withErrors(['code' => 'Student not found.']);
        }

        return redirect()->route('dashboard.students.show', $student->id);
    }

    // List all students (table)
    public function list()
    {
        $students = ChildrenUniversity::with('user', 'level')->paginate(20);
        return view('instructor.students.list', [
            'students' => $students
        ]);
    }

    // Show details for a single student
    public function show($id)
    {
        $student = ChildrenUniversity::with('user', 'level')->findOrFail($id);
        return view('instructor.students.show', [
            'student' => $student
        ]);
    }
}
