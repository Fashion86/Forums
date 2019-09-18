<?php

namespace App\Http\Controllers;

use App\Category;
use App\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTFactory;
use JWTAuth;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Validator;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TopicController extends Controller
{
    public function addTopic(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'user_id' => 'required',
            'title'=> 'required',
            'content'=> 'required|min:30',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        Discussion::create([
            'category_id' => $request->get('category_id'),
            'user_id' => $request->get('user_id'),
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);
        $discussion = Discussion::first();
        return response()->json(['data'=>'Topic Successfully Added', 'topic'=>$discussion], 201);
        }

    public function getTopics($category_name) {
        try {
            $category = DB::table('categories')->where('name', $category_name)->first();
            $topics = DB::table('discussions')
                ->join('users', 'discussions.user_id', '=', 'users.id')
                ->select('discussions.*', 'users.username')
                ->where('discussions.category_id', $category->id)
                ->orderBy('discussions.created_at', 'desc')
                ->get();
            foreach ($topics as $topic) {
                $posts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.*', 'users.username')
                    ->where('posts.discussion_id', $topic->id)
                    ->orderBy('posts.created_at', 'desc')
                    ->get();
                $user = User::find($topic->user_id);
                $topic->user = $user;
                $topic->posts = $posts;
//                $topic->latestpost = $posts[0];
            }
            return response()->json(['success'=>true, 'data'=>$topics], 201);
        } catch(\Exception $e) {
            return response()->json(['error'=>$e], 500);
        }

    }

    public function getTopicById($id) {
        try {
//            $topic = DB::table('discussions')
//                ->join('users', 'discussions.user_id', '=', 'users.id')
//                ->select('discussions.*', 'users.username')
//                ->where('discussions.id', $id)
//                ->first();
            $topic = Discussion::find($id);
            $posts = DB::table('posts')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'users.username')
                ->where('posts.discussion_id', $id)
                ->orderBy('posts.created_at', 'desc')
                ->get();
            $user = User::find($topic->user_id);
            $topic->user = $user;
            $topic->posts = $posts;
            return response()->json(['success'=>true, 'data'=>$topic], 201);
        } catch(\Exception $e) {
            return response()->json(['error'=>$e], 500);
        }

    }

    public function deleteTopic($id) {
        $topic = Discussion::find($id);
        try {
            $topic->delete();
            return response()->json(['success'=>'Topic Successfully Removed']);
        } catch(\Exception $e) {
            return response()->json(['error'=>$e], 500);
        }
    }
}
