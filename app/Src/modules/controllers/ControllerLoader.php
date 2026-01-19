<?php
namespace App\Src\modules\controllers;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;
use App\Src\modules\controllers\loaders\RmGroupLoader;

class ControllerLoader extends AbstractLinkLoader{
    /**
     * @var RmGroupLoader[]
     */
    private $rm_groups;

    public function RmGroup($name)
    {
        if (isset($this->rm_groups[$name])) {
            return $this->rm_groups[$name];
        }
        $this->rm_groups[$name] = new RmGroupLoader($name);
        return $this->rm_groups[$name];
    }

    private function checkActualRmGroup()
    {
        foreach ($this->rm_groups as $name => $group) {
            foreach ($group->getAllGroupList() as $group_list) {
                foreach ($group_list->getAllLinks() as $link) {
                    if ($link->getLink() === request()->url()) {
                        $group->setOpen(true);
                        $group_list->setOpen(true);
                    }
                }
            }
            foreach ($group->getAllLinks() as $link) {
                if ($link->getLink() === request()->url()) {
                    $group->setOpen(true);
                }
            }
        }
    }

    public function AllRmGroups()
    {
        $this->checkActualRmGroup();
        return $this->rm_groups;
    }
}
