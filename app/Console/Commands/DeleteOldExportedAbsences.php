<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Absence;
use Illuminate\Support\Carbon;

class DeleteOldExportedAbsences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absences:delete-old-exported';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete absences that were exported more than a week ago';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // calculate the date everyMinute
        $oneWeekAgo = Carbon::now()->subWeek();

        // delete absences that were exported more than a week ago
        $deleted = Absence::whereNotNull('exported_at')
            ->where('exported_at', '<', $oneWeekAgo)
            ->delete();

        $this->info("Deleted $deleted exported absences older than one week.");
    }
}
