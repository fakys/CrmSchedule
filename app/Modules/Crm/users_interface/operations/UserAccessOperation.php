<?php
namespace App\Modules\Crm\users_interface\operations;

use App\Modules\Crm\users_interface\model\AccessTab;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;
class UserAccessOperation extends AbstractOperation {

    public function getAccessForForm()
    {
        $accesses = context()->getAccesses();
        $new_accesses = [];
        foreach ($accesses as $access) {
            $new_accesses[$access->getAccess()] = $access->getAccess();
        }
        return $new_accesses;
    }

    /**
     * Возвращает все доступы пользователя по id
     * @param $user_id
     * @return array
     */
    public function getFullAccessByUserId($user_id)
    {
        $user_groups = BackendHelper::getRepositories()->getGroupsUserByUserId($user_id);
        $accesses = [];
        if($user_groups){
            foreach ($user_groups as $group_user) {
                $group = BackendHelper::getRepositories()->getActiveUsersGroupById($group_user->user_group_id);
                if($group){
                    $accesses = array_merge($accesses, $group->getAccesses());
                }
            }
        }
        return $accesses;
    }

    /**
     * Проверяет доступы по url
     * @param array $url
     * @return array
     */
    public function hasAccessesByUrl($url)
    {
        $user = context()->getUser();
        $full_access = context()->getAccesses();
        $user_access = BackendHelper::getOperations()->getFullAccessByUserId($user->id);
        $data_access = [];

        foreach ($full_access as $access) {
            if($access->getRoute() && in_array(route($access->getRoute()->getName()), $url)){
                if(in_array($access->getAccess(), $user_access)){
                    $data_access[route($access->getRoute()->getName())] = AccessTab::APPROVED;
                }else{
                    $data_access[route($access->getRoute()->getName())] = AccessTab::REJECTED;
                }

            }
        }
        return $data_access;
    }

    public function getName(): string
    {
        return 'user_access_operation';
    }
}
