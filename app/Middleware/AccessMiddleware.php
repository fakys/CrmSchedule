<?php

namespace App\Middleware;

use App\Src\BackendHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $access = BackendHelper::getAccess($request->getRequestUri());
        if (!$user || !$access || $user->username = 'system_user') {
            return $next($request);
        }
        if(BackendHelper::checkAccess($access->getAccess(), $user->id)){
            return $next($request);
        }
        abort(403);
    }
}
