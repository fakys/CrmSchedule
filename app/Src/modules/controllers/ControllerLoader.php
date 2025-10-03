<?php
namespace App\Src\modules\controllers;

use App\Src\modules\controllers\loaders\abstracts\AbstractLinkLoader;
use App\Src\modules\controllers\loaders\RmGroupListLoader;
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
}
