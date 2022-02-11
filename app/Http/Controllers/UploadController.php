<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:png,jpg,img|max:5048'
        ]);

        $path = Storage::putFile('public/images', new File($request->image));

        return view('upload')->with('path', $path);
    }
}
