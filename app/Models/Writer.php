<?php

namespace App\Models;

use Doctrine\Inflector\Rules\Word;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Writer extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'email', 'phone', 'avatar'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
