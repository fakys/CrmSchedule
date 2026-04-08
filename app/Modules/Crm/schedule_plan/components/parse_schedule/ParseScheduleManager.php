<?php
namespace App\Modules\Crm\schedule_plan\components\parse_schedule;

use App\Modules\Crm\schedule_plan\components\parse_schedule\plugins\abstracts\AbstractScheduleParsePlugin;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Src\BackendHelper;
use App\Src\modules\plugins\mangers\AbstractManger;

class ParseScheduleManager extends AbstractManger
{
    const ManagerName = 'parse_schedule_manager';

    public function getName(): string
    {
        return self::ManagerName;
    }

    /**
     * @param array $data
     * @param $semesterId
     * @param $planTypeId
     * @param $pluginName
     * @return CardEntity[]
     */
    public function parseFileDataByPlugin(array $data, $semesterId, $planTypeId, $pluginName = 'BaseScheduleParsePlugin')
    {
        /** @var AbstractScheduleParsePlugin[] $plugins */
        $plugins = $this->getPlugins();

        foreach ($plugins as $plugin) {
            if ($plugin->getName() === $pluginName) {
                $plugin->setSemester(BackendHelper::getRepositories()->getSemesterById($semesterId));
                $plugin->setPlanType(BackendHelper::getRepositories()->getSchedulePlanTypeById($planTypeId));
                $schedule_data = $plugin->parseFileData($data);
                return $schedule_data;
            }
        }

        return [];
    }
}
