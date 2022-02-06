<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    use HasFactory;
    
    public function taggable()
    {
        return $this->morphTo();
    }
    
    public function tags()
    {
        return $this->morphedByMany(Tag::class, 'taggable');
    }
}
