<?php
namespace App\Modules\Crm\users_interface\operations;

use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\operations\Operation;
use Mockery\Exception;

class UsersGroupOperations extends Operation
{
    /**
     * Добавляет пользователя в группы
     * @param $userId
     * @param $groups
     * @return true
     */
    public function addUserInGroups($userId, $groups)
    {
        $user_groups = BackendHelper::getRepositories()->getGroupsUserByUserId($userId);
        if($groups){
            foreach ($groups as $group_id) {
                $group_by_id = BackendHelper::getRepositories()->getUsersGroupById($group_id);
                if($group_by_id){
                    if(!BackendHelper::getRepositories()->hasUserInGroup($userId, $group_id)){
                        if(!BackendHelper::getRepositories()->addUserInGroup($userId, $group_id)){
                            throw new Exception("Ошибка при добавление в группу с id = {$group_id}");
                        }
                    }
                }else{
                    throw new Exception("Группа с id = {$group_id} не найдена");
                }
            }
        }else{
            $groups=[];
        }

        foreach ($user_groups as $user_group) {
            if(!in_array($user_group->user_group_id, $groups)){
                $user_group->delete();
            }
        }
        return true;
    }
}
