<?php
namespace App\Modules\Crm\student_groups\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\student_groups\models\AddSpecialty;
use App\Modules\Crm\student_groups\models\AddStudentGroup;
use App\Modules\Crm\student_groups\models\SpecialtyFrom;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class SpecialtiesController extends AbstractController
{
    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->RmLink('add_specialties_operation')
            ->setText('Добавить специальность')
            ->setLink(route('student_groups.add_specialty'));
    }

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
    }

    /** Акшен создания специальности */
    public function actionAddSpecialty()
    {
        $form = new SpecialtyFrom('form', new FormAdditionalParam('post', route('student_groups.add_specialty')));

        if (request()->post()) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();

            BackendHelper::getRepositories()->createSpecialty($return_data->getNumber(), $return_data->getName(), $return_data->getDescription());
            return redirect()->route('student_groups.add_specialty');
        }

        ViewManager::appendElement($form);

        return view('student_groups::specialties.add_specialty');
    }
}
