<?php
namespace App\Src\access;

use App\Entity\User;
use App\Modules\Crm\system_settings\models\SystemSetting;
use App\Src\access\abstract\AbstractAccessRoute;
use App\Src\BackendHelper;
use App\Src\helpers\StrHelper;
use App\Src\traits\TraitObjects;

class ContextAccessRoute extends AbstractAccessRoute
{
    use TraitObjects;

    protected $accesses;

    public function __construct()
    {
        $this->accesses = context()->getAccesses();
    }
    public function getAccessByNameRoute($name)
    {
        foreach ($this->accesses as $access) {
            if ($access->getRoute() && $access->getRoute()->getName() === $name) {
                return $access;
            }
        }
        return null;
    }

    public static function getByUriAccess($uri)
    {
        $uri = StrHelper::delete_first_slash($uri);
        $accesses = context()->getAccesses();
        foreach ($accesses as $access) {
            if($access->getRoute() && $access->getRoute()->uri() == $uri) {
                return $access;
            }
        }
        return false;
    }

    public function checkUserByAccess($access, $user_id)
    {
        $user = BackendHelper::getRepositories()->getUserById($user_id);
        $user_accesses = BackendHelper::getOperations()->getFullAccessByUserId($user->id);
        if($this->checkSystemUser($user)){
            return true;
        }
        if($user && in_array($access, $user_accesses)) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    protected function checkSystemUser($user)
    {
        $settings = BackendHelper::getSystemSettings(SystemSetting::getSettingName());
        if($settings->system_users){
            if (in_array($user->id, $settings->system_users)) {
                return true;
            }
        }
        foreach ($user->getGroupsUser() as $group) {
            if($settings->system_user_groups){
                if(in_array($group->group_id, $settings->system_user_groups)){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Проверяет есть ли у пользователя доступ по названию роута
     * @param $name
     * @return bool
     */
    public function checkAccessByNameRoute($name)
    {
        $user = context()->getUser();
        if($this->checkSystemUser($user)){
            return true;
        }
        $this->checkSystemUser($user);
        $access = $this->getAccessByNameRoute($name);
        $user_accesses = BackendHelper::getOperations()->getFullAccessByUserId($user->id);
        if($user && $access && $user_accesses){
            return in_array($access->getAccess(), $user_accesses);
        }
        return false;
    }
}
