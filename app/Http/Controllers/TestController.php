<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function post(Request $request)
    {
        $comments = Comment::paginate(3);
//        dd(\Auth::user());
        if ($request->ajax()) {
            $html = '';

            foreach ($comments as $comment) {
                $html .= '<div class="mt-5"><h1>' . $comment->author . '</h1><p>' . $comment->comment . '</p></div>';
            }

            return $html;
        }

        return view('post');
    }

    public function getComments(Request $request)
    {
        $comments = Comment::paginate(3);
        if ($request->ajax()) {
            $html = '';

            foreach ($comments as $comment) {
                $html .= "<div class='comment-wrap'>
                            <button value='' class='btn btn-danger btn-sm delete-comment-btn' data-bs-toggle='modal'
                data-bs-target='#CommentDeleteModal'>x</button>
                            <div class='comment-text'>{$comment->comment}</div>
                            <div class='author-wrap'>
                                <div><b>Author:</b> {$comment->author}</div>
                                <div><b>Data: </b> {$comment->updated_at}</div>
                            </div>
                        </div>";
            }

            return $html;
        }
    }
}
