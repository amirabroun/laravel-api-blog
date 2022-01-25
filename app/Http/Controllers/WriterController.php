<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Writer::all();
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
            'name' => 'required',
            'phone' => 'numeric|unique:writers,phone',
            'email' => 'email|unique:writers,email',
            'avatar' => 'unique:writers,avatar',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        Writer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'avatar' => $request->input('avatar'),
        ]);

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Writer  $writer
     * @return \Illuminate\Http\Response
     */
    public function show(Writer $id)
    {
        $posts = Post::query()->where('writer_id', 1)->get(['title'])->toArray();

        $titles = "";

        foreach ($posts as $title) {
            $titles .= $title['title'] .', ';
        }
        
        $titles = ['title' => $titles];
        
        return [Writer::find($id), $titles];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $writer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'numeric|unique:writers,phone',
            'email' => 'email|unique:writers,email',
            'image' => 'unique:writers,image',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $writer = Writer::find($id);

        $writer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'avatar' => $request->input('avatar'),
        ]);

        // $writer = Writer::query()->where('id', $id)->first();

        // File::delete(storage_path('images/') . $writer->avatar);

        return response()->json([
            "success" => true,
            "message" => "File successfully updated",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $writer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Writer::destroy($id);
    }

    /**
     * search for writer
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Writer::query()->where('name', 'like', "%$name%")->get();
    }
}
