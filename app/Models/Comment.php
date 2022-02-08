<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'name', 'email', 'commentable_id', 'commentable_type'];

    protected $hidden = ['id', 'commentable_id', 'commentable_type'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function writer()
    {
        return $this->belongsTo(Writer::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
