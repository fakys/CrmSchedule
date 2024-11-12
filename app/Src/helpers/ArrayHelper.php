<?php
namespace App\Src\helpers;

class ArrayHelper
{
    public static function getColumn($arr, $col)
    {
        $new_arr = [];
        foreach ($arr as $k => $v) {
            if(isset($v[$col])) {
                $new_arr[] = $v[$col];
            }
        }
        return $new_arr;
    }
}
