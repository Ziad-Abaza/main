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
        $this->middleware(['auth', 'role:instructor,admin']);
    }

    /**
     * Display the QR code scanner view.
     */
    public function scanQrCode()
    {
        $user = Auth::user();
        $isAdmin = $user && method_exists($user, 'hasRole') && $user->hasRole('admin');
        $recordRoute = $isAdmin
            ? route('console.absences.record')
            : route('dashboard.absences.record');

        if ($isAdmin) {
            return view('dashboard.absences.scan', compact('recordRoute'));
        } else {
            return view('instructor.absences.scan', compact('recordRoute'));
        }
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

            // Check for existing absence
            $existingAbsence = Absence::where('child_university_id', $child->id)
                ->whereDate('date', $now->toDateString())
                ->first();

            if ($existingAbsence) {
                $student = $child->load('user');
                $absenceData = [
                    'date' => $existingAbsence->date,
                    'time' => $existingAbsence->time
                ];

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Absence already recorded for this student today',
                        'student' => $student,
                        'absence' => $absenceData
                    ]);
                }

                return back()->with([
                    'error' => 'Absence already recorded for this student today',
                    'student' => ['name' => $student->user->name, 'id' => $student->id],
                    'absence' => $absenceData
                ]);
            }

            // Create new absence
            $absence = Absence::create([
                'child_university_id' => $child->id,
                'instructor_id' => Auth::id(),
                'date' => $now->toDateString(),
                'time' => $now->toTimeString(),
                'scanned_by' => Auth::id(),
            ]);

            $student = $child->load('user');

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Attendance recorded successfully',
                    'student' => $student,
                    'absence' => $absence
                ]);
            }

            return back()->with([
                'success' => 'Attendance recorded successfully',
                'student' => ['name' => $student->user->name, 'id' => $student->id],
                'absence' => ['date' => $absence->date, 'time' => $absence->time]
            ]);
        } catch (\Exception $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error recording attendance'
                ], 500);
            }

            return back()->with('error', 'Error recording attendance');
        }
    }

    /**
     * Display a list of absences recorded by the instructor.
     */
    public function index(Request $request)
    {
        $showAll = $request->has('show_all') && $request->show_all == 1;

        if (Auth::user() && Auth::user()->hasRole('admin')) {
            $query = Absence::with(['childUniversity.user', 'instructor'])
                ->latest('date')->latest('time');

            if (!$showAll) {
                $query->whereNull('exported_at');
            }

            $absences = $query->paginate(30);

            return view('dashboard.absences.index', compact('absences', 'showAll'));
        } else {
            $query = Absence::where('instructor_id', Auth::id())
                ->with('childUniversity.user')
                ->latest('date')->latest('time');

            if (!$showAll) {
                $query->whereNull('exported_at');
            }

            $absences = $query->paginate(30);

            return view('instructor.absences.index', compact('absences', 'showAll'));
        }
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
            // If called from instructor dashboard, get absence by id from request
            if (!$absence && $request->has('absence_id')) {
                $absence = Absence::findOrFail($request->input('absence_id'));
            }
            // Allow admin to delete any, instructor only their own
            if (!Auth::user()->hasRole('admin') && $absence->instructor_id !== Auth::id()) {
                return back()->with('error', 'You are not authorized to delete this absence.');
            }
            $absence->delete();
            return back()->with('success', 'Absence deleted successfully');
        } catch (\Exception $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Failed to delete absence');
        }
    }

    /**
     * Show edit form for an absence (Admin only).
     */
    public function edit(Absence $absence)
    {
        $absence->load(['childUniversity.user', 'instructor']);
        return view('instructor.absences.edit', compact('absence'));
    }

    /**
     * Update absence record (Admin only).
     */
    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        try {
            $absence->update($validated);
            return redirect()->route('console.absences.index')->with('success', 'Absence updated successfully');
        } catch (\Exception $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Failed to update absence');
        }
    }

    public function export()
    {
        $absences = Absence::whereNull('exported_at')->get();

        $export = new AbsencesExport();
        $download = Excel::download($export, 'absences.xlsx');
        if ($absences->isNotEmpty()) {
            Absence::whereIn('id', $absences->pluck('id'))
                ->update(['exported_at' => now()]);
        }
        return $download;
    }
}

