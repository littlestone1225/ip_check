<?php

include_once("config.php");

class Dbconnect
{
    function connect()
    {
        try {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
            return new PDO($dsn, DB_USER, DB_PASSWD);
        } catch (PDOException $e) {
            echo "資料庫連線失敗，請洽網站管理人。";
            exit;
        }
    }

}
?>