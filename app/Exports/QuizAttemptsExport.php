<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\QuizAttempt;

class QuizAttemptsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $quiz;

    public function __construct($quiz)
    {
        $this->quiz = $quiz;
    }

    public function collection()
    {
        return QuizAttempt::whereHas('question', function ($query) {
            $query->where('quiz_id', $this->quiz->quiz_id);
        })->with(['user', 'question'])->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'question',
            'answer',
            'result',
            'score',
            'date'
        ];
    }
}
