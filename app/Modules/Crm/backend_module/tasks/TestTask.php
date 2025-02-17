<?php
namespace App\Modules\Crm\backend_module\tasks;

use App\Entity\User;
use App\Src\crons\interfaces\TaskInterface;

class TestTask implements TaskInterface
{


    public static function taskName(): string
    {
        return 'test_task';
    }

    public function Execute(): bool
    {
        $user = new User();
        $user->username = uniqid();
        $user->password = 'test_password';
        $user->save();
        return true;
    }

    public static function RepeatInterval()
    {
        return [];
    }

    public static function TimeZone(): string
    {
        return '';
    }
}
