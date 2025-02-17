<?php
namespace App\Modules\Crm\lessons\repositories;

use App\Entity\PairNumber;
use App\Src\modules\repository\Repository;

class LessonsRepository extends Repository{

    /**
     * Возвращает все последовательности пар
     * @return mixed
     */
    public function getNumberPair()
    {
        return PairNumber::all();
    }

    /**
     * Возвращает последовательность пар по id
     * @param $id
     */
    public function getNumberPairById($id)
    {
        return PairNumber::where(['id'=>$id])->first();
    }

    /**
     * Создает последовательность пар
     * @param array $data
     * @return bool
     */
    public function addNumberPair($data)
    {
        $pair = new PairNumber();

        foreach($data as $key => $value){
            $pair->$key = $value;
        }
        return $pair->save();
    }

    /**
     * Обновляет последовательность пар по id
     * @param $data
     * @param $id
     * @return bool
     */
    public function updateNumberPairById($data, $id)
    {
        $pair = PairNumber::where(['id'=>$id])->first();
        if ($pair) {
            foreach($data as $key => $value){
                $pair->$key = $value;
            }
            return $pair->save();
        }
        return false;
    }

    /**
     * Удаляет последовательность пар по id
     * @param $id
     * @return bool
     */
    public function deleteNumberPairById($id)
    {
        $pair = PairNumber::where(['id'=>$id])->first();

        if ($pair) {
            return $pair->delete();
        }
        return false;
    }
}
