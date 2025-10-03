<?php
namespace App\Src\modules\controllers\loaders;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;

class RmGroupListLoader extends AbstractLinkLoader{
    private $text;
    private $icon;

    private $access;

    private $name;

    /**
     * @var RmLinkLoader[]
     */
    private $links;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function getAccess() {
        return $this->access;
    }

    public function setAccess($access)
    {
        $this->access = $access;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function RmLink($name)
    {
        if (isset($this->links[$name])) {
            return $this->links[$name];
        }
        $this->links[$name] = new RmLinkLoader($name);
        return $this->links[$name];
    }
}
