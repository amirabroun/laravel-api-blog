<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tags,title',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tag = new Tag([
            'title' => $request->input('title')
        ]);

        if ($tag->save()) {
            return ['status: ' => 'success'];
        }

        return ['status: ' => 'fail'];
    }

    public function show($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return ['error' => 'There is no tag with this id'];
        }

        return Tag::query()
            ->whereHasMorph(
                'taggable',
                [Post::class, Writer::class]
            )
            ->with('taggable')
            ->where('id', $id)
            ->get();
    }

    public function update(Request $request, Tag $tag)
    {
        //
    }

    public function destroy(Tag $tag)
    {
        //
    }

    public function createTaggable($tag_id, $taggable_id, $taggable_type)
    {
    }
}
