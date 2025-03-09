<?php
namespace App\Src\modules\plugins\mangers;


use App\Src\BackendHelper;
use App\Src\modules\exceptions\BackendException;

class MangerHelper{

    /** @var AbstractManger */
    private static $mangers;
    private static function getFullManger()
    {
        $modules = BackendHelper::getFullModule();
        self::$mangers = [];

        foreach ($modules as $module) {
            self::$mangers = array_merge(self::$mangers, $module::mangers());
        }
    }
    public static function getManegeByName($name)
    {
        self::getFullManger();

        foreach (self::$mangers as $manger) {
            /** @var AbstractManger $manager_obj */
            $manager_obj = new $manger();
            if ($manager_obj->mangerName() == $name) {
                return $manager_obj;
            }
        }
        throw new BackendException("Менеджер {$name} не найден");
    }
}
