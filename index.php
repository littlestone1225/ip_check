<?php
include_once("./lib/Setting.php");
include_once("./lib/AbuseIPDB.php");
$setting = new Setting();
$conf = $setting->get_setting();
$now = time();

// Weekly update AbuseIPDB
if($conf["abuseipdb_TotalIP"]=="0" || (($now - strtotime($conf["abuse_LastUpdateTime"]))/3600/24)>7){
    $abuse = new AbuseIPDB();
    $json = $abuse->abuseipdb_download();
    //$json = file_get_contents('./ipaddr.json');
    $data = json_decode($json,true);
    $cnt = $abuse->abuseipdb_update($data['data']);
    $setting->update_abuseipdb_TotalIP($cnt);
}
?>
<html lang="zh-TW">
<head>
    <title>ip_check</title>
</head>
<body>
<h1>IP_check</h1>
<h2>其他功能</h2>
<a href="delete_IP.php">刪除黑名單</a><br><br>
<a href="show_IP.php">顯示黑名單</a><br><br>

<form method="post" action="./function/input_ip.php" >
    <input type="text" name="ip_cidr" placeholder="請輸入IP(可使用CIDR格式查詢)" required id="ip_cidr">
    <button type="submit">輸入黑名單</button><br><br>
</form>

</body>
</html>