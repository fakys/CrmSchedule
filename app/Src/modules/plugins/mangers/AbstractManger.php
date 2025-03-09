<?php
namespace App\Src\modules\plugins\mangers;

use App\Src\modules\plugins\AbstractPlugin;

abstract class AbstractManger{

    /**
     * Название менеджера
     * @return string
     */
    abstract public static function mangerName();

    /**
     * Цепочка плагинов
     * @return AbstractPlugin[]
     */
    abstract public function plugins();

    /** Запускает цепочку */
    public function Execute()
    {
        $context = new PluginsMangerContext($this->plugins());
        $context->start();
    }

    /**
     * @param string $name имя плагина
     * @return AbstractPlugin
     */
    public function getPlugin($name)
    {
        foreach($this->plugins() as $plugin){
            if ($plugin->pluginName() == $name) {
                $context = new PluginsMangerContext([$plugin]);
                return $context->start();
            }
        }
    }
}
