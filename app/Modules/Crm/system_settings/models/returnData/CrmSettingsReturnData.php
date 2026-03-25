<?php
namespace App\Modules\Crm\system_settings\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class CrmSettingsReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('system_users')]
    private $system_users;

    #[ReturnDataFieldAttribute('system_user_groups')]
    private $system_user_groups;

    public function getSystemUsers(): ?array
    {
        return $this->system_users;
    }

    public function getSystemUserGroups(): ?array
    {
        return $this->system_user_groups;
    }

    public function toArray(): array
    {
        return [
            'system_user_groups' => $this->system_user_groups,
            'system_users' => $this->system_users,
        ];
    }
}
