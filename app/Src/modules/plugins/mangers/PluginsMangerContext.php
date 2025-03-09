<?php
namespace App\Src\modules\plugins\mangers;

use App\Src\modules\plugins\AbstractPlugin;
use App\Src\modules\plugins\exceptions\BackendException;

class PluginsMangerContext{
    private $property;
    private $plugins;

    private $result;

    /**
     * @param AbstractPlugin[] $plugins
     */
    public function __construct($plugins)
    {
        $this->init($plugins);
    }

    public function init($plugins)
    {
        foreach ($plugins as $plugin) {
            $this->plugins[] = new $plugin($this);
        }
    }

    public function __get($property)
    {
        if (isset($this->property[$property])) {
            return $this->property[$property];
        }
    }


    public function __set($property, $value){
        $this->property[$property] = $value;
    }

    public function __call($method, $arguments)
    {
        foreach ($this->plugins as $plugin) {
            if (method_exists($plugin, $method)) {
                return call_user_func_array([$plugin, $method], $arguments);
            }
        }
        throw new BackendException("Call to undefined method $method");
    }

    public function start()
    {
        try {
            foreach ($this->plugins as $plugin) {
                $plugin->Execute();
            }
        } catch (\Exception $e) {
            throw new BackendException("Ошибка в плагине: " . $e->getMessage()." ".$e->getTraceAsString());
        }
    }

    public function setPluginResult($result)
    {
        $this->result = $result;
    }

    public function getPluginResult()
    {
        return $this->result;
    }
}
