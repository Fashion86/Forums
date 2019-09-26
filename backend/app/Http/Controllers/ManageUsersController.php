<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Response;

use App\Http\Controllers\Controller;
use JWTFactory;
use JWTAuth;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Input;



class ManageUsersController extends Controller
{
    //
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required',
            'firstName'=> 'required',
            'lastName'=> 'required',
            'phone'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'avatar' => $request->get('avatar'),
                'firstName' => $request->get('firstName'),
                'lastName' => $request->get('lastName'),
                'middleName' => $request->get('middleName'),
                'phone' => $request->get('phone'),
                'active_status' => 0,
            ]);

            $role_ids = $request->get('role_ids'); // get  Roles from post request
            foreach ($role_ids as $role_id) {
                $role = Role::find($role_id);
                $user->roles()->attach($role);
            }
            $token = JWTAuth::fromUser($user);

            return Response::json(['result' => 'success', 'user' => $user, 'token' => $token]);
        } catch (JWTException $e) {
            return Response::json(['error' => 'This email is already registered'], 500);
        }
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'name' => 'required',
            'password'=> 'required',
            'avatar'=> 'required',
            'firstName'=> 'required',
            'lastName'=> 'required',
            'phone'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->get('id'));
        if ($user->email == $request->get('email')) {
            $user->update([
                'name' => $request->get('name'),
                'password' => bcrypt($request->get('password')),
                'avatar' => $request->get('avatar'),
                'firstName' => $request->get('firstName'),
                'lastName' => $request->get('lastName'),
                'middleName' => $request->get('middleName'),
                'phone' => $request->get('phone'),
            ]);
        } else {
            $user->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'avatar' => $request->get('avatar'),
                'firstName' => $request->get('firstName'),
                'lastName' => $request->get('lastName'),
                'middleName' => $request->get('middleName'),
                'phone' => $request->get('phone'),
            ]);
        }

        DB::table('model_has_roles')->where('model_id', $request->get('id'))->delete();
        $role_ids = $request->get('role_ids');
        foreach ($role_ids as $role_id) {
            $role = Role::find($role_id);
            $user->assignRole($role);
        }
        $token = JWTAuth::fromUser($user);

        return Response::json(['result'=>'User Successfully Updated', 'user'=>$user, 'token'=>$token]);
    }

    public function activeUser(Request $request) {
        $user = User::find($request->get('id'));
        $user->update(['is_activated'=>$request->get('is_activated')]);

        $user = User::first();
        $token = JWTAuth::fromUser($user);

        return response()->json(['data'=>'User Successfully Changed', 'token'=>$token], 201);
    }

    public function deleteUser($id) {
        $user = User::find($id);
        try {
            $user->delete();
            return response()->json(['success'=>'User Successfully Removed']);
        } catch(\Exception $e) {
            return response()->json(['error'=>$e], 500);
        }
    }

    public function setUserRole(Request $request)
    {
//        $request = $request->all();
        $email=$request['email'];
        $userRole=$request['userRole'];
        $user = User::where('email',$email)->first();
        if ($user == null) {
            return response()->json(['error'=>'can\'t find user with this email'], 500);
        }
//        $role = $request->get('userRole');
        $role = Role::findByName($userRole);
        if ($role == null) {
            return response()->json(['error'=>'can\'t find this user role'], 500);
        }
        $user->assignRole($role);
        return response()->json(['result'=>'success']);
    }

    public function getRoleNames() {
        $roles = Role::all();
        foreach ($roles as $role) {
            $role_names[] = $role['name'];
        }
        return $roles;
    }

    public function getUserRoles($user) {
        $roles = $user->getRoleNames();
        return $roles;
    }

    public function getUsers() {
        try {
//            $user = JWTAuth::toUser(JWTAuth::parseToken());
            $page = Input::get('pageNo') != null ? Input::get('pageNo') : 1;
            $limit = Input::get('numPerPage') != null ? Input::get('numPerPage') : 30;
            $role_name = Input::get('rolename') != null ? Input::get('rolename') : null;

            if ($role_name == null) {
                $totalCount = count(User::all());
                $users = User::orderBy('username', 'asc')->skip(($page - 1) * $limit)->take($limit)->get();
            } else {
                $role = Role::findByName($role_name);
                $totalCount = count(User::role($role)->get());
                $users = User::role($role)->skip(($page - 1) * $limit)->take($limit)->get();
            }
            if ($totalCount == 0) {
                return response()->json(['totalCount'=>$totalCount, 'userdata'=>[]], 200);
            } else {
//                foreach ($users as $user) {
//                    $roles = $this->getUserRoles($user);
//                    $user->push($roles);
//                    $userdatas[] = $user;
//                }
                return response()->json(['totalCount'=>$totalCount, 'userdata'=>$users], 200);
            }
        } catch (JWTException $e) {
            return response()->json(['error'=>'User is not Logged in'], 500);
        }
    }

    public function getUserByID($id) {
        try {
            $user = User::find($id);
            $posts = DB::table('posts')
                ->join('discussions', 'discussions.id', '=', 'posts.discussion_id')
                ->join('categories', 'categories.id', '=', 'discussions.category_id')
                ->select('posts.*', 'discussions.title as topic_name', 'categories.name as category_name')
                ->where('posts.user_id', $id)
                ->orderBy('posts.created_at', 'desc')
                ->limit(3)
                ->get();
            $topics = DB::table('discussions')
                ->join('categories', 'categories.id', '=', 'discussions.category_id')
                ->select('discussions.*', 'categories.name as category_name')
                ->where('discussions.user_id', $id)
                ->orderBy('discussions.created_at', 'desc')
                ->limit(3)
                ->get();
            $user->posts = $posts;
            $user->topics = $topics;
            return response()->json(['success'=>true, 'data'=>$user], 201);
            }
        catch(\Exception $e) {
            return response()->json(['error'=>$e], 500);
        }
    }

    public function addPermission(Request $request) {
        try {
//            if ($user = JWTAuth::toUser(JWTAuth::parseToken())) {
                try {
                    $permission = Permission::create(['name' => $request->get('name')]);
                    return response()->json(['result' => 'Permission Successfully Created!', 'permission' => $permission], 200);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Permission Already Exist!'], 500);
                }
//            } else {
//                return response()->json(['error' => 'User not Found'], 404);
//            }
        } catch (\Exception $e) {
            return response()->json(['error'=>'Failed Permission Exist!'], 500);
        }
    }

    public function updatePermission(Request $request) {
        try {
//            if ($user = JWTAuth::toUser(JWTAuth::parseToken())) {
                $permission = DB::table('permissions')->where('id', $request['id'])->update(['name' => $request['name']]);
                return response()->json(['result' => 'Permission Successfully Updated!'], 200);
//            } else {
//                return response()->json(['error' => 'User not Found'], 404);
//            }
        } catch (\Exception $e) {
            return response()->json(['error'=>'Failed Permission Updating!'], 500);
        }
    }

    public function deletePermission(Request $request) {
        try {
//            if ($user = JWTAuth::toUser(JWTAuth::parseToken())) {
                $permission = DB::table('permissions')->where('id', $request['id'])->delete();
                if ($permission) {
                    return response()->json(['result' => 'Permission Successfully Deleted!'], 200);
                }
                else {
                    return response()->json(['result' => 'Current Permission is not exist!'], 404);
                }
//            } else {
//                return response()->json(['error' => 'User not Found'], 404);
//            }
        } catch (\Exception $e) {
            return response()->json(['error'=>'Failed Permission Delete!'], 500);
        }
    }

    public function getPermissions(Request $request) {
        try {

//            $user = JWTAuth::toUser(JWTAuth::parseToken());
            $page = $request->filled('pageNo') ? $request->get('pageNo') : 1;
            $limit = $request->filled('numPerPage') ? $request->get('numPerPage') : 10;
            $permissions = Permission::orderBy('updated_at', 'desc')->skip(($page-1)*$limit)->take($limit)->get();
            $totalCount = Permission::count();
            return response()->json(['total '=>$totalCount, 'data'=>$permissions], 200);;

        } catch (\Exception $e) {
            return response()->json(['error'=>'User is not loggedIn!'], 500);
        }
    }

    public function addRole(Request $request) {
        try {
//            if ($user = JWTAuth::toUser(JWTAuth::parseToken())) {
            try {
                $role = Role::Create(['name' => $request->get('name')]);
                $permission_ids = $request['permission_ids'];
                foreach ($permission_ids as $permission_id) {
                    $permission = Permission::findById($permission_id);
                    $role->givePermissionTo($permission);
                }
                return response()->json(['result' => 'Successfully Created Role with Permissions'], 200);
            } catch (JWTException $e) {
                return response()->json(['error' => 'Already Created This Role'], 500);
            }
//            } else {
//                return response()->json(['error' => 'User not Found'], 404);
//            }
        } catch (JWTException $e) {
            return response()->json(['error'=>'Failed Create Role'], 500);
        }
    }

    public function getRoleByID() {
        $roleId = Input::get('roleId') != null ? Input::get('roleId') : 1;
        $role = Role::where('id', $roleId)->first();
        $datas = [];
        if ($role != null) {
            $permission_ids = DB::table('role_has_permissions')->where('role_id', $roleId)->get();
            if ($permission_ids != null) {
                $role->permission_ids = [];
                foreach ($permission_ids as $permission_id) {
                    array_push($datas, $permission_id->permission_id);
                }
                $role->permission_ids = $datas;
            } else {
                $role->permission_ids = [];
            }
            return response()->json(['roledata' => $role], 200);
        } else {
            return response()->json(['error' => 'No user with this id: '.$roleId], 404);
        }
    }

    public function updateRole(Request $request) {
        try {
//            if ($user = JWTAuth::toUser(JWTAuth::parseToken())) {
            $cur_role = Role::findById($request['id']);
            if ($request['role_name'] != $cur_role->name) {
                DB::table('roles')->where('id', $request['id'])->update(['name' => $request['name']]);
            }
            $role = Role::findById($request['id']);
            DB::table('role_has_permissions')->where('role_id', $request['id'])->delete();
            $permission_ids = ($request['permission_ids']);
            foreach ($permission_ids as $permission_id) {
                $permission = Permission::findById($permission_id);
                $role->givePermissionTo($permission);
                $permission->assignRole($role);
            }
            return response()->json(['result' => 'Successfully Updated Role with Permissions'], 200);
//            } else {
//                return response()->json(['error' => 'User not Found'], 404);
//            }
        } catch (JWTException $e) {
            return response()->json(['error'=>'Failed Update Role'], 500);
        }
    }

    public function deleteRole(Request $request) {
        try {
//            if ($user = JWTAuth::toUser(JWTAuth::parseToken())) {
                DB::table('role_has_permissions')->where('role_id', $request['id'])->delete();
                $role = DB::table('roles')->where('id', $request['id'])->delete();
                if ($role) {
                    return response()->json(['result' => 'Successfully Removed Role with Permissions'], 200);
                } else {
                    return response()->json(['error' => 'User not Found'], 404);
                }
//            } else {
//                return response()->json(['error' => 'Failed Remove Role'], 404);
//            }
        } catch (JWTException $e) {
            return response()->json(['error'=>'Failed Remove Role'], 500);
        }
    }

    public function getRoles(Request $request) {
        try {

//            $user = JWTAuth::toUser(JWTAuth::parseToken());
            $page = $request->filled('pageNo') ? $request->get('pageNo') : 1;
            $limit = $request->filled('numPerPage') ? $request->get('numPerPage') : 10;
            $totalCount = Role::count();
            $roles = Role::orderBy('updated_at', 'desc')->skip(($page-1)*$limit)->take($limit)->get();

            if ($roles != null) {
                $roledatas = [];
                foreach ($roles as $role) {
                    $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                        ->where("role_has_permissions.role_id",$role->id)
                        ->get();
                    $role->permissions = $rolePermissions;
                    $roledatas[] = $role;
                }
                return response()->json(['totalCount'=>$totalCount, 'data'=> $roledatas], 200);
            } else {
                return response()->json(['error'=>'No Role is created!'], 500);
            }

        } catch (JWTException $e) {
            return response()->json(['error'=>'User is not loggedIn!'], 500);
        }
    }
}
