<?php
if(!preg_match("/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(\/([0-9]{1,2}))?$/", $_POST['ip_cidr'])){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('格式錯誤！');
    window.location.href='../index.php';
    </script>");
}



$str = explode("/",$_POST['ip_cidr']);

$ip = $str[0];
if(count($str)==2){
    $mask=$str[1];
}else{
    $mask=0;
}

include_once ("../lib/AbuseIPDB.php");
include_once ("../lib/UserDB.php");
$userdb = new UserDB();
$abuse = new AbuseIPDB();
//$json = $abuse->abuseipdb_check_CIDR2($_POST['ip_cidr']);
if($mask==0){
    $ip_check = $abuse->abuseipdb_check_IP($_POST['ip_cidr']);
    if($ip_check==100) {
        echo $_POST['ip_cidr']." is in Abuse blacklist!";
    }else if($ip_check>0 &&$ip_check<100) {
        echo $_POST['ip_cidr']." is in Abuse blacklist, and its 'ConfidenceScore' :". $ip_check;
    }else if($ip_check==0){
        echo $_POST['ip_cidr']." is not in Abuse blacklist.";
    }
}else{
    $ip_list = $abuse->abuseipdb_check_CIDR($_POST['ip_cidr']);
    foreach ($ip_list as $item){
        echo "IP: ".$item[0].", ConfidenceScore: ".$item[1]."<br><br>";
    }
}


$r = $userdb-> userdb_insert($ip,$mask);



?>