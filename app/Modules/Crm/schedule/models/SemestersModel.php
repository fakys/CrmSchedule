<?php
namespace App\Modules\Crm\schedule\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;


/**
 * @property $name
 * @property $date_start
 * @property $date_end
 */
class SemestersModel extends Model implements InterfaceModel
{
    public function fields(): array
    {
        return [
            'name',
            'date_start',
            'date_end',
        ];
    }

    //Сделать валидацию
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'date_start' => ['required', 'date', 'before:date_end'],
            'date_end' => ['required', 'date'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

}
