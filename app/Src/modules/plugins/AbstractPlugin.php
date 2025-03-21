<?php

namespace App\Src\modules\plugins;

use App\Src\modules\plugins\mangers\PluginsMangerContext;

abstract class AbstractPlugin
{
    /** @var PluginsMangerContext $plugin_context */
    protected $context;
    public function __construct($plugin_context)
    {
        $this->context = $plugin_context;
    }
    /**
     * Название плагина
     * @return string
     */
    abstract public function pluginName();

    /** Метод для выполнения плагина */
    abstract public function Execute();


    public function __get($property)
    {
        return $this->context->$property;
    }


    public function __set($property, $value){
        $this->context->$property = $value;
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->context, $method], $arguments);
    }

    /** Метод для пополнения массивов из контекста */
    public function appendArrProperty($property, $append, $key= null)
    {
        $this->context->appendArr($property, $append, $key);
    }

    /** Сохраняет результат цепочки */
    protected function setResult($data)
    {
        $this->context->setPluginResult($data);
    }

    /** Возвращает результат цепочки */
    public function getResult()
    {
        return $this->context->getPluginResult();
    }
}
