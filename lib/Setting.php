<?php
include_once(dirname(__FILE__) . '/DBconnect.php');
class Setting
{
    function get_setting()
    {
        $db = new dbconnect();
        $dbc = $db->connect();
        $rs = $dbc->prepare('SELECT * FROM setting');
        $rs->execute();
        $result = $rs->fetch();
        return $result;
    }
    function update_abuseipdb_TotalIP($cnt){
        $db = new dbconnect();
        $dbc = $db->connect();
        $rs=$dbc->prepare("UPDATE `setting` SET abuse_LastUpdateTime=current_time(), abuseipdb_TotalIP = :cnt ");
        $rs->bindValue(":cnt", $cnt);

        $rs->execute();
    }
}
?>