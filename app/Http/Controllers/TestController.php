<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Http\File;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Writer;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TestController extends Controller
{
    public function index($id = 2)
    {
        dd(Tag::query()
            ->with(['taggable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Writer::class => ['writer'],
                    Post::class => ['post'],
                ]);
            }])->get());

        return Tag::query()
            ->whereHasMorph(
                'taggable',
                [Post::class, Writer::class]
            )
            ->with('taggable')
            ->where('id', $id)
            ->get();

        $tag = new Tag([
            'title' => 'program'
        ]);

        $post = Post::find(2);
        dd($post->tags()->save($tag));

        dd(Tag::query()
            ->whereMorphRelationMorph(
                'taggable',
                [Post::class, Writer::class]
            )
            ->with('posts')
            ->where('id', $id)
            ->get());
        $tag->save();

        $comment = new Comment([
            'comment' => 'test for find',
            'name' => 'no name',
            'email' => 'no name',
            'commentable_id' => 1,
        ]);

        dd(Post::query()->find(1)->comments()->save($comment));

        return Comment::query()
            ->whereHasMorph('commentable', [Post::class, Writer::class])
            ->with('commentable')
            ->get();

        return redirect()->route('upload');
    }
}
