<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ChildrenStudentImportService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportChildrenStudentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
     public function handle(ChildrenStudentImportService $service): void
     {
         try {
             Log::info("🚀 Starting background import job", ['stored_path' => $this->filePath]);

            $fullPath = storage_path('app/' . $this->filePath);

            if (!file_exists($fullPath)) {
                 throw new \Exception("File does not exist at path: {$fullPath}");
             }

             $service->import($fullPath);
             if (file_exists($fullPath)) {
                 unlink($fullPath);
                 Log::info("🗑️ File deleted successfully after import", ['path' => $fullPath]);
             }

             Log::info("✅ Background import job completed successfully");
         } catch (\Throwable $th) {
             Log::error("❌ Error in background import job: " . $th->getMessage());
             $this->fail($th);
         }
     }
}
