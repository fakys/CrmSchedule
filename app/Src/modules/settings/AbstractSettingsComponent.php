<?php
namespace App\Src\modules\settings;

use App\Entity\SystemSetting;
use App\Src\modules\components\AbstractComponents;
use App\Src\modules\exceptions\BackendException;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class AbstractSettingsComponent extends AbstractComponents
{
    private array $settings;

    public function __construct($kernel)
    {
        parent::__construct($kernel);
        /** todo Придумать что-нибудь */
        $settings='';
        try {
            /** @var SystemSetting $settings */
            $settings = SystemSetting::where('name', $this->getName())->where('active', true)->orderBy('id', 'desc')->first();
        } catch (Throwable $exception) {

        }

        if (!$settings) {
            $this->settings = $this->getDefaultSettings();
        } else {
            $settings_arr = [];
            foreach (json_decode($settings->settings, 1) as $key => $setting) {
                if (isset($this->getDefaultSettings()[$key])) {
                    $settings_arr[$key] = $setting;
                }
            }
            $this->settings = $settings_arr;
        }
    }

    public function __get($name)
    {
        return $this->settings[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->settings[$name] = $value;
        $this->setSettings();
    }

    protected function setSettings()
    {
        DB::update('update system_settings set active = false where name = :name', ['name' => $this->getName()]);

        $setting = new SystemSetting();
        $setting->name = $this->getName();
        $setting->settings = json_encode($this->settings);
        $setting->active = true;
        $setting->create_user_id = $this->kernel->getContext()->getUser()->id;
        $setting->save();
    }

    abstract public function getDefaultSettings(): array;

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function loadSettings($data)
    {
        foreach ($data as $name => $value) {
            if (isset($this->getDefaultSettings()[$name])) {
                $this->settings[$name] = $value;
            }
        }
        $this->setSettings();
    }
}
