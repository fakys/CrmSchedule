<?php
namespace App\Src\abstract;

use App\Providers\ScheduleProvider;
use App\Src\access\models\AccessModel;
use App\Src\BackendHelper;
use App\Src\helpers\StrHelper;
use App\Src\modules\InfoModuleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

abstract class AbstractContext{
    protected static $context;

    protected $context_user;

    /**
     * @var AccessModel[]
     */
    protected $accesses=[];

    /**
     * @var $request Request
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    protected static function createContext($request)
    {
        if(!self::$context){
            self::$context = new (get_called_class())($request);;
        }
        return self::$context;
    }

    /**
     * @return \App\Src\modules\interfaces\InterfaceInfoModule
     */
    protected function GetContextModule()
    {
        $name_module = StrHelper::parse_uri($this->request->getRequestUri());
        if($name_module){
            return InfoModuleModel::objects()->getContextModule($name_module);
        }else{
            throw new Exception("Модуль не найден. Вероятнее всего url был создан неверно, пример верного url 'module_name/url'", 404);
        }
    }

    protected function StartScheduleProvider()
    {
        $module = $this->GetContextModule();
        $request = $this->request;
        (new ScheduleProvider($request, $module))->register();
    }

    protected function setAccessContext($access)
    {
        if($access){
            $this->accesses[] = $access;
        }
    }

    protected function getAccessesContext()
    {
        return $this->accesses;
    }
}
