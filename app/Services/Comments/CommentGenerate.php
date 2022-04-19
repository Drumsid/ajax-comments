<?php

namespace App\Services\Comments;

use App\Models\Comment;

class CommentGenerate
{
    public function run($comments)
    {
//        тут админ а не юзер будет
        if (\Auth::user()) {
            return $this->adminRender($comments);
        }
        return $this->guestRender($comments);
    }

    private function adminRender($comments)
    {
        $html = '';
        foreach ($comments as $comment) {
            $html .= "<div class='comment-wrap'>
                            <button value='{$comment->id}'
                                class='btn btn-danger btn-sm delete-comment-btn'
                                data-bs-toggle='modal'
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

    private function guestRender($comments)
    {
        $html = '';
        foreach ($comments as $comment) {
            $html .= "<div class='comment-wrap'>
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
