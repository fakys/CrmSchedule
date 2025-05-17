<?php

namespace App\Src\modules\crons_schedule;

use App\Src\modules\components\AbstractComponents;

abstract class AbstractCronSchedule extends AbstractComponents
{
    /**
     * Тело таска
     * @return bool
     */
    abstract public function Execute($args = []): bool;

    /**
     * Временная зона для интервала повторений
     * @return string
     */
    abstract public static function TimeZone():string;

    /**
     * Имя таска
     * @return string
     */
    abstract public static function cronName():string;

    /**
     * Время запуска крона
     * @return string
     */
    abstract public function timeStart():string;
}
