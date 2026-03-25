<?php
namespace App\Src\modules\controllers;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;
use App\Src\modules\controllers\loaders\NavbarLinkLoader;
use App\Src\modules\controllers\loaders\NavbarLoader;
use App\Src\modules\controllers\loaders\RmGroupLoader;

class ControllerLoader extends AbstractLinkLoader{
    /**
     * @var RmGroupLoader[]
     */
    private $rm_groups;

    /**
     * @var NavbarLoader[]
     */
    private $navbars;


    private $navigation = [];

    public function RmGroup($name)
    {
        if (isset($this->rm_groups[$name])) {
            return $this->rm_groups[$name];
        }
        $this->rm_groups[$name] = new RmGroupLoader($name);
        return $this->rm_groups[$name];
    }

    public function Navbar($name)
    {
        if (isset($this->navbars[$name])) {
            return $this->navbars[$name];
        }
        $this->navbars[$name] = new NavbarLoader($name);

        return $this->navbars[$name];
    }

    /**
     * Получает позицию пользователя
     * @return void
     */
    private function checkPositionUser()
    {
        $sort_arr = [];

        foreach ($this->navbars as $navbar) {
            foreach ($navbar->getLinks() as $link) {
                if ($link->getLink() === request()->url()) {
                    $navbar->setActive(true);
                    $link->setActive(true);
                }
            }
        }
        $link_in_navbar = false;
        foreach ($this->rm_groups as $name => $group) {
            foreach ($group->getAllGroupList() as $group_list) {
                foreach ($group_list->getAllLinks() as $link_name => $link) {
                    foreach ($this->navbars as $navbar) {
                        foreach ($navbar->getLinks() as $link_navbar) {
                            if ($link_navbar->getActive() && $link_navbar->getRmLinkName() == $link_name) {
                                $link_in_navbar = true;
                                $group->setOpen(true);
                                $group_list->setOpen(true);
                                $this->navigation[] = $group->getText();
                                $this->navigation[] = $group_list->getText();
                                $this->navigation[$link->getLink()] = $link->getText();
                                if ($link_navbar->getLink() != $link->getLink()) {
                                    $this->navigation[] = $link_navbar->getText();
                                }
                            }
                        }
                    }

                    if (!$link_in_navbar) {
                        if ($link->getLink() === request()->url()) {
                            $group->setOpen(true);
                            $group_list->setOpen(true);
                            $this->navigation[] = $group->getText();
                            $this->navigation[] = $group_list->getText();
                            $this->navigation[] = $link->getText();
                        }
                    }
                }
            }
            foreach ($group->getAllLinks() as $link_name => $link) {
                foreach ($this->navbars as $navbar) {
                    foreach ($navbar->getLinks() as $link_navbar) {
                        if ($link_navbar->getActive() && $link_navbar->getRmLinkName() == $link_name) {
                            $link_in_navbar = true;
                            $group->setOpen(true);
                            $this->navigation[] = $group->getText();

                            if ($link_navbar->getLink() != $link->getLink()) {
                                $this->navigation[$link->getLink()] = $link->getText();
                                $this->navigation[] = $link_navbar->getText();
                            } else {
                                $this->navigation[] = $link->getText();
                            }
                        }
                    }
                }

                if (!$link_in_navbar && $link->getLink() === request()->url()) {
                    $group->setOpen(true);
                    $this->navigation[] = $group->getText();
                    $this->navigation[] = $link->getText();
                }
            }
        }

        $group_null_position = [];
        foreach ($this->rm_groups as $name => $group) {
            if ($group->getPosition() >= 0) {
                $sort_arr[$group->getPosition()] = $group;
            } else {
                $group_null_position[] = $group;
            }
        }
        $this->rm_groups = array_merge($sort_arr, $group_null_position);
    }

    public function AllRmGroups()
    {
        if (!$this->navigation) {
            $this->checkPositionUser();
        }

        return $this->rm_groups;
    }

    public function getNavigation()
    {
        if (!$this->navigation) {
            $this->checkPositionUser();
        }

        return $this->navigation;
    }

    /**
     * @return NavbarLoader[]
     */
    public function getNavbars()
    {
        if (!$this->navigation) {
            $this->checkPositionUser();
        }

        return $this->navbars;
    }
}
