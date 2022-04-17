<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function post(Request $request)
    {
        $comments = Comment::paginate(3);

        if ($request->ajax()) {
            $html = '';

            foreach ($comments as $comment) {
                $html .= '<div class="mt-5"><h1>' . $comment->author . '</h1><p>' . $comment->comment . '</p></div>';
            }

            return $html;
        }

        return view('post');
    }
}
