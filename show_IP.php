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
    <script>
        function switch_table(){
            var all = document.getElementById("all_table");
            var a = document.getElementById("Abuse_table");
            var u = document.getElementById("user_table");
            if (all.style.display !== 'none') {
                all.style.display = 'none';
                a.style.display = 'inline-flex';
                u.style.display = 'inline-flex';
            }
            else {
                all.style.display = 'inline-flex';
                a.style.display = 'none';
                u.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<h1>IP_check</h1>

<h2>其他功能</h2>
<a href="index.php">輸入黑名單</a><br><br>
<a href="delete_IP.php">刪除黑名單</a><br><br>

<h2>黑名單列表(含自訂及官方)</h2>
<button onclick="switch_table()">切換顯示(全部/分開)</button><br>

<table id="all_table" style="border: solid 1px black ;display: inline-flex;">
    <tr>
        <td style="border: solid 1px black;">All IP(include AbuseIPDB & user)</td>
    </tr>
    <tr>
        <td style="width: 150px">ipAddress(/mask)</td>
        <td>db_type</td>
    </tr>

    <?php
    $list = array();
    foreach ($user_black_list as $item){
        $ipbits = ip2long($item['ipAddress']);
        array_push($list,[$ipbits,$item['ipAddress'],$item['mask'],"user"]);
    }
    foreach ($abuse_black_list as $item){
        $ipbits = ip2long($item['ipAddress']);
        array_push($list,[$ipbits,$item['ipAddress'],$item['abuseConfidenceScore'],"abuse"]);
    }

    $listArrayObject = new ArrayObject($list);
    $listArrayObject->asort();
    foreach ($listArrayObject as $item){
        if($item['3']=="user" && $item['2']<>0){
            $item['1']= $item['1']."/".$item['2'];
        }
        ?>
        <tr>
            <td><?= $item['1'] ?></td>
            <td><?= $item['3']?></td>
        </tr>
        <?php
    }
    ?>


</table>

<table id="Abuse_table" style="border: solid 1px black ;display: none;">
    <tr>
        <td style="border: solid 1px black;">AbuseIPDB</td>
    </tr>
    <tr>
        <td>num</td>
        <td>ipAddress</td>
    </tr>

    <?php
    foreach ($abuse_black_list as $item){
        ?>

        <tr>
            <td><?= $item['num']?></td>
            <td><?= $item['ipAddress']?></td>
        </tr>
        <?php
    }
    ?>


</table>
<table id="user_table"  style="border: solid 1px black;display: none;">
    <tr>
        <td style="border: solid 1px black;">USER</td>
    </tr>
    <tr>
        <td>num</td>
        <td>ipAddress</td>
    </tr>
    <?php
    foreach ($user_black_list as $item){
        ?>
        <tr>
            <td><?= $item['num']?></td>
            <?php
            if($item['mask']<>0){
                echo "<td>".$item['ipAddress']."/".$item['mask']."</td>";
            }else{
                echo "<td>".$item['ipAddress']."</td>";
            }
            ?>
        </tr>
        <?php
    }
    ?>
</table>

</body>
</html>