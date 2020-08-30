<?php
include_once(dirname(__FILE__) . '/DBconnect.php');
Class UserDB{
    function userdb_insert($ip,$mask){
        $db = new Dbconnect();
        $dbc=$db->connect();
        $rs=$dbc->prepare("INSERT INTO `useripdb_blacklist`(`ipAddress`,`mask`) VALUES (:ipAddress,:mask)");
        $array['ipAddress'] = $ip;
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
    function userdb_get_IP(){
        $db = new Dbconnect();
        $dbc=$db->connect();
        $rs=$dbc->prepare("SELECT * FROM useripdb_blacklist WHERE `mask`=0 ORDER BY num ");
        $rs->execute();
        $result = $rs->fetchAll();
        return $result;
    }
    function cidr_match($ip, $range)
    {
        list ($subnet, $bits) = explode('/', $range);
        if ($bits === null) {
            $bits = 32;
        }
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
        return ($ip & $mask) == $subnet;
    }
    function userdb_IP_match($range){
        $IPs = UserDB::userdb_get_IP();
        $ip_list = Array();
        foreach ($IPs as $ip){
            if($ip['mask']==0){
                $result = UserDB::cidr_match($ip['ipAddress'], $range);
                if ($result){
                    array_push($ip_list, $ip['ipAddress']);
                }
            }
        }
        return $ip_list;
    }
    function userdb_CIDR_match($ipAddress,$mask){
        $IPs = UserDB::userdb_get();
        foreach ($IPs as $ip){
            if($ip['mask']==$mask && $ip['ipAddress']==$ipAddress){
                return true;
            }
        }
        return false;
    }
}
?>