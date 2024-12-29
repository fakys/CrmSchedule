<?php
namespace App\Src\helpers;

class StrHelper{
    public static function parse_uri($uri, $full_url = false)
    {
        if($uri && is_string($uri)){
           $arr_uri = explode('/',substr($uri, 1,strlen($uri)));
           if($full_url){
               $arr_uri = array_shift($arr_uri);
           }
           if(isset($arr_uri[0])){
               return $arr_uri[0];
           }
        }
        return false;
    }

    public static function delete_first_slash($uri)
    {
        return substr($uri, 0, 1) == '/' ? substr($uri, 1) : $uri;
    }
}
