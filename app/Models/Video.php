<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class Video extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected $primaryKey = 'video_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'duration',
        'video_url',
        'order_in_course',
        'video_url',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'video_id');
    }

    public function userVideoProgress()
    {
        return $this->hasMany(UserVideoProgress::class, 'video_id');
    }

    // Media Collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')->singleFile();
        $this->addMediaCollection('video_file')->singleFile();
    }

    public function getThumbnail()
    {
        return $this->getFirstMediaUrl('thumbnail');
    }

    public function getVideo()
    {
        return $this->getFirstMediaUrl('video_file');
    }

    public function setThumbnail($file)
    {
        $this->clearMediaCollection('thumbnail');
        $this->addMedia($file)->toMediaCollection('thumbnail');
    }

    public function setVideoFile($file)
    {
        $this->clearMediaCollection('video_file');
        $this->addMedia($file)->toMediaCollection('video_file');

        // Get video duration
        try {
            $ffprobePath = 'C:/ffmpeg/bin/ffprobe.exe';
            $filePath = $file->getPathname();
            $command = [
                $ffprobePath,
                '-v',
                'error',
                '-show_entries',
                'format=duration',
                '-of',
                'default=noprint_wrappers=1:nokey=1',
                $filePath,
            ];

            $process = new Process($command);
            $process->run();

            if ($process->isSuccessful()) {
                $duration = round($process->getOutput() / 60); // Duration in minutes
                $this->duration = $duration;
                $this->save();
            } else {
                Log::error('FFprobe failed: ' . $process->getErrorOutput());
            }
        } catch (\Exception $e) {
            Log::error('Failed to get video duration: ' . $e->getMessage());
        }
    }
}
