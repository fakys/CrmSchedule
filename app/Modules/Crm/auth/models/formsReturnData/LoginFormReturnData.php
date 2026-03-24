<?php

namespace App\Modules\Crm\auth\models\formsReturnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class LoginFormReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('login')]
    private $login;

    #[ReturnDataFieldAttribute('password')]
    private $password;

    #[ReturnDataFieldAttribute('remember')]
    private $remember = false;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getRemember():bool
    {
        return (bool)$this->remember;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'login' => $this->getLogin(),
            'password' => $this->getPassword(),
        ];
    }
}
