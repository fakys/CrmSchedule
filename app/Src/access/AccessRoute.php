<?php
namespace App\Src\access;

use App\Src\access\abstract\AbstractAccessRoute;

class AccessRoute extends AbstractAccessRoute
{

    /**
     * @param string $access_name
     * @return $this
     */
    public static function access(string $access_name)
    {
        return self::objects()->setAccess($access_name);
    }

    public function route($route)
    {
        $this->setRoute($route);
        return $this;
    }

    public function redirect(string $route)
    {
        $this->setAccess($route);
        return $this;
    }
}
