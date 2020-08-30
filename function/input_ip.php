<?php
// check CIDR format
if(!preg_match("/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(\/([0-9]{1,2}))?$/", $_POST['ip_cidr'])){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('格式錯誤！');
    window.location.href='../index.php';
    </script>");
}

//store IP & mask
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

?>
    <html lang="zh-TW">
    <head>
        <title>ip_check</title>
    </head>
    <body>
    <h1>IP_check</h1>
    <h2>其他功能</h2>
    <a href="../delete_IP.php">刪除黑名單</a><br><br>
    <a href="../show_IP.php">顯示黑名單</a><br><br>

    <br>
    <h2>輸入黑名單</h2>
    <form method="post" action="input_ip.php" >
        <input type="text" name="ip_cidr" placeholder="請輸入IP(可使用CIDR格式查詢)" required id="ip_cidr">
        <button type="submit">輸入黑名單</button><br><br>
    </form>




<?php
if($mask==0){//INPUT IP
    $ip_check = $abuse->abuseipdb_check_IP($_POST['ip_cidr']);
    echo "IP_check from AbuseIPDB: ".$_POST['ip_cidr']."<br>";
    if($ip_check==100) {
        echo $_POST['ip_cidr']." is in Abuse blacklist!";
    }else if($ip_check>0 &&$ip_check<100) {
        echo $_POST['ip_cidr']." is in Abuse blacklist, and its 'ConfidenceScore' :". $ip_check;
    }else if($ip_check==0){
        echo $_POST['ip_cidr']." is not in Abuse blacklist.";
    }
    echo "<br><br><br>";

    $user_list = $userdb ->userdb_IP_match($_POST['ip_cidr']);
    if($ip_check<>100){
        if(count($user_list)==0){
            $r = $userdb-> userdb_insert($ip,$mask);
            echo $_POST['ip_cidr']." insert into user IP black list.";
        }else{
            echo "This IP already exists in the user IP list: <br>";
            foreach ($user_list as $u){
                echo $u."<br>";
            }
        }
    }


}else{//INPUT CIDR
    $ip_list = $abuse->abuseipdb_check_CIDR($_POST['ip_cidr']);
    echo "IP_check from AbuseIPDB:".$_POST['ip_cidr']."<br>";
    if(count($ip_list)==0){
        echo $_POST['ip_cidr']." is not in Abuse blacklist.";
    }else{
        foreach ($ip_list as $item){
            echo "IP: ".$item[0].", ConfidenceScore: ".$item[1]."<br><br>";
        }
    }

    $check = $userdb ->userdb_cidr_match($ip,$mask);
    if(!$check){
        $r = $userdb-> userdb_insert($ip,$mask);
        echo $_POST['ip_cidr']." insert into user IP black list.";
    }else{
        echo "This CIDR already exists in the user IP list. <br>";
    }
}



?>

    </body>
    </html>
