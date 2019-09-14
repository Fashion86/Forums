<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class UserManageController extends Controller
{
    public function index(User $M_users) {
        $meId = Auth::guard()->user()->id;
        
        $M_users = $M_users
                    ->where('id', '<>', $meId);

        $TotalRows = $M_users->count();
        return array(
            'TotalRows' => $TotalRows,
            'Rows' => $M_users->get()->toArray()
        );
    }
}
