<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make(array('image' => $request->image), [
            'image' => 'required|mimes:png,jpg,img|max:5048'
        ]);

        if ($validator->fails()) {
            $errors = json_decode($validator->errors(), true);

            $error =  $errors['image'][0];

            return view('/upload')->with('error', $error);
        }

        $path = Storage::put('/images', new File($request->image));

        return view('upload')->with('path', $path);
    }
}
