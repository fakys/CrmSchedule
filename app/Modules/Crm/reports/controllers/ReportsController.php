<?php
namespace App\Modules\Crm\reports\controllers;

use App\Modules\Crm\reports\models\ReportForGroupModel;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;

class ReportsController extends Controller
{

    public function actionReportForGroup()
    {
        $current_semester = BackendHelper::getRepositories()->getSemestersByDate(new \DateTime());


        if (request()->post()) {
            $model = new ReportForGroupModel();
            $model->load(request()->post());
            $data = BackendHelper::getOperations()->getReportsForGroup($model->getData()['period']);
        } else {
            $data = BackendHelper::getOperations()->getReportsForGroup($current_semester->date_start." - ".$current_semester->date_end);
        }


        return view('reports.report_for_group', compact('data'));
    }
}
