<?php

namespace App\Modules\Crm\schedule\src\returnData;

use App\Modules\Crm\schedule\src\entity\CorrectionCardEntity;

class CorrectionScheduleGroupReturnData
{
    private int $groupId;

    private string $groupName;

    /**
     * @var CorrectionCardEntity[]
     */
    private array $cardData;

    public function __construct(int $groupId, string $groupName, array $cardData)
    {
        $this->groupId = $groupId;
        $this->groupName = $groupName;
        $this->cardData = $cardData;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function getCardData(): array
    {
        return $this->cardData;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }
}
