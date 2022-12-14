<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function timelines(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PostTimeline::class, 'id', 'post_id');
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
