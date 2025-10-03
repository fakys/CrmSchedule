<?php
namespace App\Modules\Crm\reports\controllers;

use App\Exports\ExportExcel;
use App\Modules\Crm\reports\models\ReportForGroupModel;
use App\Modules\Crm\reports\models\ReportForTeachers;
use App\Modules\Crm\reports\tasks\ReportForGroupTask;
use App\Modules\Crm\reports\tasks\ReportForTeachersTask;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ReportsController extends AbstractController
{

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('reports')
            ->setText('Отчеты')
            ->setIcon('fa fa-file');

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('reports')
            ->RmLink('report_for_group')
            ->setText('Отчет по группам (по семестрам)')
            ->setLink(route('reports.report_for_group'));

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('reports')
            ->RmLink('report_for_teachers')
            ->setText('Отчет по преподавателям (по семестрам)')
            ->setLink(route('reports.report_for_teachers'));
    }

    public function actionReportForGroup()
    {
        $students_groups = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullStudentGroups(), 'number', 'id');
        $specialties = ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllSpecialties(), 'name', 'id');
        $task_name = ReportForGroupTask::taskName();

        if (request()->post()) {
            $model = new ReportForGroupModel();
            $model->load(request()->post());
            $data = BackendHelper::getOperations()->getReportsForGroup($model->getData()['period'], $model->getData()['students_group'] ?? [], $model->getData()['specialties'] ?? []);
            request()->session()->put(ReportForGroupModel::REPORT_FOR_GROUP, $model->getData());
        } else {
            $current_semester = BackendHelper::getRepositories()->getSemestersByDate(new \DateTime());
            $data = BackendHelper::getOperations()->getReportsForGroup($current_semester->date_start." - ".$current_semester->date_end);
        }
        $search_data = request()->session()->get(ReportForGroupModel::REPORT_FOR_GROUP);
        return view('reports.report_for_group', compact('data', 'students_groups', 'specialties', 'search_data', 'task_name'));
    }


    public function actionReportForTeachers()
    {
        try {
            $task_name = ReportForTeachersTask::taskName();
            $teachers_data = BackendHelper::getRepositories()->getAllTeachers();
            $teachers = [];


            if (request()->post()) {
                $model = new ReportForTeachers();
                $model->load(request()->post());
                $data = BackendHelper::getOperations()->getReportsForTeachers($model->getData()['period'], $model->getData()['teachers'] ?? []);
                request()->session()->put(ReportForTeachers::REPORT_FOR_GROUP, $model->getData());
            } else {
                $current_semester = BackendHelper::getRepositories()->getSemestersByDate(new \DateTime());
                $data = BackendHelper::getOperations()->getReportsForTeachers($current_semester->date_start." - ".$current_semester->date_end);

            }

            foreach ($teachers_data as $teacher) {
                $teachers[$teacher->id] = $teacher->getFio();
            }
            $search_data = request()->session()->get(ReportForTeachers::REPORT_FOR_GROUP);

            return view('reports.report_for_teachers', compact('task_name', 'teachers', 'data', 'search_data'));
        } catch (\Throwable $exception) {
            dd($exception->getMessage() . $exception->getTraceAsString());
        }

    }


    /**
     * Создает таск на выгрузку отчета
     * @return null|true
     */
    public function exportReport()
    {
        if (request()->post()) {
            BackendHelper::taskCreate(request()->post('task_name'), array_merge(request()->post(), ['userName'=>context()->getUser()->username]));
            return true;
        }
    }

    /**
     * Проверяет создан ли таск
     * @return false|string
     */
    public function checkExport()
    {
        $task_name = request()->post('task_name');
        $user_name = context()->getUser()->username;
        return BackendHelper::getOperations()->checkExportTask($task_name, $user_name);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function downloadFile()
    {
        $task_name = request()->get('task_name');
        $user_name = context()->getUser()->username;

        if (Storage::has(sprintf('reports/%s_%s.%s', $task_name, $user_name, ExportExcel::XLSX))) {

            return  response()->download(Storage::path(sprintf('reports/%s_%s.%s', $task_name, $user_name, ExportExcel::XLSX)), 'report.xlsx')->deleteFileAfterSend(true);
        }
    }

}
