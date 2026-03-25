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

    public function getSystemLang(): ?string
    {
        return $this->system_lang;
    }

    public function getSystemName(): ?string
    {
        return $this->system_name;
    }

    public function getDbTomeZone(): ?string
    {
        return $this->db_tome_zone;
    }

    public function getSiteTomeZone(): ?string
    {
        return $this->site_tome_zone;
    }

    public function toArray(): array
    {
        return [
            'system_lang' => $this->system_lang,
            'system_name' => $this->system_name,
            'db_tome_zone' => $this->db_tome_zone,
            'site_tome_zone' => $this->site_tome_zone,
        ];
    }
}
