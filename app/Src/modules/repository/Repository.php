<?php
namespace App\Src\modules\repository;

use App\Src\BackendHelper;

class Repository
{
    public function getFullRepositories():RepositoriesContext
    {
        $modules = BackendHelper::getFullModule();
        $arr_repositories = [];
        foreach ($modules as $module){
            $arr_repositories = array_merge($arr_repositories, $module::repositories());
        }
        return new RepositoriesContext($arr_repositories);
    }

    public function getRepository()
    {

    }
}
