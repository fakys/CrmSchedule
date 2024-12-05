<?php
namespace App\Modules\Crm\users_interface\repositories;

use App\Entity\UserGroup;
use App\Src\modules\repository\Repository;

class UserGroupsRepositories extends Repository
{
    public function getAllUsersGroup()
    {
        return UserGroup::all();
    }
}
