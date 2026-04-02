<?php
namespace App\Modules\Crm\schedule_plan\components\parse_schedule\plugins\abstracts;


use App\Src\modules\plugins\AbstractPlugin;

abstract class AbstractScheduleParsePlugin extends AbstractPlugin
{
    abstract public function parseFileData(array $data): array;
}
