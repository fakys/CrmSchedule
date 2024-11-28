<?php
namespace App\Modules\Crm\users_interface\model;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
class EditUserTabs extends Model implements InterfaceModel
{
    protected $errors = [];
    protected $required_fields = [
        'last_name',
        'first_name'
    ];

    protected $date=[
        'birthday'
    ];

    public function fields(): array
    {
        return [
            'last_name',
            'first_name',
            'patronymic',
            'email',
            'number_phone',
            'birthday',
            'inn',
            'passport_series',
            'passport_number',
            'snils',
            'address'
        ];
    }

    public function rules(): array
    {
        return [
            'last_name'=>['string', 'min:3'],
            'first_name'=>['string', 'min:3'],
            'patronymic'=>['string'],
            'email'=>['string', 'email'],
            'number_phone'=>[],
            'birthday'=>[],
            'inn'=>['string'],
            'passport_series'=>['string'],
            'passport_number'=>['string'],
            'snils'=>['string'],
            'address'=>['string'],
        ];
    }

    public function customValidate()
    {
        $data = $this->getData();
        foreach ($data as $field => $value) {
            if(in_array($field, $this->required_fields)&& !$value){
                $this->errors = [$field => "Поле не может быть пустым."];
                return false;
            }
            if(in_array($field, $this->date) && $value){
                $this->data[$field] = date('Y-m-d H:i:s', strtotime($value));
            }
        }
        return true;
    }

    public function boolean(): array
    {
        return [

        ];
    }
}
