<?php

namespace App\Console\Commands;

use App\Src\BackendHelper;
use Illuminate\Console\Command;

class BuildModules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:build-modules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Билдит модули в status_modules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = BackendHelper::getKernel()->getModules();
        $modules_active_status = BackendHelper::getRepositories()->getAllActiveModules();
        BackendHelper::getRepositories()->clearModules();
        $active_modules = [];

        foreach ($modules_active_status as $active_module) {
            $module_exist = false;
            foreach ($modules as $module) {
                if ($module->getModule()->getNameModule() == $active_module->name) {
                    $module_exist = true;
                }
            }
            if ($module_exist) {
                $active_modules[$active_module->name] = true;
            }
        }

        foreach ($modules as $module) {
            BackendHelper::getRepositories()->createStatusModules([
                'name' => $module->getModule()->getNameModule(),
                'active' => isset($active_module[$module->getModule()->getNameModule()]) || $module->getModule()->requiredModule()
            ]);
        }
    }
}
