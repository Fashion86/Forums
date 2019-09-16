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

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=> 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        return Response::json(['success'=>true, 'user'=>$user, 'token'=>$token]);
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid email or password!'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Couldn\'t create token'], 500);
        }
        if (Auth::validate($credentials))
        {
            $user = Auth::getUser();
        }

        if ($user->is_activated != 1) {
            return response()->json(['error'=>'Your Account is Deactivated, Contact Admin'], 401);
        }

//        $roles = array();
//        foreach ($user->role as $role){
//            $roles[] = $role->name;
//        }
//        $user->roleNames = $roles;
//        $token = JWTAuth::fromUser($user);
        return response()->json(['success'=>true, 'token'=>$token, 'user'=>$user]);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }



    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
