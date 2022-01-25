<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Http\File;
use App\Models\Post;
use App\Models\Writer;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        // $posts = Post::select('title, writer_id as writer, body, image_path')->get();

        $post = DB::table('posts as p')
            ->leftJoin('writers as w', 'p.writer_id', '=', 'w.id')
            ->select('p.id', 'w.name as writer_name', 'p.title', 'p.body', 'p.image_path')
            ->where('p.id', '=', 2)
            ->get();

        dd($post);
        dd(Post::all());
    }
}
