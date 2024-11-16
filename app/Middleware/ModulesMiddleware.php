<?php

namespace App\Middleware;

use App\Src\BackendHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $module = context()->GetModule()->getNameModule();
        if(BackendHelper::getOperations()->checkStatusModule($module)){
            return $next($request);
        }
        abort(404);
    }
}
