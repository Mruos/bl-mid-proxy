<?php

header("Content-Type: text/html;charset=utf-8");

// 引入SDK
include 'bl.mid.proxy.php';

define('MYSQL_ROOT', 'http://192.168.1.108:9606/api/mysql');
define('REDIS_ROOT', 'http://192.168.1.108:9606/api/redis');

// 执行sql
$mysql=new MidMysql(MYSQL_ROOT);

$res=$mysql->sql("select * from userinfo");

echo $res;
echo '<br>';


// 执行redis
$redis=new MidRedis(REDIS_ROOT);

$res=$redis->order(0,"set 小明 14");

echo $res;
echo '<br>';

$res=$redis->set(0,"小张",'24',0);

echo $res;
echo '<br>';

$res=$redis->get(0,"小张");

echo $res;
echo '<br>';


?>