<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class AjaxSearchController extends Controller
{
    public function ajaxSearch(Request $request)
    {

        if ($request->ajax()) {
            $search = $request->search;
            $result = Comment::query()->where('author', 'LIKE', "%{$search}%")->pluck("author");
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
            ]);
        }
        return response()->json([
            'html' => "error"
        ]);
    }
}
