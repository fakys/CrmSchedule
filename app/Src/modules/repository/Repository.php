<?php
namespace App\Src\modules\repository;

use App\Src\BackendHelper;
use App\Src\traits\TraitObjects;

class Repository
{
    use TraitObjects;
    public function getFullRepositories()
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
