<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ChildrenUniversity;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // List all students (admin)
    public function list()
    {
        $students = ChildrenUniversity::with('user', 'level')->paginate(20);
        return view('dashboard.students.list', [
            'students' => $students
        ]);
    }

    // Show details for a single student (admin)
    public function show($id)
    {
        $student = ChildrenUniversity::with('user', 'level')->findOrFail($id);
        return view('dashboard.students.show', [
            'student' => $student
        ]);
    }

    // Show scan form (admin)
    public function scanForm()
    {
        return view('dashboard.students.scan');
    }

    // Process scan/code input (admin)
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

    // Show all absences for a student (admin)
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
