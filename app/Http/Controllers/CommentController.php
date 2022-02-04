<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Writer;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::query()
            ->whereHasMorph('commentable', [Post::class, Writer::class])
            ->with('commentable')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'name' => 'required',
            'email' => 'required',
            'commentable_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $comment = new Comment([
            'comment' => $request->input('comment'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'commentable_id' => $request->input('commentable_id'),
        ]);

        if ($request->input('type') === 'post') {
            $status = Post::find($request->input('commentable_id'))->comments()->save($comment);

            if ($status) {
                return ['status: success' => 'The comment is successfully created'];
            }

            return ['status: fail' => 'The comment is not created'];
        } else if ($request->input('type') === 'writer') {
            $status = Writer::find($request->input('commentable_id'))->comments()->save($comment);

            if ($status) {
                return ['status: success' => 'The comment is successfully created'];
            }

            return ['status: fail' => 'The comment is not created'];
        } else {
            return ['status: fail' => 'The type unknown'];
        }

        return ['error' => 'The type not supported'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return ['error' => 'There is no comment with this id'];
        }

        return (Comment::destroy($id) ? 'Comment successfully deleted' : 'The comment is not delelted');
    }
}
