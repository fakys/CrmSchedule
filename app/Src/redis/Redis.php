<?php

namespace App\Src\redis;

use App\Src\traits\TraitObjects;

class Redis
{
    use TraitObjects;

    /**
     * @var \Redis $redis
     */
    public \Redis $redis;

    /**
     * @throws \RedisException
     */
    public function __construct()
    {
        $redis = new \Redis();
        $redis->connect('redis', 6379);
        $this->redis = $redis;
    }

    public static function redis(): \Redis
    {
        return self::objects()->redis;
    }
}
