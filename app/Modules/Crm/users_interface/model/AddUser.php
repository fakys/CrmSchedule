<?php
namespace App\Modules\Crm\users_interface\model;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
use Illuminate\Validation\Rule;

/**
 * Модель для добавления пользователя
 */
class AddUser extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'username',
            'fio',
            'first_name',
            'last_name',
            'patronymic',
            'password',
            'user_groups',
            'groups'
        ];
    }

    public function rules(): array
    {
        return [
            'username'=>['required', 'string', Rule::unique('users', 'username')],
            'fio'=>['required', 'string'],
            'password'=>['required', 'string'],
            'user_groups'=>[],
        ];
    }

    public function parseFio()
    {
        $fio = trim(preg_replace('/\s+/', ' ', $this->fio));
        $arr_fio = explode(' ', $fio);
        if(count($arr_fio)==3){
            $this->fio = $fio;
            $this->first_name = $arr_fio[0];
            $this->last_name = $arr_fio[1];
            $this->patronymic = $arr_fio[2];
            return true;
        }
        return false;
    }

    public function boolean(): array
    {
        return [
        ];
    }
}
