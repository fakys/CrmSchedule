<?php

namespace App\Src\modules\operations;

use App\Src\modules\components\AbstractTagComponents;
use function Symfony\Component\Translation\t;

abstract class AbstractOperation extends AbstractTagComponents
{
    const BEFORE_TYPE = 'before';
    const AFTER_TYPE = 'after';
    const PARENT_TYPE = 'parent';

    public function positionIndex()
    {
        return 0;
    }

    public function positionType()
    {
        return self::PARENT_TYPE;
    }

    /**
     * @return mixed|void
     */
    public function getNext()
    {
        $next_component = $this->kernel->getComponentsByTag($this->getTag());
        if (!$next_component) { //Если компоненты по тегу отсутствуют, возможно это родительская операция и надо искать по имени
            $next_component = $this->kernel->getComponentsByTag($this->getName());
        }
        $next = false;

        if (array_key_last($next_component[$this->positionType()]) == $this->positionIndex()) {
            switch ($this->positionType()) {
                case self::BEFORE_TYPE:
                    $next = self::PARENT_TYPE;
                    break;
                case self::PARENT_TYPE:
                    $next = self::AFTER_TYPE;
                    break;
            }
        }

        if ($next) {
            $components_arr = $next_component[$next]??[];
            $next_component_key = array_key_first($components_arr);
        } else {
            $components_arr = $next_component[$this->positionType()];

            while (key($components_arr) !== $this->positionIndex() && key($components_arr) !== null) {
                next($components_arr);
            }
            next($components_arr);
            $next_component_key = key($components_arr);
        }

        if (isset($components_arr[$next_component_key])) {
            return $components_arr[$next_component_key];
        }
    }
}
