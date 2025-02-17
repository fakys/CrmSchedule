<?php
namespace App\Modules\Crm\lessons\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $number
 * @property string $full_name
 * @property string $description
 */
class AddSubject extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'name',
            'full_name',
            'description',
        ];
    }

    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'full_name'=>['required','string'],
            'description'=>[],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }
}
