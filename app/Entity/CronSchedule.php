<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Таблица для отслеживания очередей тасков
 * @property $id
 * @property $cron_name
 * @property $status
 * @property $start_time
 * @property $end_time
 * @property $pid
 */
class CronSchedule extends Model
{
    protected $table = 'cron_schedule';
    public $timestamps = false;

    const ACTIVE_STATUS = 'active';
    const PENDING_STATUS = 'pending';
    const DONE_STATUS = 'done';

    protected $fillable = [
            'cron_name',
            'status',
            'start_time',
            'end_time',
            'pid'
    ];
}
