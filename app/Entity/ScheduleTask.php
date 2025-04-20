<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Таблица для отслеживания очередей тасков
 * @property $id
 * @property $task_name
 * @property $status
 * @property $start_time
 * @property $args
 * @property $end_time
 * @property $pid
 */
class ScheduleTask extends Model
{
    protected $table = 'schedule_task';
    public $timestamps = false;

    const ACTIVE_STATUS = 'active';
    const PENDING_STATUS = 'pending';
    const DONE_STATUS = 'done';

    protected $fillable = [
            'task_name',
            'status',
            'start_time',
            'end_time',
            'args',
            'pid'
    ];
}
