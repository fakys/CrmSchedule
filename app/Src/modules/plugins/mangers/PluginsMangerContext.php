<?php
namespace App\Src\modules\plugins\mangers;

use App\Src\modules\exceptions\BackendException;
use App\Src\modules\plugins\AbstractPlugin;

class PluginsMangerContext{
    private $property;
    private $plugins;

    private $result;

    private $attrs;

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
        foreach ($this->plugins as $plugin) {
            $plugin->Execute();
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

    public function appendArr($property, $append, $key)
    {
        if (empty($this->property[$property])) {
            $this->property[$property] = [];
        }

        if (!$key) {
            $this->property[$property][] = $append;
        } else {
            $this->property[$property][$key] = $append;
        }
    }

    public function setAttrsInContext($attrs)
    {
        return $this->attrs = $attrs;
    }

    public function setAttr($name, $data)
    {
        $this->attrs[$name] = $data;
    }
    public function getAttr($name)
    {
        if (isset($this->attrs[$name])) {
            return $this->attrs[$name];
        }
    }
}
