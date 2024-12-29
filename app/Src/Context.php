<?php
namespace App\Src;

use App\Entity\User;
use App\Src\abstract\AbstractContext;
use App\Src\access\models\AccessModel;

class Context extends AbstractContext
{
    public static function GetContext($request)
    {
        return self::createContext($request);
    }

    public function GetModule()
    {
        return self::GetContextModule();
    }

    public function StartProvider()
    {
        self::StartScheduleProvider();
    }

    /**
     * Сохраняет доступы
     * @param AccessModel $access
     * @return void
     */
    public function setAccess($access)
    {
        $this->setAccessContext($access);
    }

    /**
     * Возвращает все доступы
     * @return AccessModel[]
     */
    public function getAccesses()
    {
        return $this->getAccessesContext();
    }

    public function setUser(User $user)
    {
        $this->context_user = $user;
    }

    /**
     * Вернет текущего пользователя
     * @return User
     */
    public function getUser()
    {
        return $this->context_user;
    }
}
