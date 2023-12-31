<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store($post_id, Request $request)
    {
        $request->validate([
            'comment_body' . $post_id => 'required|max:150'
        ],
        [
            'comment_body' . $post_id . '.required' => 'Cannot submit an empty comment.',
            'comment_body' . $post_id . '.max' => 'The comment must not be greater than 150 characters.',
        ]);

        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->body = $request->input('comment_body' . $post_id);
        $this->comment->save(); // INSERT INTO comments(user_id,post_id,comment_body) VALUES($user_id, $post_id, $comments);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->comment->destroy($id);
        return redirect()->back();
    }
}
