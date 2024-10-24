<?php

namespace App\Src\traits;

trait TraitObjects{
    private static $objects;
    public static function objects($data=[], $called=false)
    {
        if(!self::$objects){
            if($called){
                $obj = new (get_class())($data);
                self::$objects= $obj;
            }else{
                $obj = new (get_called_class())($data);
                self::$objects= $obj;
            }
        }
        return self::$objects;
    }
}
