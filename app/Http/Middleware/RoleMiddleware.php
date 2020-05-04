<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (! Auth::user()->hasAnyRole($roles)) {
            if(\Request::is('api/*')){
                return response()->json(['code'=>403, 'description'=> 'Unauthorized'], 403);
            }
            throw UnauthorizedException::forRoles($roles);
        }

        return $next($request);
    }
}
