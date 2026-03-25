<?php
namespace App\Modules\Crm\users_interface\model\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class UserBaseInfoReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('username')]
    private $username;

    #[ReturnDataFieldAttribute('fio')]
    private $fio;

    #[ReturnDataFieldAttribute('password')]
    private $password;

    #[ReturnDataFieldAttribute('groups')]
    private $groups;


    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFio(): string
    {
        return $this->fio;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGroups(): ?array
    {
        return $this->groups;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->getUsername(),
            'fio' => $this->getFio(),
            'password' => $this->getPassword(),
            'groups' => $this->getGroups(),
        ];
    }
}
