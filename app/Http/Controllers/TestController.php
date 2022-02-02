<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Http\File;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Writer;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        return (Comment::with(['post'])->get());

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
