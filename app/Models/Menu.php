<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class Menu extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'menu';

    protected $fillable = [
        "name",
        "description",
        'price',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("food-plates")
            ->singleFile()
            ->useDisk("food-plates");
    }

    public function photo(): ?\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->getFirstMedia("food-plates");
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function savePhoto(UploadedFile $file)
    {
        $this->addMedia($file)->toMediaCollection("food-plates");
    }

    public function scopeSearch(Builder $query, $search)
    {
        $query->when($search, function ($query) use ($search) {
            return $query->where("name", "like", "%{$search}%");
        });
    }
}
