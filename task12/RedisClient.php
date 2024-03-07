<?php

use Predis\Client;

class RedisClient
{
    private Client $redis;

    public function __construct()
    {
        $this->redis = new Predis\Client([
            'host' => 'localhost',
            'port' => 6379,
        ]);
    }

    public function getClient(): Client
    {
        return $this->redis;
    }
}