<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use PhpMyAdmin\Config\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($data)) {
            return ['status' => 'fail'];
        }

        $user = User::find(Auth::user()->id);

        return response([
            'user' => $user,
            'token' => $user->createToken('access Token!')->accessToken,
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users,email',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user->save()) {
            return ['status: fail' => 'Error creating new user'];
        }

        return [
            'status: success' => 'user was successfully created',
            'data' => $user,
            'token' => $user->createToken('access Token!')->accessToken
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }
}
