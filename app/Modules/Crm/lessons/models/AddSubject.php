<?php
namespace App\Modules\Crm\student_groups\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $number
 * @property string $name
 * @property string $description
 */
class AddSpecialty extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'name',
            'number',
            'description',
        ];
    }

    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'number'=>['required','string'],
            'description'=>['text'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }
}
