<?php

namespace App\Services\Search;

class HintsGenerate
{
    public function run($data)
    {
        $html = '';
        foreach ($data as $item) {
            $html .= "<div  class='d-flex justify-content-between align-items-center mt-3' style='width: 25%;'>
                                <div class='search_result-name'>
                                    <a href='#'>$item</a>
                                </div>
                            </div>";
        }
        return $html;
    }
}
