<?php
namespace App\Modules\Crm\system_settings\models;

use App\Assets\BaseLayoutBundle;
use App\Modules\Crm\system_settings\models\returnData\SystemSettingsReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\Select;

class SystemSettingsFormModel extends AbstractForm
{
    public function getAssets(): array
    {
        return [
            BaseLayoutBundle::class,
        ];
    }
    public function getAttribute(): array
    {
        return [
            'site_tome_zone',
            'db_tome_zone',
            'system_name',
            'system_lang',
            'use_cash'
        ];
    }

    public function returnData(): string
    {
        return SystemSettingsReturnData::class;
    }

    public function buildForm()
    {
        $allTimezones = [
            'Europe/Kaliningrad' => '+2',
            'Europe/Moscow' => '+3',
            'Europe/Samara' => '+4',
            'Asia/Yekaterinburg' => '+5',
            'Asia/Omsk' => '+6',
            'Asia/Krasnoyarsk' => '+7',
            'Asia/Irkutsk' => '+8',
            'Asia/Yakutsk' => '+9',
            'Asia/Vladivostok' => '+10',
            'Asia/Magadan'=> '+11',
            'Asia/Kamchatka' => '+12',
        ];

        $systemLang = [
            'ru'=>'Русский',
            'en'=>'English'
        ];

        $this->appendElements(
            new Select('site_tome_zone', $allTimezones, new LabelAdditionalParams('Часовой пояс системы'), new SelectElementAdditionalParams()),
        );
        $this->appendElements(
            new Select('db_tome_zone', $allTimezones, new LabelAdditionalParams('Часовой пояс базы данных'), new SelectElementAdditionalParams()),
        );
        $this->appendElements(
            new Input('text', 'system_name', new LabelAdditionalParams('Название системы'), new FormElementAdditionalParams()),
        );
        $this->appendElements(
            new Select('system_lang', $systemLang, new LabelAdditionalParams('Название системы'), new SelectElementAdditionalParams()),
        );

        $this->appendElements(
            new Button('Сохранить', 'submit', new FormElementAdditionalParams())
        );


        $this->getValidationBuilder()->getSetRules(
            [
                'system_name' => ['required', 'max:255', 'min:3', 'string'],
                'db_tome_zone' => ['required'],
                'site_tome_zone' => ['required'],
                'system_lang' => ['required']
            ]
        );
    }
}

