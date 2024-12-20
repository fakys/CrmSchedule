<?php
namespace App\Modules\Crm\users_interface\model;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * Модель для добавления пользователя в группы
 */
class UserAddGroups extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'user_id',
            'groups',
        ];
    }

    public function rules(): array
    {
        return [
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }
}
