<?php
namespace App\Src\modules\controllers\loaders;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;

class RmLinkLoader extends AbstractLinkLoader{
    private $text;
    private $name;
    private $icon;
    private $access;
    private $link;

    public function __construct($name) {
        $this->name = $name;
    }

    public function setAccess($access)
    {
        $this->access = $access;
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function getName($name)
    {
        return $this->name;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
        return $this;
    }
}
