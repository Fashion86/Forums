<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Tag;

use Exception;

class TagManageController extends Controller
{
    public function index(Tag $M_tags) {
        $M_tags = $M_tags->join('categories', 'categories.id', '=', 'tags.category_id')
                        ->select('tags.*', 'categories.name as category_name')
                        ->where('categories.isActivate', 1)
                        ->get();
        return $M_tags;
    }
    
    public function show($categoryId, Tag $M_tags) {
        return $M_tags
                ->where('tags.category_id', $categoryId)
                ->select('tags.*')
                ->join('categories', 'tags.category_id', '=', 'categories.id')->get();
    }

    public function store(Request $request, Tag $M_tags) {
        $record = $request->all();
        foreach($record as $field => $fieldData) {
            $M_tags->{$field} = $fieldData;
        }

        $saved = false;
        $saved = $M_tags->save();
        
        return response()->json($saved);
    }

    public function update($id, Tag $M_tags, Request $request) {
        $M_tags = $M_tags->find($id);
        $record = $request->all();
        foreach($record as $field => $fieldData) {
            $M_tags->{$field} = $fieldData;
        }
        $updated = false;
        try {
            $updated = $M_tags->save();
        } catch(Exception $e) {
            $updated = false;
        }
        return response()->json($updated);
    }

    public function destroy($id, Tag $M_tags) {
        $M_tags = $M_tags->find($id);

        $deleted = false;
        try {
            $deleted = $M_tags->delete();
        } catch(Exception $e) {
            $deleted = false;
        }
        return response()->json($deleted);
    }
}
