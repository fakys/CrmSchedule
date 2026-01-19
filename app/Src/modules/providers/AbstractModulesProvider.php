<?php

namespace App\Src\modules\providers;

use App\Entity\StatusModules;
use App\Middleware\AccessMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\ModulesMiddleware;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\entity\ModuleEntity;
use App\Src\modules\kernel\KernelConstructor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\inArray;

abstract class AbstractModulesProvider extends ServiceProvider
{
    private $config;
    private $module_path;

    abstract public function modulePathName(): string;

    abstract public function prefixModulePathName(): string;

    abstract public function moduleModel(): string;


    protected function migrationPath()
    {
        return "migrations";
    }

    protected function controllerPath()
    {
        return "controllers";
    }

    protected function routesPath()
    {
        return "routes";
    }

    protected function routesFile()
    {
        return "web.php";
    }

    protected function viewsPath()
    {
        return "views";
    }

    protected function middlewares(): array
    {
        return ['web', ModulesMiddleware::class, AccessMiddleware::class];
    }

    protected function authMiddlewares()
    {
        return [AuthMiddleware::class, AccessMiddleware::class];
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
        if (is_dir($this->module_path . $this->migrationPath())) {
            $this->loadMigrationsFrom($this->module_path . $this->migrationPath());
        }
    }

    //Регистрируем роуты
    private function registrationRoutes()
    {
        if (is_dir($this->module_path . DIRECTORY_SEPARATOR . $this->routesPath())) {
            Route::group(
                ['middleware' => in_array($this->moduleModel()::getNameModule(), $this->config['public_modules']) ? $this->middlewares() : array_merge($this->middlewares(), $this->authMiddlewares())],
                function () {
                    $this->loadRoutesFrom($this->module_path . DIRECTORY_SEPARATOR . $this->routesPath() . DIRECTORY_SEPARATOR . $this->routesFile());
                });
        }
    }

    //Регистрируем страницы
    private function registrationViews()
    {
        if (is_dir($this->module_path . DIRECTORY_SEPARATOR . $this->viewsPath())) {
            $this->loadViewsFrom(
                $this->module_path . DIRECTORY_SEPARATOR . $this->viewsPath(),
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
        $modules = $this->app->get(KernelConstructor::MODULE_KEY);
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
