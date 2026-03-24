<?php
namespace App\Modules\Crm\system_settings\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class SystemSettingsReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('system_lang')]
    private $system_lang;

    #[ReturnDataFieldAttribute('system_name')]
    private $system_name;

    #[ReturnDataFieldAttribute('db_tome_zone')]
    private $db_tome_zone;

    #[ReturnDataFieldAttribute('site_tome_zone')]
    private $site_tome_zone;

    public function toArray(): array
    {
        return [];
    }
}
