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
            ->whereNull('exported_at')
            ->get()
            ->map(function ($absence) {
                return [
                    'student_name' => $absence->childUniversity->user->name,
                    'student_code' => $absence->childUniversity->code,
                    'Classroom' => $absence->childUniversity->meta['classroom'] ?? 'N/A',
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
            'Date',
            'Time',
            'Recorded By'
        ];
    }
}
