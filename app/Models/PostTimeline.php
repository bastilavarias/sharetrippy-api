<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTimeline extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function transportations(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function destinations(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function lodgings(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
