<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        return Post::with(['writer', 'comments', 'tags'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'writer_id' => 'required|numeric',
            'title' => 'required',
            'body' => 'required',
            'image_path' => 'unique:posts,image_path',
        ]);

        $post = new Post([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image_path' => $request->input('image_path'),
        ]);

        $writer =  Writer::find($request->input('writer_id'));

        if ($writer->posts()->save($post)) {
            return ['status: success' => 'Post was successfully created'];
        }

        return ['status: fail' => 'Error creating new post'];
    }

    public function show($id)
    {
        $post = Post::with(['writer', 'comments', 'tags'])->find($id);

        if (!$post) {
            return ['error' => 'There is no post with this id'];
        }

        return $post;
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return ['error' => 'There is no post with this id'];
        }

        $request->validate([
            'writer_id' => 'required|numeric',
            'title' => 'required',
            'body' => 'required',
            'image_path' => 'unique:posts,image_path',
        ]);

        if (!$post->update($request->all())) {
            return ['status: fail' => 'Post update encountered an error'];
        }

        return [
            'status: success' => 'Post was successfully updated',
            'data' => $post
        ];
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return ['error' => 'There is no post with this id'];
        }

        return (Post::destroy($id) ? 'Deleting post completed successfully' : 'There was an error deleting the post');
    }

    /**
     * search for post
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return (Post::query()->with(['writer', 'comments', 'tags'])->where('title', 'like', "%$title%")->get() ?? 'There is no post with this title here');
    }
}
