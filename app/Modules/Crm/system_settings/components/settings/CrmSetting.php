<?php
namespace App\Modules\Crm\system_settings\components\settings;

use App\Src\modules\settings\AbstractSettingsComponent;

/**
 * @property $system_users
 * @property $system_user_groups
 */
class CrmSetting extends AbstractSettingsComponent
{
    const SETTING_NAME = 'crm_settings';

    public function getName(): string
    {
        return self::SETTING_NAME;
    }

    public function getDefaultSettings(): array
    {
        return [
            'system_users' => [],
            'system_user_groups' => [],
        ];
    }

    public function getSystemUsers()
    {
        return $this->system_users;
    }

    public function getSystemUserGroups()
    {
        return $this->system_user_groups;
    }

    public function setSystemUsers(array $users)
    {
        $this->system_users = $users;
    }

    public function setSystemUserGroups(array $groups)
    {
        $this->system_user_groups = $groups;
    }
}
