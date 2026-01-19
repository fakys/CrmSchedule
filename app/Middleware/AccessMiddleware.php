<?php

namespace App\Middleware;

use App\Src\BackendHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessMiddleware
{
    /**
     * Проверяет доступы пользователей
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed|void
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $access = BackendHelper::getAccess($request->getRequestUri());
        if (!$user || !$access) {
            return $next($request);
        }
        if(BackendHelper::checkAccess($access->getAccess(), $user->id)){
            return $next($request);
        }
        //если у доступа есть ссылка на редирект
        if($access->getRedirectRoute()){
            return redirect()->route($access->getRedirectRoute());
        }
        abort(403);
    }
}
