<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class JwtAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $role = Auth::guard()->user()->role;
            if($role !== 'admin') {
                
                Auth::guard()->logout();
                
                throw new AccessDeniedHttpException('Incorrect username or password provided.');
            }
        } catch (Exception $e) {
            throw new AccessDeniedHttpException('Incorrect username or password provided.');
        }
        return $next($request);
    }
}
