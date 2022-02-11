<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Writer;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::query()
            ->whereHasMorph('commentable', [Post::class, Writer::class])
            ->with('commentable')
            ->get();
    }

    /*
        comment, name, email, commentable_id, related
    */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'name' => 'required',
            'email' => 'required',
            'commentable_id' => 'required',
            'related' => 'required',
        ]);

        $comment = new Comment([
            'comment' => $request->comment,
            'name' => $request->name,
            'email' => $request->email,
            'commentable_id' => $request->commentable_id,
        ]);

        if ($request->related === 'post') {
            if (!Post::find($request->commentable_id)->comments()->save($comment)) {
                return ['status: fail' => 'The comment is not created'];
            }
        } else if ($request->related === 'writer') {
            if (!Writer::find($request->commentable_id)->comments()->save($comment)) {
                return ['status: fail' => 'The comment is not created'];
            }
        } else {
            return ['status: fail' => 'The related unknown'];
        }

        return [
            'status: success' => 'The comment is successfully created',
            'data' => $comment
        ];
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return ['error' => 'There is no comment with this id'];
        }

        return Comment::query()
            ->whereHasMorph(
                'commentable',
                [Post::class, Writer::class]
            )
            ->with('commentable')
            ->where('id', $id)
            ->get();
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return ['error' => 'There is no comment with this id'];
        }

        $request->validate([
            'comment' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($comment->update($request->all())) {
            return ['status: success' => 'Comment was successfully updated'];
        }

        return ['status: fail' => 'Comment update encountered an error'];
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return ['error' => 'There is no comment with this id'];
        }

        return (Comment::destroy($id) ? 'Comment successfully deleted' : 'The comment is not delelted');
    }
}
