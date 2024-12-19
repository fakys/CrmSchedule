<?php
namespace App\Modules\Crm\users_interface\operations;

use App\Src\BackendHelper;
use App\Src\modules\operations\Operation;
class UserAccessOperation extends Operation {

    public function getAccessForForm()
    {
        $accesses = context()->getAccesses();
        $new_accesses = [];
        foreach ($accesses as $access) {
            $new_accesses[$access->getAccess()] = $access->getAccess();
        }
        return $new_accesses;
    }
}
