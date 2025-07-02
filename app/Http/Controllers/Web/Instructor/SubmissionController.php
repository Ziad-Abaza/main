<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index(Course $course, Assignment $assignment)
    {
        $this->authorizeAssignment($course, $assignment);
        $submissions = $assignment->submissions()->with('user:user_id,name')->paginate(20);
        return view('instructor.assignments.submissions.index', compact('course','assignment','submissions'));
    }

    public function edit(Course $course, Assignment $assignment, Submission $submission)
    {
        $this->authorizeAssignment($course, $assignment, $submission);
        $submission->load('user');
        return view('instructor.assignments.submissions.edit', compact('course','assignment','submission'));
    }

    public function update(Request $request, Course $course, Assignment $assignment, Submission $submission)
    {
        $this->authorizeAssignment($course,$assignment,$submission);
        $data = $request->validate([
            'grade'=>'nullable|numeric|min:0|max:100',
            'feedback'=>'nullable|string|max:1000',
            'file'=>'nullable|file|max:10240'
        ]);
        if($request->hasFile('file')){
            if($submission->feedback_file_path){
                Storage::disk('assignments')->delete($submission->feedback_file_path);
            }
            $file=$request->file('file');
            $filename=uniqid().'_feedback_'.$file->getClientOriginalName();
            $path=$file->storeAs('feedback',$filename,'assignments');
            $submission->feedback_file_path=$path;
        }
        $submission->grade=$data['grade'];
        $submission->feedback=$data['feedback'];
        $submission->save();
        return back()->with('success','Submission graded successfully');
    }

    private function authorizeAssignment(Course $course, Assignment $assignment, Submission $submission=null){
        if($course->instructor_id!==Auth::id()||$assignment->course_id!==$course->course_id){
            abort(403);
        }
        if($submission && $submission->assignment_id!==$assignment->id){abort(404);}    }
}
