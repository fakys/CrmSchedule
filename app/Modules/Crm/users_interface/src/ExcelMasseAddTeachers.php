<?php

namespace App\Modules\Crm\users_interface\src;

use App\Entity\SchedulePlanType;
use App\Entity\StudentGroup;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Modules\Crm\users_interface\exceptions\MasseAddTeachersExceptions;
use App\Src\BackendHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Cell;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExcelMasseAddTeachers implements FromArray, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Логин', 'Фио', 'Номер телефона с +7', 'Email (не обязательный)', 'Серия и номер (не обязательный)']
        ];
    }

    public static function parseData($data, $validator): array
    {
        try {
            $settings = BackendHelper::getSystemSettings(ScheduleSetting::SETTING_NAME);

            unset($data[array_key_first($data)]);
            $all_user_data = [];
            foreach ($data as $row => $user_data) {
                $user_arr = [];

                //Логин
                if (empty($user_data['A']) && $user_data['A']) {
                    throw new MasseAddTeachersExceptions("Неверный логина на $row строке");
                }

                $validate_login = BackendHelper::getOperations()->validateLogin($user_data['A']);
                if ($validate_login) {
                    throw new MasseAddTeachersExceptions("Ошибка на строке $row: ".$validate_login);
                }
                $user_arr['username'] = trim($user_data['A']);

                //ФИО
                if (empty($user_data['B']) && !$user_data['B']) {
                    throw new MasseAddTeachersExceptions("Ошибка на строке $row: Фио обязательно для заполнения!");
                }

                $fio_arr = explode(" ", trim($user_data['B']));
                if (count($fio_arr) < 2) {
                    throw new MasseAddTeachersExceptions("Ошибка на строке $row: Фио обязательно для заполнения!");
                }

                $user_arr['last_name'] = trim($fio_arr[0]);
                $user_arr['first_name'] = trim($fio_arr[1]);
                $user_arr['patronymic'] = trim($fio_arr[2] ?? '');

                //Номер телефона
                if (empty($user_data['C'])) {
                    throw new MasseAddTeachersExceptions("Ошибка на строке $row: Номер телефона не задан!");
                }

                $validate_number = BackendHelper::getOperations()->validatePhoneNumber($user_data['C']);
                if ($validate_number) {
                    throw new MasseAddTeachersExceptions("Ошибка на строке $row: ".$validate_number);
                }
                $user_arr['number_phone'] = trim($user_data['C']);

                //Email
                if (isset($user_data['D']) && $user_data['D']) {
                    $validate_email = BackendHelper::getOperations()->validateEmail($user_data['D']);
                    if ($validate_email) {
                        throw new MasseAddTeachersExceptions("Ошибка на строке $row: ".$validate_email);
                    }
                    $user_arr['email'] = trim($user_data['D']);
                }

                if (isset($user_data['E']) && $user_data['E']) {
                    $validate_passport_data = BackendHelper::getOperations()->validateSeriesAndNumberString($user_data['E']);
                    if ($validate_passport_data) {
                        throw new MasseAddTeachersExceptions("Ошибка на строке $row: ".$validate_passport_data);
                    }

                    $passport_att = explode(' ', trim($user_data['E']));
                    $user_arr['passport_series'] = trim($passport_att[0]);
                    $user_arr['passport_number'] = trim($passport_att[1]);
                }

                $user_arr['groups'] = $settings->users_groups;
                $all_user_data[] = $user_arr;
            }
            return $all_user_data;
        } catch (MasseAddTeachersExceptions $exception) {
            $validator->errors()->add('file', $exception->getMessage());
            throw new ValidationException($validator);
        } catch (\Throwable $exception) {
            Log::error('[ExcelMasseAddTeachers][Error] ' . $exception->getMessage() . $exception->getTraceAsString());
            $validator->errors()->add('file', 'Ошибка парсинга файла!');
            throw new ValidationException($validator);
        }
    }
}
