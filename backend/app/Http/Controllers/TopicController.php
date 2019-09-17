<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTFactory;
use JWTAuth;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Validator;
use Response;
use Illuminate\Support\Facades\Auth;


class TopicController extends Controller
{
    public function addTopic(Request $request) {
        $category = User::find($request->get('category'));
        return response()->json('ggggg', 500);
        }
}
