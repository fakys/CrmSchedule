<?php
namespace App\Modules\Crm\lessons\controllers;

use App\Modules\Crm\lessons\models\AddSubject;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller{

    public function actionAddSubject()
    {
        return view('subjects.add_subject', ['nav_operation'=>true]);
    }

    public function addSubject()
    {
        $model = new AddSubject();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate()){
            BackendHelper::getRepositories()->createSubject($model->name, $model->full_name, $model->description);
        }
        return redirect()->route('lessons.action_add_subject');
    }

    public function actionSubjectsInfo()
    {
        $search_data = request()->session()->has('search-subject-info')
            ? request()->session()->get('search-subject-info') : [];

        if (request()->method() == 'POST') {
            $subjects = BackendHelper::getRepositories()->getSearchSubjectInfo(request()->post());
            if($search_data){
                request()->session()->forget('search-subject-info');
            }
            request()->session()->put('search-subject-info', request()->post());
            $search_data = request()->session()->get('search-subject-info');
        } else {
            if (request()->session()->has('search-subject-info')) {
                $subjects = BackendHelper::getRepositories()->getSearchSubjectInfo($search_data);
            } else {
                $subjects = BackendHelper::getRepositories()->getSubjectInfo();
            }
        }

        return view('subjects.subjects_info', [
            'subjects'=>$subjects,
            'nav_subject'=>true,
            'title'=>'Все предметы',
            'search_data'=>$search_data
        ]);
    }
}
