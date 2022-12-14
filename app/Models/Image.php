<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['url'];
    protected $hidden = [
        'name',
        'location',
        'extension',
        'imageable_id',
        'imageable_type',
    ];

    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function getURLAttribute(): string
    {
        $name = $this->attributes['name'];
        $location = $this->attributes['location'];
        $extension = $this->attributes['extension'];
        $path = env('APP_URL') . '/storage' . "/{$location}";
        return "{$path}/{$name}.{$extension}";
    }
}
