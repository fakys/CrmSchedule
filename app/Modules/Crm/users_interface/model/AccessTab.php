<?php
namespace App\Modules\Crm\users_interface\model;

use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class AccessTab extends Model implements InterfaceModel
{
    const APPROVED = 'approved';
    const REJECTED = 'rejected';

    public function fields(): array
    {
        return [
          'username',
          'password',
          'password_confirm'
        ];
    }

    public function rules(): array
    {
        return [
            'username'=>['required','string', 'min:3', 'max:35'],
            'password'=>['string', 'min:6', 'required_with:password_confirm'],
            'password_confirm'=>['string', 'min:6'],
        ];
    }

    public function boolean(): array
    {
        return [];
    }
}
