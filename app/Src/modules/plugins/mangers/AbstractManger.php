<?php
namespace App\Src\modules\plugins\mangers;

use App\Src\modules\plugins\AbstractPlugin;

abstract class AbstractManger{

    /**
     * @var PluginsMangerContext $context
     */
    private $context;

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
        $this->context = new PluginsMangerContext($this->plugins());
        $this->context->start();
        return $this;
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
                $context->start();
            }
        }
    }

    public function getResult()
    {
        return $this->context->getPluginResult();
    }
}
