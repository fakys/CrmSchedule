<?php

namespace App\Middleware;

use App\Src\BackendHelper;
use App\Src\modules\kernel\entity\ModuleEntity;
use App\Src\modules\kernel\KernelModules;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->setUserInContext();
        $module = BackendHelper::getKernel()->getContext()->GetModule()->getNameModule();
        if (isset(app(KernelModules::MODULE_KEY)[$module])) {
            /** @var ModuleEntity $entity */
            $entity = app(KernelModules::MODULE_KEY)[$module];
            if($entity->getStatus()){
                return $next($request);
            }
        }

        abort(404);
    }

    private function setUserInContext()
    {
        if(Auth::user()){
            BackendHelper::getKernel()->getContext()->setUser(Auth::user());
        }
    }
}
