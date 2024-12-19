<?php
namespace App\Src;

use App\Src\abstract\AbstractContext;
use App\Src\access\models\AccessModel;
use http\Env\Request;

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
}
