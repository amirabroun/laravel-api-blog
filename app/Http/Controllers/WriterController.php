<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Writer::with('posts')->get() ?? 'There is no writer here';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'numeric|unique:writers,phone',
            'email' => 'email|unique:writers,email',
            'avatar' => 'unique:writers,avatar',
        ]);

        $writer = new Writer([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'avatar' => $data['avatar'] ?? null
        ]);

        if (!$writer->save()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error creating new writer'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'success',
            'data' => [
                'writer' => $writer
            ]
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
        $writer = Writer::with('posts')->find($id);

        if (!$writer) {
            return ['error' => 'There is no writer with this id'];
        }

        return $writer;
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
        $writer = Writer::find($id);

        if (!$writer) {
            return ['error' => 'There is no writer with this id'];
        }

        $request->validate([
            'name' => 'required',
            'phone' => 'numeric|unique:writers,phone',
            'email' => 'email|unique:writers,email',
            'avatar' => 'unique:writers,avatar',
        ]);

        // $writer = Writer::query()->where('id', $id)->first();

        // File::delete(storage_path('images/') . $writer->avatar);

        if ($writer->update($request->all())) {
            return ['status: success' => 'Writer was successfully updated'];
        }

        return ['status: fail' => 'Writer update encountered an error'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $writer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $writer = Writer::find($id);

        if (!$writer) {
            return ['error' => 'There is no writer with this id'];
        }

        return (Writer::destroy($id) ? 'Deleting writer completed successfully' : 'There was an error deleting the writer');
    }

    /**
     * search for writer
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return (Writer::query()->where('name', 'like', "%$name%")->get() ?? 'There is no writer with this title here');
    }
}
