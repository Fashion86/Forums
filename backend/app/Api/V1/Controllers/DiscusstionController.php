<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Discusstion;
use Illuminate\Support\Facades\DB;
use Auth;

class DiscusstionController extends Controller
{
    private $user;
    public function __construct()  {
        $this->user = Auth::guard()->user();
    }
    public function index() {
        
    }
    
    public function store(Request $request, Post $M_posts, Discusstion $M_discusstions) {
        $validatedData = $request->validate([
            'tag_id' => 'required|integer',
            'category_id' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string'
        ]);
        $validatedData['user_id'] = $this->user->id;
        $validatedData['post_count'] = 1;
        try {
            DB::beginTransaction();
            foreach($validatedData as $field => $value) {
                $M_discusstions->{$field} = $value;
            }
            $M_discusstions->save();

            unset($validatedData['post_count']);
            unset($validatedData['title']);

            $validatedData['discusstion_id'] = $M_discusstions->id;

            foreach($validatedData as $field => $value) {
                $M_posts->{$field} = $value;
            }
            $M_posts->save();
            DB::commit();

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error']);
            DB::rollBack();
        }
    }
}
