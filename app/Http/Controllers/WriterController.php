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
        $request->validate([
            'name' => 'required',
            'phone' => 'numeric|unique:writers,phone',
            'email' => 'email|unique:writers,email',
            'avatar' => 'unique:writers,avatar',
        ]);

        $status = Writer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'avatar' => $request->input('avatar')
        ]);

        if ($status) {
            return ['status: success' => 'Writer was successfully created'];
        }

        return ['status: fail' => 'Error creating new writer'];
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
