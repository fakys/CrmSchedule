<?php

namespace App\Src\crons;

use App\Src\BackendHelper;
use App\Src\modules\kernel\constructs\ConstructComponents;
use App\Src\rabbit\RabbitMQ;
use App\Src\traits\TraitObjects;
use Cron\CronExpression;

class CronSchedule
{
    use TraitObjects;

    const QUEUE = 'cron_schedule_queue';
    const ACTIVE_STATUS = 'active';
    const PENDING_STATUS = 'pending';
    const DONE_STATUS = 'done';
    private $rabbit;

    public function __construct()
    {
        $this->rabbit = new RabbitMQ(self::QUEUE);
    }

    public static function startCronSchedule()
    {
        $crons = BackendHelper::getKernel()->getComponentsByType(ConstructComponents::CRON_TYPE);

        foreach ($crons as $cron) {
            $last_cron = BackendHelper::getRepositories()->getLastCronByName($cron->cronName());
            if ($last_cron) {
                $last_time = new \DateTime($last_cron->start_time);
                $cron_time = CronExpression::factory($cron->timeStart());
                $next_run_cron = $cron_time->getNextRunDate($last_time);

                if ($next_run_cron <= new \DateTime()) {

                    continue;
                }
                continue;
            }


        }
    }

    private function createCron($cron_name)
    {
        $cron_data = [
            'task_name' => $cron_name,
            'status' => self::ACTIVE_STATUS,
            'time_create' => date('Y-m-d H:i:s'),
            'time_end' => null,
            'pid' => null
        ];

        $cron = BackendHelper::getRepositories()->addTaskSchedule($cron_data);

        $task_data['id'] = $cron->id;
        /** Заполняем очередь */
        $this->schedulePush($task_data);
    }


    /**
     * @param $task
     * @return void
     * @throws \RedisException
     */
    private function schedulePush($cron)
    {
        $this->rabbit->appendQueue($cron);
    }
}
