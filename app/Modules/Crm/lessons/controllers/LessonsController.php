<?php
namespace App\Modules\Crm\lessons\controllers;

use App\Modules\Crm\lessons\models\AddNumberPairs;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class LessonsController extends Controller{


    /**
     * Последовательность пар
     */
    public function actionNumberPair()
    {
        $pair_number = BackendHelper::getRepositories()->getNumberPair();
        return view('lessons.pair_number', [
            'pair_number' => $pair_number,
            'title'=>'Последовательность пар',
            'nav_subject'=>true
        ]);
    }

    public function actionAddNumberPair()
    {
        return view('lessons.form_pair_number', [
            'title'=>'Добавить последовательность пар',
            'nav_subject'=>true
        ]);
    }

    public function addNumberPair()
    {
        if (request()->isMethod('POST')) {
            $model = new AddNumberPairs();
            $model->load(request()->all());
            $validate = Validator::make($model->getData(), $model->rules());
            if ($validate->validate()) {
                BackendHelper::getRepositories()->addNumberPair($model->getData());
            }
        }
        return redirect()->route('lessons.pair_number');
    }

    public function actionUpdateNumberPair()
    {
        $id = request()->get('id');
        $number_pair = BackendHelper::getRepositories()->getNumberPairById($id);
        if (!$number_pair) {
            abort(404);
        }
        return view('lessons.form_pair_number', [
            'title'=>'Добавить последовательность пар',
            'number_pair'=>$number_pair,
            'nav_subject'=>true
        ]);
    }

    public function updateNumberPair()
    {
        if (request()->isMethod('POST')) {
            $id = request()->get('id');
            $model = new AddNumberPairs();
            $model->load(request()->all());
            $validate = Validator::make($model->getData(), $model->rules());
            if ($validate->validate()) {
                BackendHelper::getRepositories()->updateNumberPairById($model->getData(), $id);
            }
        }
        return redirect()->route('lessons.pair_number');
    }

    public function deleteNumberPaid()
    {
        if (request()->isMethod('POST')) {
            $id = request()->post('pair_id');
            return BackendHelper::getRepositories()->deleteNumberPairById($id);
        }
        return false;
    }
}
