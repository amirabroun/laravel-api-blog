<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'name', 'email', 'commentable_id', 'commentable_type'];

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'commentable_id');
    }

    public function writer()
    {
        return $this->hasOne(Writer::class, 'id', 'commentable_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
