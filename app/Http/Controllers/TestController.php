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
        $writers =  Writer::all();
        // $writer = Writer::with(['posts'])->select()->addSelect('title');
            return ($writers);
        // dd([
        //     'id' => $writer->id,
        //     'name' => $writer->name,
        //     'phone' => $writer->phone,
        //     'email' => $writer->email,
        //     'posts' => $writer->posts,
        // ]);

        // $post = Post::all();

        // return [
        //     'id' => $post->id,
        //     'title' => $post->title,
        //     'writer_name' => $post->writers,
        //     'body' => $post->body,
        //     'image_path' => $post->image_path,
        //     'created_at' => $post->created_at,
        //     'updated_at' => $post->updated_at,
        // ];
        // return redirect(url('/upload'));
    }
}
