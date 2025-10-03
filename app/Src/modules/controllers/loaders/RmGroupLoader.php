<?php
namespace App\Src\modules\controllers\loaders;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;

class RmGroupLoader extends AbstractLinkLoader {

    private $name;
    private $text;
    private $icon;
    private $open;
    private $access;

    private $start_open;

    /**
     * @var RmGroupListLoader[]
     */
    private $rm_group_list;

    /**
     * @var RmLinkLoader[]
     */
    private $links = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function getOpen()
    {
        return $this->open;
    }

    public function setOpen($open)
    {
        $this->open = $open;
        return $this;
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function setAccess($access)
    {
        $this->access = $access;
        return $this;
    }

    public function startOpen($open)
    {
        $this->start_open = $open;
        return $this;
    }

    public function getStartOpen()
    {
        return $this->start_open;
    }

    /**
     * @param $rm_group_name
     * @param $name
     * @return RmGroupListLoader
     */
    public function RmGroupList($name)
    {
        if (isset($this->rm_group_list[$name])) {
            return $this->rm_group_list[$name];
        }
        $this->rm_group_list[$name] = new RmGroupListLoader($name);
        return $this->rm_group_list[$name];
    }

    public function RmLink($name)
    {
        if (isset($this->links[$name])) {
            return $this->links[$name];
        }
        $this->links[$name] = new RmLinkLoader($name);
        return $this->links[$name];
    }

    public function getAllGroupList()
    {
        return $this->rm_group_list;
    }

    public function getAllLinks()
    {
        return $this->links;
    }
}
