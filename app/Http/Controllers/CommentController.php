<?php

namespace App\Http\Controllers;

use App\Services\Comments\CommentGenerate;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    private $commentGenerate;

    const PAGINATE_COUNT = 3;

    public function __construct(CommentGenerate $commentGenerate)
    {
        $this->commentGenerate = $commentGenerate;
    }

    public function getSliders(Request $request)
    {
        if ($request->ajax()) {
            $commentsCount = Comment::all()->count();
            if ($commentsCount < 5) {
                $commentsSlider =  Comment::all()->random($commentsCount);
            } else {
                $commentsSlider =  Comment::all()->random(5);
            }

            $html = "";
            foreach ($commentsSlider as $slide) {
                $html .= "<div class='slide-item'>
                        <h4>Author: $slide->author</h4>
                        <p>Comment: $slide->comment</p>
                    </div>";
            }
            return response()->json([
                'status'=>200,
                'html' => $html,
            ]);
        }

    }

    public function getComments(Request $request)
    {
        $comments = Comment::orderBy("created_at", 'desc')->paginate(self::PAGINATE_COUNT);
        $allCommentsCount = Comment::all()->count();
        if ($request->ajax()) {
            $html = $this->commentGenerate->run($comments);
            return response()->json([
                'status'=>200,
                'html' => $html,
                'count' => count($comments),
                'allCommentsCount' => $allCommentsCount,
                ]);
        }
        return response()->view("homepage");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author' => 'required|min:3|max:120',
            'comment' => 'required|min:10|max:1020',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $comment = new Comment;
            $comment->fill($validator->validated());
            $comment->save();
            return response()->json([
                'status'=>200,
                'message'=>'Comment Added Successfully.'
            ]);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Comment Deleted Successfully.'
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'No Comment Found.'
            ]);
        }
    }
}
