<?php

namespace Tests\Unit\modules\users_interface;


use App\Modules\Crm\users_interface\src\ExcelMasseAddTeachers;
use Illuminate\Support\Facades\Validator;
use Tests\AbstractTransactionTestCase;

/**
 * Тест массового добавления пользователей
 */
class MasseAddUserTest extends AbstractTransactionTestCase
{

    /** Тест парсинга файла */
    public function testParseFileAddMasseTeachers()
    {
        $validate = Validator::make([], []);
        $data = ExcelMasseAddTeachers::parseData([
            ['Логин', 'Фио', 'Номер телефона с +7', 'Email (не обязательный)', 'Серия и номер (не обязательный)'],
            ['A' => 'test', 'B' => 'Лавров Иван', 'C' => '+79979135089', 'D' => 'test@mail.ru', 'E' => '1232 231523'],
        ], $validate);
        $this->assertTrue(
            $data[0]['username'] == 'test' &&
            $data[0]['last_name'] == 'Лавров' &&
            $data[0]['first_name'] == 'Иван' &&
            $data[0]['patronymic'] == '' &&
            $data[0]['number_phone'] == "+79979135089" &&
            $data[0]['email'] == 'test@mail.ru' &&
            $data[0]['passport_series'] == '1232' &&
            $data[0]['passport_number'] == '231523',
            'Данные были неверно спаршены'
        );
    }
}
