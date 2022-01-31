<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'writer_id', 'title', 'body', 'image_path'];

    protected $hidden = ['writer_id'];

    public function writer()
    {
        return $this->hasOne(Writer::class, 'id', 'writer_id');
    }
}
