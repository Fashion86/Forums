<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Category;
use Exception;

class CategoryManageController extends Controller
{
    public function index(Category $M_category) {
        return $M_category->get();
    }

    public function store(Request $request, Category $M_category) {
        $meId = Auth::guard()->user()->id;
        if($request->type !== 'new') {
            $M_category = $M_category->find($request->id);
        }

        if($request->type === 'delete') {
            $M_category->delete();
            return response(1);
        }
        else if($request->type === 'disable' || $request->type === 'enable') {
            if($request->type === 'enable') {
                $M_category->isActivate = true;
            }
            else {
                $M_category->isActivate = false;
            }                
            $M_category->save();
            return response(1);
        }
        try {
            $M_category->user_id = $meId;
            $M_category->name = $request->category;
            $M_category->save();
            return response(1);
        } catch(Exception $e) {
            return response(0);
        }
    }
}
