<?php

namespace App\Entity;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $id
 * @property string $name
 * @property string $plan_type_data
 * @property string $created_at
 * @property string $updated_at
 */
class SchedulePlanType extends Model
{
    protected $table = 'schedule_plan_type';

    protected $fillable = [
        'name',
        'plan_type_data',
    ];

    public function getWeeks()
    {
        return json_decode($this->plan_type_data, 1)['weeks'];
    }
}
