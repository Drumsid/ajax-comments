<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\Comments\CommentGenerate;
use App\Services\Sliders\SlidersGenerate;
use Illuminate\Http\Request;

class AjaxSearchController extends Controller
{
    private $commentGenerate;

    public function __construct(CommentGenerate $commentGenerate)
    {
        $this->commentGenerate = $commentGenerate;
    }
    public function ajaxSearch(Request $request)
    {

        if ($request->ajax()) {
            $search = $request->search;
            $result = Comment::getColumnData($search);
            $html = "";
            if (count($result) >= 1) {
                foreach ($result as $item) {
                    $html .= "<div  class='d-flex justify-content-between align-items-center mt-3' style='width: 25%;'>
                                <div class='search_result-name'>
                                    <a href='#'>$item</a>
                                </div>
                            </div>";
                }
            }
            return response()->json([
                'html' => $html,
                'status' => 200,
            ]);
        }
        return response()->json([
            'html' => "error"
        ]);
    }

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
