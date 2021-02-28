<?php

header("Content-Type: text/html;charset=utf-8");

// 引入SDK
include 'bl.mid.proxy.php';

define('MYSQL_ROOT', 'http://192.168.1.2:9606/api/mysql');
define('REDIS_ROOT', 'http://192.168.1.2:9606/api/redis');
define('LOGGING_ROOT', 'http://192.168.1.2:9606/api/logging');


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


// logging test
$logging=new MidLogging(LOGGING_ROOT);

$logging->info('test','this is info msg.');
$logging->error('test','this is error msg.');
$logging->debug('test','this is debug msg.');
$logging->input('test','this is input msg.');
$logging->output('test','this is output msg.');
$logging->important('test','this is important msg.');
$logging->warning('test','this is warning msg.');
$logging->custom('test','this is custom msg.',$fontColor='16756453',$fontSize=16);

