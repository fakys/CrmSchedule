<?php
namespace App\Src\modules\settings;

use Mockery\Exception;

class Settings{

    protected $settings;

    protected $params = [];

    public function __construct($settings)
    {
        $this->settings = $settings;
        $this->setParams($settings);
    }

    protected function setParams($settings)
    {
        if($settings && $settings->settings){
            foreach (json_decode($settings->settings, 1) as $key => $value) {
                $this->params[$key] = $value;
            }
        }
    }

    public function getSettings()
    {
        return $this->params;
    }

    public function __get($name)
    {
        if (isset($this->params[$name])){
            return $this->params[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function setSettings()
    {
        $settings = json_encode($this->params);
        $this->settings->settings = $settings;
        return $this->settings->save();
    }

    public function getName()
    {
        return $this->settings->name;
    }
}
