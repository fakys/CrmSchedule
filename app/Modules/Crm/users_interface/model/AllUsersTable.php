<?php
namespace App\Modules\Crm\users_interface\model;

use App\Assets\JsTableBundle;
use App\Services\Table\Infrastructure\Services\AbstractTable;

class AllUsersTable extends AbstractTable
{

    public function getAssets(): array
    {
        return [
            JsTableBundle::class
        ];
    }

    public function getColumns(): array
    {
        return [
            'name' => 'Логин',
            'fio' => 'ФИО',
            'email' => 'Email',
            'number_phone' => 'Мобильный телефон',
            'inn' => 'ИНН',
            'snils' => 'СНИЛС',
            'birthday' => 'Дата рождения'
        ];
    }

    public function buildTable()
    {
//        $this->appendTab('Информация о пользователе', 'fa fa-user', route('users_interface.tabs.user_tabs'), '#2077a3');
//        $this->appendTab('Редактировать пользователя', 'fa fa-user', route('users_interface.tabs.edit_user_tabs'), '#2077a3');
//        $this->appendTab('Доступ', 'fa fa-unlock-alt', route('users_interface.tabs.get_access_tabs'), '#8400ff');
//        $this->appendTab('Группы пользователя', 'fa fa-address-card', route('users_interface.tabs.get_role_tabs'), '#198754FF');
//        $this->appendTab('Заблокировать пользователя', 'fa fa-ban', '', '#DC3545FF');
//        $this->appendTab('Активность', 'fa fa-info-circle', '', '#FD7E14FF');
//        $this->appendTab('Сообщения', 'fa fa-comment', '', '#6C757DFF');
//        $this->appendTab('Стили', 'fa fa-magic', route('users_interface.tabs.user_style_tab'), '#3e1987');
    }
}
