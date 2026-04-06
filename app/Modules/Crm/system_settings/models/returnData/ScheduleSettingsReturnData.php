<?php
namespace App\Modules\Crm\system_settings\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class ScheduleSettingsReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('default_format')]
    private $default_format;
    #[ReturnDataFieldAttribute('users_groups')]
    private $users_groups;

    #[ReturnDataFieldAttribute('type_weeks')]
    private $type_weeks;

    public function getTypeWeeks()
    {
        return $this->type_weeks;
    }

    public function getUsersGroups()
    {
        return $this->users_groups;
    }

    public function getDefaultFormat()
    {
        return $this->default_format;
    }

    public function toArray(): array
    {
        return [
            'users_groups' => $this->users_groups,
            'type_weeks' => $this->type_weeks,
            'default_format' => $this->default_format,
        ];
    }
}
