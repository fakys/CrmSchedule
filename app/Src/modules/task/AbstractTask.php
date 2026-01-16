<?php

namespace App\Src\modules\task;

use App\Src\modules\components\AbstractComponents;

abstract class AbstractTask extends AbstractComponents
{
    /**
     * Тело таска
     * @return bool
     */
    abstract public function Execute($args = []): bool;

    /**
     * Интервал его повторений
     * @return \DateTime[]|\DateTime
     */
    abstract public static function RepeatInterval();

    /**
     * Временная зона для интервала повторений
     * @return string
     */
    abstract public static function TimeZone():string;

    /**
     * Имя таска
     * @return string
     */
    abstract public static function taskName():string;
}
