<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\ChildrenUniversity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Exports\AbsencesExport;
use Maatwebsite\Excel\Facades\Excel;

class AbsenceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_absences']);
    }

    /**
     * Display the QR code scanner view.
     */
    public function scanQrCode()
    {
        /**
         * @var App\Models\User $user
         */
        $user = Auth::user();

        if ($user->can('view_console')) {
            $recordRoute = route('console.absences.record');
            return view('dashboard.absences.scan', compact('recordRoute'));
        } elseif ($user->can('view_dashboard')) {
            $recordRoute = route('dashboard.absences.record');
            return view('instructor.absences.scan', compact('recordRoute'));
        }

        abort(403, 'You do not have permission to access this area.');
    }


    /**
     * Record an absence based on scanned QR code or manual input.
     */
    public function recordAbsence(Request $request)
    {
        try {
            $validated = $request->validate([
                'child_code' => 'required|string|exists:children_universities,code',
            ]);

            $child = ChildrenUniversity::where('code', $validated['child_code'])->firstOrFail();
            $now = Carbon::now();

            $existingAbsence = Absence::where('child_university_id', $child->id)
                ->latest('updated_at')
                ->first();

            if ($existingAbsence) {
                $lastTime = Carbon::parse($existingAbsence->updated_at);

                if ($lastTime->diffInHours($now) < 12) {
                    $student = $child->load('user');
                    $message = 'the student has already been marked present within the last 12 hours.';

                    if ($request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => $message,
                            'student' => $student,
                            'last_recorded_at' => $lastTime->toDateTimeString()
                        ]);
                    }

                    return back()->with([
                        'error' => $message,
                        'student' => ['name' => $student->user->name, 'id' => $student->id],
                        'absence' => ['date' => $existingAbsence->date, 'time' => $existingAbsence->time],
                    ]);
                }

                $existingAbsence->increment('attendance_days');
                $existingAbsence->update([
                    'date' => $now->toDateString(),
                    'time' => $now->toTimeString(),
                    'scanned_by' => Auth::id(),
                    'instructor_id' => Auth::id(),
                ]);

                $student = $child->load('user');
                $message = 'the attendance days have been successfully updated.';

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $message,
                        'student' => $student,
                        'absence' => $existingAbsence
                    ]);
                }

                return back()->with([
                    'success' => $message,
                    'student' => ['name' => $student->user->name, 'id' => $student->id],
                    'absence' => ['date' => $existingAbsence->date, 'time' => $existingAbsence->time],
                ]);
            }

            $absence = Absence::create([
                'child_university_id' => $child->id,
                'instructor_id' => Auth::id(),
                'date' => $now->toDateString(),
                'time' => $now->toTimeString(),
                'scanned_by' => Auth::id(),
                'attendance_days' => 1,
            ]);

            $student = $child->load('user');
            $message = 'the absence has been successfully recorded.';

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'student' => $student,
                    'absence' => $absence
                ]);
            }

            return back()->with([
                'success' => $message,
                'student' => ['name' => $student->user->name, 'id' => $student->id],
                'absence' => ['date' => $absence->date, 'time' => $absence->time],
            ]);
        } catch (\Exception $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'there was an error recording the absence',
                ], 500);
            }

            return back()->with('error',  'There was an error recording the absence');
        }
    }


    /**
     * Display a list of absences recorded by the instructor.
     */
    public function index()
    {
        /**
         * @var App\Models\User $user
         */
        $user = Auth::user();

        if ($user->can('view_console')) {
            $absences = Absence::with(['childUniversity.user', 'instructor'])
                ->latest('date')->latest('time')
                ->paginate(30);

            return view('dashboard.absences.index', compact('absences'));
        } elseif ($user->can('view_dashboard')) {
            $absences = Absence::where('instructor_id', $user->id)
                ->with('childUniversity.user')
                ->latest('date')->latest('time')
                ->paginate(30);

            return view('instructor.absences.index', compact('absences'));
        }

        abort(403, 'You do not have permission to view absences.');
    }


    /**
     * Display the QR code generation view.
     */
    public function generateQrCodeView(Request $request)
    {
        try {
            $students = ChildrenUniversity::with('user')->get();
            $qrCode = null;

            if ($request->has('id')) {
                $child = ChildrenUniversity::with('user')->findOrFail($request->id);
                $size = $request->input('size', 200);
                $format = $request->input('format', 'png');

                $qrCode = $child->qrCodeImg($request->id, $size, [], $child->user->name, $format);
            }

            return view('instructor.absences.generate', compact('students', 'qrCode'));
        } catch (\Exception $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Error generating QR code');
        }
    }

    /**
     * Generate QR code HTML for download.
     */
    public function generateQrCode(Request $request)
    {
        $request->validate([
            'id' => 'required|uuid|exists:children_universities,id',
            'size' => 'nullable|integer|min:100|max:500',
            'format' => 'nullable|in:png,svg',
        ]);

        return redirect()->route('dashboard.absences.generate', $request->all());
    }

    /**
     * Download QR code for a student.
     */
    public function downloadQrCode(Request $request)
    {
        $request->validate([
            'id' => 'required|uuid|exists:children_universities,id',
            'size' => 'nullable|integer|min:100|max:500',
            'format' => 'nullable|in:png,svg',
        ]);

        try {
            $child = ChildrenUniversity::findOrFail($request->id);
            $filename = 'qrcode_' . str_replace(' ', '_', strtolower($child->user->name)) . '.' . $request->format;

            return $child->downloadQrCode($request->id, $request->size, $request->format, 'H');
        } catch (\Exception $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Error generating QR code');
        }
    }

    /**
     * Delete an absence (Admin only).
     */
    public function destroy(Request $request, Absence $absence = null)
    {
        try {
            /**
             * @var App\Models\User $user
             */
            $user = Auth::user();

            if (!$absence && $request->has('absence_id')) {
                $absence = Absence::findOrFail($request->input('absence_id'));
            }

            if (
                $user->can('view_console') ||
                ($user->can('view_dashboard') && $absence->instructor_id === $user->id)
            ) {
                $absence->delete();
                return back()->with('success', 'Absence deleted successfully');
            }

            return back()->with('error', 'You are not authorized to delete this absence.');
        } catch (\Exception $e) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Failed to delete absence');
        }
    }


    /**
     * Show edit form for an absence (Admin only).
     */
    public function edit(Absence $absence)
    {
        /**
         * @var App\Models\User $user
         */
        $user = Auth::user();
        if (!$user->can('view_console')) {
            abort(403, 'You do not have permission to edit absences.');
        }

        $absence->load(['childUniversity.user', 'instructor']);
        return view('instructor.absences.edit', compact('absence'));
    }

    public function update(Request $request, Absence $absence)
    {
        /**
         * @var App\Models\User $user
         */
        $user = Auth::user();
        if (!$user->can('view_console')) {
            abort(403, 'You do not have permission to update absences.');
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        try {
            $absence->update($validated);
            return redirect()->route('console.absences.index')->with('success', 'Absence updated successfully');
        } catch (\Exception $e) {
            Log::channel('debug')->error(__METHOD__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Failed to update absence');
        }
    }

    public function export()
    {
        return Excel::download(new AbsencesExport(), 'absences.xlsx');
    }
}

