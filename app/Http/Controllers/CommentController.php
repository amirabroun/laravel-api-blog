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
            $post = Post::find($request->input('commentable_id'));

            return  $post->comments()->save($comment);
        } else if ($request->input('type') === 'writer') {
            $writer = Writer::find($request->input('commentable_id'));

            return $writer->comments()->save($comment);
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
