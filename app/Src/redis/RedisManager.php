<?php

namespace App\Src\redis;

use App\Src\traits\TraitObjects;

class RedisManager
{

    use TraitObjects;

    public $redis;

    /**
     * @throws \RedisException
     */
    public function __construct()
    {
        try {
            $this->redis = new \Redis();
            $this->redis->connect('redis', 6379);
        }catch (\Exception $e){
            var_dump($e->getMessage());
        }
    }

    /**
     * @return \Redis
     */
    public static function redis()
    {
        return self::objects()->redis;
    }
}
