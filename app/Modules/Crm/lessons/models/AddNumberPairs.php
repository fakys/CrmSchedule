<?php
namespace App\Modules\Crm\lessons\models;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

/**
 * @property string $number
 * @property string $full_name
 * @property string $description
 */
class AddNumberPairs extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'name',
            'number',
        ];
    }

    public function rules(): array
    {
        return [
            'name'=>['required', 'string'],
            'number'=>['required','integer', ['min'=>0]],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }
}
