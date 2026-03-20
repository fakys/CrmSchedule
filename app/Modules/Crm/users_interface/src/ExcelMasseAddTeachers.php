<?php
namespace App\Modules\Crm\users_interface\src;

use App\Entity\SchedulePlanType;
use App\Entity\StudentGroup;
use App\Modules\Crm\schedule_plan\models\SchedulePlanTypeModel;
use App\Src\BackendHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

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
            unset($data[array_key_first($data)]);
            $all_user_data = [];
            foreach ($data as $user_data) {
                $user_arr = [];
                $user_arr['username'] = $user_data[0];
                $user_arr['email'] = $user_data[1];

            }
            return [];
        } catch (\Throwable $exception) {
            Log::error('[ExcelMasseAddTeachers][Error] '.$exception->getMessage().$exception->getTraceAsString());
            $validator->errors()->add('file', 'Ошибка парсинга файла!');
            throw new ValidationException($validator);
        }
    }
}
