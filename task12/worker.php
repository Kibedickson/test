<?php

require 'vendor/autoload.php';
require 'RedisClient.php';
require 'SendEmailJob.php';

$redis = new RedisClient();
Resque::setBackend($redis->getClient());

$worker = new Resque_Worker('default');
$worker->work(5);

echo "Worker finished!\n";
