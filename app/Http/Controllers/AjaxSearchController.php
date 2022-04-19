<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\Comments\CommentGenerate;
use App\Services\Search\HintsGenerate;
use Illuminate\Http\Request;

class AjaxSearchController extends Controller
{
    /**
     * @var CommentGenerate
     */
    private $commentGenerate;
    /**
     * @var HintsGenerate
     */
    private $hintsGenerate;

    /**
     * @param CommentGenerate $commentGenerate
     * @param HintsGenerate $hintsGenerate
     */
    public function __construct(CommentGenerate $commentGenerate, HintsGenerate $hintsGenerate)
    {
        $this->commentGenerate = $commentGenerate;
        $this->hintsGenerate = $hintsGenerate;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSearch(Request $request)
    {

        if ($request->ajax()) {
            $search = $request->search;
            $result = Comment::getColumnData($search);
            $html = "";
            if (count($result) >= 1) {
                $html = $this->hintsGenerate->run($result);
            }
            return response()->json([
                'html' => $html,
                'status' => 200,
            ]);
        }
        return response()->json([
            'html' => "error",
            'status' => 400,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            if ($search) {
                $result = Comment::search($search);
                $html = $this->commentGenerate->run($result);
                return response()->json([
                    'html' => $html,
                    'status' => 200,
                ]);
            }
        }

        return response()->json([
            'html' => "error empty",
            'status' => 400,
        ]);
    }
}
