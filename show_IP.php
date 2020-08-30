<?php
include_once ("./lib/UserDB.php");
include_once ("./lib/AbuseIPDB.php");
$userdb = new UserDB();
$user_black_list = $userdb->userdb_get();

$abuse = new AbuseIPDB();
$abuse_black_list = $abuse -> abuseipdb_get();
?>
<html lang="zh-TW">
<head>
    <title>ip_check</title>
</head>
<body>
<h1>IP_check</h1>

<h2>其他功能</h2>
<a href="index.php">輸入黑名單</a><br><br>
<a href="delete_IP.php">刪除黑名單</a><br><br>

<h2>黑名單列表(含自訂及官方)</h2>

<table style="border: solid 1px black ;display: inline-flex;">
    <tr>
        <td style="border: solid 1px black;">AbuseIPDB</td>
    </tr>
    <tr>
        <td>num</td>
        <td>ip_name</td>
        <td>db type</td>
    </tr>

    <?php
    foreach ($abuse_black_list as $item){
        ?>

        <tr>
            <td><?= $item['num']?></td>
            <td><?= $item['ipAddress']?></td>
            <td>abuse_black_list</td>
        </tr>
        <?php
    }
    ?>


</table>
<table style="border: solid 1px black;display: inline-flex;">
    <tr>
        <td style="border: solid 1px black;">USER</td>
    </tr>
    <tr>
        <td>num</td>
        <td>ip_name</td>
        <td>db type</td>
    </tr>
    <?php
    foreach ($user_black_list as $item){
        ?>
        <tr>
            <td><?= $item['num']?></td>
            <?php
            if($item<>0){
                echo "<td>".$item['ip_name']."/".$item['mask']."</td>";
            }else{
                echo "<td>".$item['ip_name']."</td>";
            }
            ?>
            <td>user_black_list</td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>