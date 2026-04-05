<?php
namespace App\Modules\Crm\schedule_plan\components\parse_schedule\plugins\abstracts;


use App\Src\modules\plugins\AbstractPlugin;

abstract class AbstractScheduleParsePlugin extends AbstractPlugin
{
    abstract public function parseFileData(array $data): array;

    protected function fioFormater($fio):string
    {
        return preg_replace(
            '/\s+/', ' ',
            preg_replace('/[^\p{L}\p{N}\s]+/u', '', trim(str_replace(['-'], '' ,str_replace([',', '.'], ' ', $fio)))
            )
        );
    }
}
