<?php
namespace App\Modules\Crm\system_settings\components\settings;

use App\Modules\Crm\backend_module\enums\FormatLessonEnum;
use App\Src\modules\settings\AbstractSettingsComponent;

/**
 * @property $users_groups
 * @property $type_weeks
 * @property $default_format
 */
class ScheduleSetting extends AbstractSettingsComponent
{
    const SETTING_NAME = 'schedule_settings';

    const SIX_DAY = 1;
    const FIVE_DAY = 2;

    public function getName(): string
    {
        return self::SETTING_NAME;
    }

    public function getDefaultSettings(): array
    {
        return [
            'type_weeks' => self::SIX_DAY,
            'users_groups' => [],
            'default_format' => FormatLessonEnum::FACE_TO_FACE
        ];
    }

    public function getUsersGroups()
    {
        return $this->users_groups;
    }

    public function getTypeWeeks()
    {
        return $this->type_weeks;
    }

    public function setUsersGroups(array $users_groups)
    {
        $this->users_groups = $users_groups;
    }

    public function setTypeWeeks(array $type_weeks)
    {
        $this->type_weeks = $type_weeks;
    }

    public function getDefaultFormat()
    {
        return (int)$this->default_format;
    }

    public function setDefaultFormat($default_format)
    {
        $this->default_format = $default_format;
    }
}
