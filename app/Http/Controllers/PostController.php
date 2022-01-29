<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'writer_id' => 'required|numeric',
            'title' => 'required',
            'body' => 'required',
            'image_path' => 'unique:posts,image_path',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        return Post::create([
            'writer_id' => $request->input('writer_id'),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image_path' => $request->input('image_path'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return [
            'id' => $post->id,
            'title' => $post->title,
            'writer_name' => $post->writer->name,
            'body' => $post->body,
            'image_path' => $post->image_path,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ];
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
        $validator = Validator::make($request->all(), [
            'writer_id' => 'required|numeric',
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $post = Post::find($id);

        if (!$post) {
            return ['error' => 'There is no post with this id'];
        }

        return $post->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::destroy($id);
    }

    /**
     * search for post
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return Post::query()->where('title', 'like', "%$title%")->get();
    }
}
