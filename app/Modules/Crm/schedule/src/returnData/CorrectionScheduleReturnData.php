<?php
namespace App\Modules\Crm\schedule\src\returnData;

class CorrectionScheduleReturnData
{
    /** @var CorrectionScheduleGroupReturnData[] */
    private array $groupData;

    public function __construct(array $groupData)
    {
        $this->groupData = $groupData;
    }

    public function getGroupData(): array
    {
        return $this->groupData;
    }
}
