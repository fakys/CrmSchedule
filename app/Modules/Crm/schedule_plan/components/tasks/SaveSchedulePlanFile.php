<?php

namespace App\Modules\Crm\schedule_plan\components\tasks;

use App\Modules\Crm\schedule_plan\components\parse_schedule\ParseScheduleManager;
use App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData;
use App\Modules\Crm\schedule_plan\src\SchedulePlanEntity;
use App\Src\BackendHelper;
use App\Src\modules\task\AbstractTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SaveSchedulePlanFile extends AbstractTask
{
    public function getName(): string
    {
        return 'save_schedule_plan_file';
    }

    public function Execute($args = []): bool
    {
        $user = BackendHelper::getRepositories()->getUserByUsername($args['userName']);

        $schedule_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(
            $user->id
        );

        try {
            DB::beginTransaction();
            try {
                foreach ($schedule_data->getScheduleData() as $card_data) {
                    BackendHelper::getOperations()->saveSchedulePlan(BackendHelper::getOperations()->convertDataToCardEntity($card_data));
                }
            } catch (\Throwable $throwable) {
                DB::rollBack();
                throw $throwable;
            }

            DB::commit();
            BackendHelper::getOperations()->deleteSchedulePlanCashByUserId($user->id);
        } catch (\Throwable $throwable) {
            Log::error('[SaveSchedulePlanFile] ' . $throwable->getMessage() . $throwable->getTraceAsString());
            $schedule_data = BackendHelper::getOperations()->getSchedulePlanCashByUserId(
                $user->id
            );

            if ($schedule_data) {
                $schedule_data->setErrorMessage('Ошибка сохранения расписания, обратитесь в тех поддержку!');
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
