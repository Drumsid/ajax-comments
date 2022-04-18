<?php

namespace App\Services\Sliders;

class SlidersGenerate
{
    public function run($comments)
    {
        $html = "";
        if (count($comments) < 1) {
            $html = "<div class='slide-item'>
                    There are no comments yet, but you can add them!
                </div>";
        } else {
            foreach ($comments as $comment) {
                $html .= "<div class='slide-item'>
                        <h4>Author: $comment->author</h4>
                        <p>Comment: $comment->comment</p>
                    </div>";
            }
        }
        return $html;
    }
}
