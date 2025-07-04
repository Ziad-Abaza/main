<?php

namespace App\Jobs;

use App\Models\Level;
use App\Services\ChildrenStudentImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncLevelStudentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $levelId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($levelId)
    {
        $this->levelId = $levelId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ChildrenStudentImportService $importService)
    {
        $level = Level::with('children')->find($this->levelId);
        if (!$level) {
            Log::warning("SyncLevelStudentsJob: Level not found for ID {$this->levelId}");
            return;
        }
        foreach ($level->children as $child) {
            $importService->syncStudentLevelCourses($child->user_id, $level->level_id);
        }
    }
}
