<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'created_at', 'updated_at'];
    protected $with = ['posts', 'writers'];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function writers()
    {
        return $this->morphedByMany(Writer::class, 'taggable');
    }

    public function taggable()
    {
        return $this->with([
            'posts' => fn($query) => $query->whereHas('tags'),
            'writers' => fn($query) => $query->whereHas('tags'),
        ])->get()->map(function($tag){
            if(count($tag['posts']) <= 0){
                unset($tag['posts']);
            }
            
            if(count($tag['writers']) <= 0){
                unset($tag['writers']);
            }
            
            return $tag;
        });
    }
    
}
