<?php

namespace App\Src\modules\providers;

use App\Entity\StatusModules;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\entity\ModuleEntity;
use App\Src\modules\kernel\KernelModules;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

abstract class AbstractModulesProvider extends ServiceProvider
{
    private $config;
    private $module_path;

    abstract public function modulePathName(): string;
    abstract public function prefixModulePathName(): string;
    abstract public function moduleModel(): string;


    protected function migrationFileName()
    {
        return "migrations";
    }

    protected function controllerFileName()
    {
        return "controllers";
    }

    protected function routesFileName()
    {
        return "routes";
    }

    protected function viewsFileName()
    {
        return "views";
    }

    public function __construct($dispatcher = null)
    {
        parent::__construct($dispatcher);
        $this->config = config('modules');
        $this->module_path = $this->config['base_path'] . DIRECTORY_SEPARATOR . $this->prefixModulePathName() . DIRECTORY_SEPARATOR . $this->modulePathName();
    }

    //Регистрируем миграции
    private function registrationMigration()
    {
        if (is_dir($this->module_path . $this->migrationFileName())) {
            $this->loadMigrationsFrom($this->module_path . $this->migrationFileName());
        }
    }

    //Регистрируем роуты
    private function registrationRoutes()
    {
        if (is_dir($this->module_path . DIRECTORY_SEPARATOR . $this->routesFileName())) {
            Route::group(['middleware' => ['web']], function () {
                $this->loadRoutesFrom($this->module_path . DIRECTORY_SEPARATOR . $this->routesFileName().DIRECTORY_SEPARATOR.'web.php');
            });
        }
    }

    //Регистрируем страницы
    private function registrationViews()
    {
        if (is_dir($this->module_path . DIRECTORY_SEPARATOR . $this->viewsFileName())) {
            $this->loadViewsFrom(
                $this->module_path. DIRECTORY_SEPARATOR . $this->viewsFileName(),
                $this->modulePathName()
            );
        }
    }


    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registrationMigration();
        $this->registrationRoutes();
        $this->registrationViews();
    }

    /**
     * Регистрируем модуль
     * Bootstrap services.
     */
    public function boot(): void
    {
        $modules = $this->app->get(KernelModules::MODULE_KEY);
        /** @var InterfaceInfoModule $module */
        $module = new ($this->moduleModel())();
        $module_entity = new ModuleEntity($module);
        $modules[$module::getNameModule()] = $module_entity;

        /** @var StatusModules $status */
        $status = StatusModules::where(['name' => $module->getNameModule()])->first();
        if ($status) {
            $module_entity->setStatus($status->active);
        }
    }
}
