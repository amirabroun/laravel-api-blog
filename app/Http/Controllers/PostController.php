<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return DB::table('posts as p')
            ->leftJoin('writers AS w', 'p.writer_id', '=', 'w.id')
            ->select('p.id', 'w.name as writer_name', 'p.title', 'p.body', 'p.image_path')
            ->get();
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
        return DB::table('posts as p')
            ->leftJoin('writers as w', 'p.writer_id', '=', 'w.id')
            ->select('p.id', 'w.name as writer_name', 'p.title', 'p.body', 'p.image_path')
            ->where('p.id', '=', $id)
            ->get();
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
