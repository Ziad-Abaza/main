<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absence;
use App\Models\ChildrenUniversity;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Absence::truncate();
        Schema::enableForeignKeyConstraints();

        $children = ChildrenUniversity::all();
        $instructor = User::where('email', 'instructor1@example.com')->first();

        if ($instructor && $children->count() > 0) {
            $this->command->info('Found ' . $children->count() . ' children university records.');

            foreach ($children as $child) {
                $this->command->info('Processing child university with ID: ' . $child->id);

                for ($i = 1; $i <= 3; $i++) {
                    $date = Carbon::now()->subDays(rand(1, 30));
                    try {
                        Absence::create([
                            'child_university_id' => $child->id,
                            'instructor_id' => $instructor->user_id,
                            'date' => $date->toDateString(),
                            'time' => $date->toTimeString(),
                            'scanned_by' => $instructor->name,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } catch (\Exception $e) {
                        $this->command->error('Error creating absence: ' . $e->getMessage());
                        $this->command->error('Child ID: ' . $child->id . ', Instructor ID: ' . $instructor->user_id);
                    }
                }
            }
        } else {
            if (!$instructor) {
                $this->command->error('Instructor with email instructor1@example.com not found. Please run UserSeeder first.');
            }
            if ($children->count() === 0) {
                $this->command->error('No children university records found. Please run ChildrenUniversitySeeder first.');
            }
        }
    }
}
