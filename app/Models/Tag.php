<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'created_at', 'updated_at'];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function writers()
    {
        return $this->morphedByMany(Writer::class, 'taggable');
    }
}
