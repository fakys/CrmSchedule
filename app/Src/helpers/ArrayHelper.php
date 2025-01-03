<?php
namespace App\Src\helpers;

class ArrayHelper
{
    public static function getColumn($arr, $col, $key = '')
    {
        $new_arr = [];
        foreach ($arr as $k => $v) {
            if (is_object($v)) {
                if ($key) {
                    if (isset($v->$col)) {
                        $new_arr[$v->$key] = $v->$col;
                    }
                } else {
                    if (isset($v->$col)) {
                        $new_arr[$k] = $v->$col;
                    }
                }
            } else {
                if ($key) {
                    if (isset($v[$col])) {
                        $new_arr[$v[$key]] = $v[$col];
                    }
                } else {
                    if (isset($v[$col])) {
                        $new_arr[$k] = $v[$col];
                    }
                }
            }
        }

        return $new_arr;
    }

    public static function valueIsKey($arr)
    {
        $new_arr = [];
        if($new_arr){
            foreach ($arr as $k => $v) {
                $new_arr[$v] = $v;
            }
        }

        return $new_arr;
    }
}
