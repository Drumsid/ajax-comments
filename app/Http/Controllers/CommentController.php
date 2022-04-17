<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
//    public function getComments()
//    {
//        $comments = Comment::orderBy("created_at", 'desc')->get();
//        return response()->json([
//            'comments' => $comments,
//            ]);
//    }

    public function getComments(Request $request)
    {
        $comments = Comment::orderBy("created_at", 'desc')->paginate(3);
        if ($request->ajax()) {
            $html = '';

            foreach ($comments as $comment) {
                $html .= "<div class='comment-wrap'>
                            <button value='{$comment->id}' class='btn btn-danger btn-sm delete-comment-btn' data-bs-toggle='modal'
                data-bs-target='#CommentDeleteModal'>x</button>
                            <div class='comment-text'>{$comment->comment}</div>
                            <div class='author-wrap'>
                                <div><b>Author:</b> {$comment->author}</div>
                                <div><b>Data: </b> {$comment->updated_at}</div>
                            </div>
                        </div>";
            }

            return response()->json([
                'status'=>200,
                'html' => $html,
                'count' => count($comments),
                ]);
        }
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
