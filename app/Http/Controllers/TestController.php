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

class TestController extends Controller
{
    public function index($id = 2)
    {
        return redirect()->route('upload');
    }
}
