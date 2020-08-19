<?php
include_once ("./lib/UserDB.php");
$userdb = new UserDB();
$user_black_list = $userdb->userdb_get();
//print_r($user_black_list);
?>
<html lang="zh-TW">
<head>
    <title>ip_check</title>
</head>
<body>
<h1>IP_check</h1>
<h2>使用者自訂黑名單</h2>
<table style="border: solid 1px black">
    <tr>
        <td>num</td>
        <td>ip_name</td>
        <td>delete IP</td>
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
            <td><button onclick="window.location.href='function/delete_ip.php?num=<?=$item['num']?>'">刪除</button></td>
        </tr>
        <?php
    }
    ?>
</table>

<a href="index.php">輸入黑名單</a><br><br>
<a href="show_IP.php">顯示黑名單</a><br><br>

</body>