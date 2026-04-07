<?php

namespace App\Modules\Crm\schedule_plan\components\tasks;

use App\Modules\Crm\schedule_plan\components\parse_schedule\ParseScheduleManager;
use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;
use App\Modules\Crm\schedule_plan\src\SchedulePlanEntity;
use App\Src\BackendHelper;
use App\Src\modules\task\AbstractTask;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ParseSchedulePlanFile extends AbstractTask
{

    const FILE_NAME = 'parse_schedule_plan.xlsx';

    public function getName(): string
    {
        return 'parse_schedule_plan_file';
    }

    public function Execute($args = []): bool
    {
        $plan_type = $args['plan_type'];
        $groups = $args['groups'];
        $semester = $args['semester'];
        $file_path = $args['file_path'];
        $user = BackendHelper::getRepositories()->getUserByUsername($args['userName']);

        try {
            $spreadsheet = IOFactory::load(Storage::path($file_path));
            $schedule_data_file = $spreadsheet->getActiveSheet()->toArray(null, true, false, false);

            /** @var ParseScheduleManager $manager */
            $manager = BackendHelper::getManager(ParseScheduleManager::ManagerName);
            $data = $manager->parseFileDataByPlugin($schedule_data_file);
            $schedule_data = BackendHelper::getOperations()->cardEntityConvertToArray($data, $plan_type, $groups);
            $group = BackendHelper::getRepositories()->getStudentGroupById($groups);
            BackendHelper::getOperations()->setSchedulePlanCashForUser(
                new SchedulePlanReturnData($semester, $groups, $group->specialty_id, $plan_type, $schedule_data),
                $user->id
            );

        } catch (\Throwable $throwable) {
            Log::error('[ParseSchedulePlanFile] ' . $throwable->getMessage() . $throwable->getTraceAsString());
            $schedule_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(
                $user->id
            );

            if ($schedule_data) {
                $schedule_data->setErrorMessage('Ошибка загрузки файла, обратитесь в тех поддержку!');
                BackendHelper::getOperations()->setSchedulePlanCashForUser($schedule_data, $user->id);
            }
        }
        return true;
    }

    public static function RepeatInterval()
    {
        // TODO: Implement RepeatInterval() method.
    }
}
