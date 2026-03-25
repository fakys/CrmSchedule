<?php
namespace App\Src\modules\controllers\loaders;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;

class NavbarLoader extends AbstractLinkLoader
{
    private $name;
    private $links;

    private $active;

    public function __construct($name) {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }

    public function NavbarLink($name)
    {
        if (isset($this->links[$name])) {
            return $this->links[$name];
        }
        $this->links[$name] = new NavbarLinkLoader($name);
        return $this->links[$name];
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return NavbarLinkLoader[]
     */
    public function getLinks()
    {
        return $this->links;
    }
}
