<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (Post::with('writer')->get() ?? 'There is no post here');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'writer_id' => 'required|numeric',
            'title' => 'required',
            'body' => 'required',
            'image_path' => 'unique:posts,image_path',
        ]);

        $wirter = Writer::find($request->input('writer_id'));
        $post = new Post([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image_path' => $request->input('image_path'),
        ]);
        

        if (!$wirter->posts()->save($post)) {
            return ['status: success' => 'Post was successfully created'];
        }

        return ['status: fail' => 'Error creating new post'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('writer')->find($id);

        if (!$post) {
            return ['error' => 'There is no post with this id'];
        }

        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        if ($post->update($request->all())) {
            return ['status: success' => 'Post was successfully updated'];
        }

        return ['status: fail' => 'Post update encountered an error'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        return (Post::query()->with('writer')->where('title', 'like', "%$title%")->get() ?? 'There is no post with this title here');
    }
}
