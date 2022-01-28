<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        return Writer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'avatar' => $request->input('avatar'),
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
        $writer = Writer::find($id);

        if (!$writer) {
            return ['error' => 'There is no writer with this'];
        }

        return [
            'id' => $writer->id,
            'name' => $writer->name,
            'phone' => $writer->phone,
            'email' => $writer->email,
            'posts' => $writer->posts,
        ];
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
            'avatar' => 'unique:writers,avatar',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // $writer = Writer::query()->where('id', $id)->first();

        // File::delete(storage_path('images/') . $writer->avatar);

        $writer = Writer::find($id);

        return $writer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'avatar' => $request->input('avatar'),
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
