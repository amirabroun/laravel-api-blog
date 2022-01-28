<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Writer extends Model
{
    use HasFactory;
    
    protected $table = 'writers';

    protected $primaryKey = 'id';
    
    protected $fillable = ['id', 'name', 'email', 'phone', 'avatar', 'posts' => array($this->posts())];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
