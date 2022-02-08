<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        return Tag::with(['posts', 'writers'])->get();
    }

    /*
        title, related = null, taggable_id = null
    */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
        ]);

        if ($request->input('related')) {
            $request->validate([
                'taggable_id' => 'required|numeric',
            ]);
        }

        $tag = Tag::query()->where('title', $request->input('title'))->first();

        if (!$tag) {
            $tag = new Tag([
                'title' => $request->input('title')
            ]);
        }

        if ($request->input('related') === 'post') {
            $post = Post::find($request->input('taggable_id'));

            if (!$post->tags()->save($tag)) {
                return [
                    'status: ' => 'fail',
                ];
            }

            return [
                'status: ' => 'success',
                'data: ' => [$post, $tag]
            ];
        } else if ($request->input('related') === 'writer') {
            $writer = Writer::find($request->input('taggable_id'));

            if ($writer->tags()->save($tag)) {
                return [
                    'status: ' => 'fail',
                ];
            }

            return [
                'status: ' => 'success',
                'data: ' => [$writer, $tag]
            ];
        }

        return [
            'status: ' => 'success',
            'data' => $tag
        ];
    }

    public function show($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return ['error' => 'There is no tag with this id'];
        }

        return Tag::query()
            ->with(['posts', 'writers'])
            ->find($id);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return ['error' => 'There is no tag with this id'];
        }

        $request->validate([
            'title' => 'required|unique:tags,title',
        ]);

        if (!$tag->update(['title' => $request->input('title')])) {
            return ['status: fail' => 'Tag update encountered an error'];
        }

        return [
            'status: success' => 'Tag was successfully updated',
            'data' => $tag
        ];
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return ['error' => 'There is no tag with this id'];
        }

        if (!Tag::destroy($id)) {
            return ['status: fail' => 'Tag destroy encountered an error'];
        }

        return ['status: success' => 'Tag was successfully deleted'];
    }
}
