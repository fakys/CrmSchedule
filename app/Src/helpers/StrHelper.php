<?php
namespace App\Src\helpers;

class StrHelper{
    public static function parse_uri($uri)
    {
        if($uri && is_string($uri)){
           $arr_uri = explode('/',substr($uri, 1,strlen($uri)));
           if(isset($arr_uri[0])){
               return $arr_uri[0];
           }
        }
        return false;
    }
}
