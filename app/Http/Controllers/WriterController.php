<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WriterController extends Controller
{
    public function index()
    {
        return Writer::with(['posts', 'comments', 'tags'])->get();
    }

    /*
        name, phone, email, avatar
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'numeric|unique:writers,phone',
            'email' => 'email|unique:writers,email',
            'avatar' => 'unique:writers,avatar',
        ]);

        $writer = new Writer([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => $request->avatar
        ]);

        if (!$writer->save()) {
            return ['status: fail' => 'Error creating new writer'];
        }

        return [
            'status: success' => 'Writer was successfully created',
            'data' => $writer
        ];
    }

    public function show($id)
    {
        $writer = Writer::with(['posts', 'comments', 'tags'])->find($id);

        if (!$writer) {
            return ['error' => 'There is no writer with this id'];
        }

        return $writer;
    }

    /*
        id, name, phone, email, avatar
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

        if (!$writer->update($request->all())) {
            return ['status: fail' => 'Writer update encountered an error'];
        }

        return [
            'status: success' => 'Writer was successfully updated',
            'data' => $writer
        ];
    }


    public function destroy($id)
    {
        $writer = Writer::find($id);

        if (!$writer) {
            return ['error' => 'There is no writer with this id'];
        }

        return (Writer::destroy($id) ? 'Deleting writer completed successfully' : 'There was an error deleting the writer');
    }

    public function search($name)
    {
        return (Writer::query()->where('name', 'like', "%$name%")->get() ?? 'There is no writer with this title here');
    }
}
