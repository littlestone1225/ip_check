<?php
/* Report all errors except E_NOTICE */
error_reporting(E_ALL^E_NOTICE);
define("DB_HOST", "localhost");
define("DB_NAME", "ip_check");
define("DB_USER", "root");
define("DB_PASSWD", "");
define("WWW_PATH", "./");
define('ROOT_PATH', './');
define('MYKEY',"079781b4b7fc10e8f990bb037b4beb8b401b96d17a2ad708680e5042b905b80ddf83971e54f1fd9e");
define('BASE_URL', 'https://api.abuseipdb.com/api/v2/');
?>