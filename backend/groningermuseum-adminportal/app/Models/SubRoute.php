<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SubRoute extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'route_id',
        'name',
        'description',
        'order_number'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
       $this->addMediaConversion('thumb')
          ->width(368)
          ->height(232)
          ->sharpen(10)
          ->nonOptimized();
    }

}