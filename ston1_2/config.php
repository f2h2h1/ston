<?php
//数据库连接配置
$dataBaseConfig['dataBaseHost'] = "";
$dataBaseConfig['dataBaseName'] = "";
$dataBaseConfig['dataBaseServerPort'] = "";
$dataBaseConfig['dataBaseUserName'] = "";
$dataBaseConfig['dataBasePassWord'] = "";
$dataBaseConfig['sourceName'] = "mysql:dbname={$dataBaseConfig['dataBaseName']};host={$dataBaseConfig['dataBaseHost']};port={$dataBaseConfig['dataBaseServerPort']}";

define('DATABASE_HOST', $dataBaseConfig['dataBaseHost']);
define('DATABASE_NAME', $dataBaseConfig['dataBaseName']);
define('DATABASE_SERVER_PORT', $dataBaseConfig['dataBaseServerPort']);
define('DATABASE_USERNAME', $dataBaseConfig['dataBaseUserName']);
define('DATABASE_PASSWORD', $dataBaseConfig['dataBasePassWord']);

//数据库表名
define('DB_TABLE', "sontan_jiaowu");

//是否开启token验证
define('isTOKEN', false);

//教务系统的地址
define('JW_HOST', "http://jwxt.sontan.net/");//本科
define('JW_HOST2', "http://jwxt.sontan.net/");//专科
