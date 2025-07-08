<?php

namespace App\Exports;

use App\Models\Absence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsencesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Absence::with(['childUniversity.user', 'instructor'])
            ->get()
            ->map(function ($absence) {
                return [
                    'student_name' => $absence->childUniversity->user->name,
                    'student_code' => $absence->childUniversity->code,
                    'Classroom' => $absence->childUniversity->meta['classroom'] ?? 'N/A',
                    'attendance_days' => $absence->attendance_days ?? 0,
                    'date' => $absence->date,
                    'time' => $absence->time,
                    'recorded_by' => $absence->instructor->name ?? 'Unknown',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Student Code',
            'Classroom',
            'Attendance Days',
            'Date',
            'Time',
            'Recorded By'
        ];
    }
}
