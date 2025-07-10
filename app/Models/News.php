<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Uuids\Uuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;

class News extends Model implements HasMedia
{
    use HasUuids, HasFactory, InteractsWithMedia;
    protected $primaryKey = 'news_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'author_id',
        'title',
        'excerpt',
        'content',
        'category',
        'tags',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news_images');
    }

    public function getImages()
    {
        return $this->getMedia('news_images')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'name' => $media->file_name,
                'size' => $media->size,
                'mime_type' => $media->mime_type,
            ];
        });
    }

    public function setImages(array $images)
    {
        $this->clearMediaCollection('news_images');

        foreach ($images as $image) {
            if (is_string($image)) {
                $this->addMediaFromUrl($image)->toMediaCollection('news_images');
            } elseif ($image instanceof \Illuminate\Http\UploadedFile) {
                $this->addMedia($image)->toMediaCollection('news_images');
            }
        }
    }
}
