<?php
namespace App\Src\access\abstract;

use App\Src\access\models\AccessModel;
use App\Src\BackendHelper;
use App\Src\helpers\StrHelper;
use function Symfony\Component\Translation\t;

abstract class AbstractAccessRoute
{
    /**
     * @var AccessModel
     */
    protected $access;

    public function __construct()
    {
        $this->access = new AccessModel();
    }

    protected static function objects()
    {
        return new (get_called_class())();
    }

    /**
     * Сохраняет доступы в контекст
     * @return void
     */
    protected function setAccessInContext()
    {
        if (
            $this->access && $this->access->getAccess()
        ) {
            context()->setAccess($this->access);
        }
    }

    /**
     * Сохраняет название доступа
     * @param string $access
     * @return $this
     */
    protected function setAccess(string $access)
    {
        $this->access->setAccess($access);
        return $this;
    }

    /**
     * Сохраняет роут
     * @return $this
     */
    protected function setRoute($route)
    {
        $this->access->setRoute($route);
        return $this;
    }

    /**
     * Ссылка куда надо редиректать когда нет нужного доступа
     * @param string $route
     * @return $this
     */
    protected function setRedirect(string $route)
    {
        $this->access->setRedirectRoute($route);
        return $this;
    }

    /**
     * Получение доступа
     * @return AccessModel
     */
    public function getAccess()
    {
        return $this->access;
    }

    public function __destruct()
    {
        $this->setAccessInContext();
    }
}
