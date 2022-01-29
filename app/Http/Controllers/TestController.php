<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Http\File;
use App\Models\Post;
use App\Models\Writer;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        return redirect(url('/upload'));
    }
}
