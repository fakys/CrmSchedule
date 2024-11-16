<?php
namespace App\Src;

use App\Src\abstract\AbstractContext;
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
}
