<?php
include_once(dirname(__FILE__) . '/DBconnect.php');
Class UserDB{
    function userdb_insert($ip,$mask){
        $db = new Dbconnect();
        $dbc=$db->connect();
        $rs=$dbc->prepare("INSERT INTO `useripdb_blacklist`(`ip_name`,`mask`) VALUES (:ip_name,:mask)");
        $array['ip_name'] = $ip;
        $array['mask'] = $mask;
        $result =  $rs->execute($array);
        return $result;
    }
    function userdb_delete($num){
        $db = new Dbconnect();
        $dbc=$db->connect();
        $rs = $dbc->prepare('DELETE FROM useripdb_blacklist WHERE num = :num');
        $rs->bindValue(":num", $num);
        $result = $rs->execute();
        return $result;
    }

    function userdb_get(){
        $db = new Dbconnect();
        $dbc=$db->connect();
        $rs=$dbc->prepare("SELECT * FROM useripdb_blacklist WHERE 1 ORDER BY num ");
        $rs->execute();
        $result = $rs->fetchAll();
        return $result;
    }
}
?>