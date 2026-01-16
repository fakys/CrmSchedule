<?php
namespace App\Src\modules\plugins\mangers;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\plugins\AbstractPlugin;

abstract class AbstractManger extends AbstractComponents {

    public function __construct($kernel)
    {
        parent::__construct($kernel);
        $this->context = new PluginsMangerContext($this->plugins());
    }

    /**
     * @var PluginsMangerContext $context
     */
    protected $context;

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

    /**
     * Сохраняет атрибуты в контексте
     * @param array $data
     * @return void
     */
    public function setAttr($data)
    {
        $this->context->setAttrsInContext($data);
    }
}
