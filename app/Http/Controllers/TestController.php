<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Http\File;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Writer;
use App\Models\Tag;
use App\Models\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function index(Request $request, $id = 2)
    {
        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        return $user->createToken('Auth Token');

        //
        
        if (!Auth::attempt($request)) {
            return ['message' => 'Invalid login'];
        }

        $writer = Writer::query()->find($request->input('id'));

        $token = $writer->createToken('My Token')->accessToken;

        return response([
            'writer' => Auth::user(),
            'token' => $token
        ]);

        return redirect()->route('upload');
    }
}
