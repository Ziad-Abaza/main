<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'price',
        'compare_price',
        'discount',
        'discount_start_date',
        'discount_end_date',
        'stock_quantity',
        'low_stock_threshold',
        'notes',
        'sku',
        'type',
        'is_active'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')->acceptsMimeTypes([
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp'
        ]);

        $this->addMediaCollection('product_files')->acceptsMimeTypes([
            'application/pdf',
            'application/zip',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'application/rar'
        ]);
    }

    public function getImages()
    {
        return $this->getMedia('product_images')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'name' => $media->file_name,
                'size' => $media->size,
                'mime_type' => $media->mime_type,
            ];
        });
    }

    public function setImage($file)
    {
        $this->clearMediaCollection('product_images');
        $this->addMedia($file)->toMediaCollection('product_images');
    }

    public function setProductFile($file)
    {
        $this->clearMediaCollection('product_files');
        $this->addMedia($file)->toMediaCollection('product_files');
    }
}
