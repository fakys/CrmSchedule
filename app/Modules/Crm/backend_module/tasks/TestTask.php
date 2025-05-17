<?php
namespace App\Modules\Crm\backend_module\tasks;

use App\Entity\User;
use App\Src\modules\task\AbstractTask;

class TestTask extends AbstractTask
{


    public static function taskName(): string
    {
        return 'test_task';
    }

    public function Execute($args = []): bool
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

    public function getName(): string
    {
        return 'test_task';
    }
}
