<?php
namespace App\Src\modules\controllers\loaders;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;

class NavbarLinkLoader extends AbstractLinkLoader{
    private $text;
    private $name;
    private $access;
    private $link;

    private $active;

    private $rm_link_name;

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

    public function getLink() {
        return $this->link;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function setLink($link) {
        $this->link = $link;
        return $this;
    }

    /** Имя ссылки из сайдбара, нужно для навигации */
    public function setRmLinkName($rm_link_name)
    {
        $this->rm_link_name = $rm_link_name;
    }

    public function getRmLinkName()
    {
        return $this->rm_link_name;
    }
}
