<?php
namespace App\Modules\Crm\users_interface\model;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class UsersGroup extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'name',
            'accesses',
            'description',
            'active'
        ];
    }

    public function rules(): array
    {
        return [
            'name'=>['required','string', 'min:3', 'max:55'],
            'description'=>['string', 'min:3', 'max:255']
        ];
    }

    public function boolean(): array
    {
        return [
            'active'
        ];
    }

    /**
     * возвращает статусы в json
     * @return string
     */
    public function getAccesses()
    {
        if(!$this->accesses){
            return '';
        }
        return  json_encode($this->accesses, 1);
    }
}
