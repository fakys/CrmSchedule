<?php
namespace App\Modules\Crm\system_settings\components\settings;

use App\Src\modules\settings\AbstractSettingsComponent;

/**
 * @property $system_users
 * @property $system_user_groups
 */
class SystemSetting extends AbstractSettingsComponent
{
    const SETTING_NAME = 'system_settings';

    public function getName(): string
    {
        return self::SETTING_NAME;
    }

    public function getDefaultSettings(): array
    {
        return [
            'users_groups' => [],
            'type_weeks' => []
        ];
    }

    public function getSystemUsers(): array
    {
        return $this->system_users;
    }

    public function setSystemUsers(array $system_users)
    {
        $this->system_users = $system_users;
    }

    public function getSystemUserGroups(): array
    {
        return $this->system_user_groups;
    }

    public function setSystemUserGroups(array $system_user_groups)
    {
        $this->system_user_groups = $system_user_groups;
    }
}
