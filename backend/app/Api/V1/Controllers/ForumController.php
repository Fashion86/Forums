<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;
use App\Category;
use App\Discusstion;

use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    public function categoryGroup($categoryId, Category $M_categories) {
        $returnJson = array();
        $M_categories = $M_categories->popular()->with('tags');
        if($categoryId !== 'null') {
            $M_categories = $M_categories->where('id', $categoryId);
        }
        $M_categories = $M_categories->get();
        foreach($M_categories as $m_category) {
            $eachCategory = array(
                'name' => $m_category->name,
                'tags' => array(),
                'total_post_count' => 0
            );
            $tags = & $eachCategory['tags'];
            
            $M_tags = $m_category->tags;
            foreach($M_tags as $m_tag) {
                $post_count = $m_tag->posts()->select('id')->count();
                $tags[] = array(
                    'tag' => $m_tag->toArray(),
                    'post_count' => $post_count
                );
                $eachCategory['total_post_count'] += $post_count;
            }
            array_push($returnJson, $eachCategory);
        }

        return response()->json(['status' => 'ok', 'data' => $returnJson]);
    }
    
    public function store(Request $request) {

    }

    public function getDiscusstion($tagId, Request $request, Discusstion $M_discusstions) {
        DB::enableQueryLog();
        $M_discusstions = $M_discusstions
                            ->where('discusstions.tag_id', $tagId)
                            ->select('discusstions.*', 'users.username')
                            ->join('users', 'users.id', '=', 'discusstions.user_id')
                            ->with(['posts' => function($query) {
                                $query->orderBy('updated_at');
                            }])
                            ->get();
        $returnJson = array();
        foreach($M_discusstions as $m_discustion) {
            $eachJson = array(
                'title' => $m_discustion->title,
                'username' => $m_discustion->username,
                'post_count' => $m_discustion->post_count,
                'view_count' => $m_discustion->view_count,
                'latest_post' => ''//$m_discustion->posts
            );
            $returnJson[] = $eachJson;
            // print_r($m_discustion->posts);
        }

        return response()->json(array(
            'Rows' => $returnJson,
            'TotalRows' => 200
        ));
        // print_r(DB::getQueryLog());


        // print_r($request->post());
    }
}
