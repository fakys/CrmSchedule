<?php
namespace App\Modules\Crm\student_groups\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $number
 * @property string $name
 * @property string $specialty
 */
class AddStudentGroup extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'name',
            'number',
            'specialty',
        ];
    }

    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'number'=>['required','string'],
            'specialty_id'=>[],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }
}
