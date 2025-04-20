<?php
namespace App\Src\crons\interfaces;

interface TaskInterface{
    /**
     * Тело таска
     * @return bool
     */
    public function Execute($args = []): bool;

    /**
     * Интервал его повторений
     * @return \DateTime[]|\DateTime
     */
    public static function RepeatInterval();

    /**
     * Временная зона для интервала повторений
     * @return string
     */
    public static function TimeZone():string;

    /**
     * Имя таска
     * @return string
     */
    public static function taskName():string;
}
