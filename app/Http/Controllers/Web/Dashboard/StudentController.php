<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ChildrenUniversity;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage_users')->only(['list']);
        $this->middleware('can:manage_users')->only(['show']);
        $this->middleware('can:manage_absences')->only(['absences', 'scanForm', 'scan']);
    }

    /**
     * List all students
     */
    public function list()
    {
        $students = ChildrenUniversity::with('user', 'level')->paginate(20);
        return view('dashboard.students.list', [
            'students' => $students
        ]);
    }

    /**
     * Show student details
     */
    public function show($id)
    {
        $student = ChildrenUniversity::with('user', 'level')->findOrFail($id);
        return view('dashboard.students.show', [
            'student' => $student
        ]);
    }

    /**
     * Show scan form
     */
    public function scanForm()
    {
        return view('dashboard.students.scan');
    }

    /**
     * Process scan/code input
     */
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

        return redirect()->route('console.students.show', $student->id);
    }

    /**
     * Show all absences for a student
     */
    public function absences($id)
    {
        $student = ChildrenUniversity::with('user', 'level')->findOrFail($id);
        $absences = $student->absences()->with('instructor')->latest('date')->latest('time')->get();

        return view('dashboard.absences.index', [
            'student' => $student,
            'absences' => $absences
        ]);
    }
}
