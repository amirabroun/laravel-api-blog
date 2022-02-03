<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Http\File;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Writer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TestController extends Controller
{
    public function index($id = 12)
    {
        return Comment::query()
            ->whereHasMorph(
                'commentable',
                [Post::class, Writer::class]
            )
            ->with('commentable')->class_alias('commentable', 'sex')
            ->where('id', $id)
            ->get();

        return Comment::query()
            ->whereHasMorph('commentable', [Post::class, Writer::class])
            ->with('commentable')
            ->get();

        return Comment::query()
            ->with(['commentable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Writer::class => ['writer'],
                    Post::class => ['post'],
                ]);
            }])->get();
        return Comment::query()
            ->with(['commentable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([Post::class => ['comments']]);
            }])
            ->get();

        return Comment::with(['comment.post', 'writer'])->get();
        $comment = new Comment([
            'name' => 'amir',
            'email' => 'amir@gamil.com',
            'comment' => 'this is first comment',
        ]);

        $post = Post::find(1);

        return $post->comments;

        $post->comments()->save($comment);

        return redirect()->route('upload');
    }
}
