<?php

namespace App\Exports;

use App\Models\ChildrenUniversity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ChildrenStudentsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $allMetaKeys = [];

    public function __construct()
    {
        $this->allMetaKeys = ChildrenUniversity::pluck('meta')
            ->map(fn($meta) => is_array($meta) ? array_keys($meta) : [])
            ->flatten()
            ->unique()
            ->values()
            ->toArray();
    }

    public function collection()
    {
        return ChildrenUniversity::with('user')->get()->map(function ($child) {
            $baseData = [
                'name' => $child->user->name,
                'code' => $child->code,
                'email' => $child->user->email,
                'password' => decrypt($child->password),
                'created_at' => $child->created_at,
            ];

            $metaData = [];
            foreach ($this->allMetaKeys as $key) {
                $metaData[$key] = $child->meta[$key] ?? null;
            }

            return array_merge($baseData, $metaData);
        });
    }

    public function headings(): array
    {
        $baseHeadings = ['Name', 'Code', 'Email', 'Password', 'Created At'];
        return array_merge($baseHeadings, $this->allMetaKeys);
    }
}
