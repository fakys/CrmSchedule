<?php

namespace App\Modules\Crm\users_interface\operations;

use App\Modules\Crm\users_interface\src\UserData;
use App\Src\BackendHelper;
use App\Src\modules\operations\AbstractOperation;

class ValidationUserDataOperation extends AbstractOperation
{

    public function validateSeriesAndNumberString($series_number)
    {
        $series_number = trim($series_number);

        if (preg_match('/^\d{4}\s?\d{6}$/', $series_number) !== 1) {
            return 'Неверный формат серии и номера!';
        }
        $user = BackendHelper::getRepositories()->getUserBySeriesAndNumber($series_number);
        if ($user) {
            return 'Пользователь с такой серей и номером уже зарегистрирован!';
        }
    }

    public function validateLogin($login): ?string
    {
        $login = trim($login);
        $users = BackendHelper::getRepositories()->getFullUsersInfoSearch(['login' => $login]);
        if ($users) {
            return 'Пользователь с таким логином уже зарегистрирован!';
        }

        return null;
    }

    /**
     * Валидация номера телефона
     * @param $number
     * @return string|null
     */
    public function validatePhoneNumber($number): ?string
    {
        $number = trim($number);
        if (preg_match('/^\+7\d{10}$/', $number) !== 1) {
            return 'Неверный формат номера телефона!';
        }

        $users = BackendHelper::getRepositories()->getFullUsersInfoSearch(['number' => $number]);
        if ($users) {
            return 'Пользователь с таким номером телефона уже зарегистрирован!';
        }

        return null;
    }

    /**
     * Валидация email
     * @param $email
     * @return string|null
     */
    public function validateEmail($email): ?string
    {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Неверный формат email!';
        }

        $users = BackendHelper::getRepositories()->getFullUsersInfoSearch(['email' => $email]);
        if ($users) {
            return 'Пользователь с таким email уже зарегистрирован!';
        }

        return null;
    }

    public function getName(): string
    {
        return 'validation_user_data_operation';
    }
}
