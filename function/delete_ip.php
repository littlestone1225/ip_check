<?php
include_once ("../lib/UserDB.php");
$userdb = new UserDB();

$num = $_GET['num'];
$r = $userdb -> userdb_delete($num);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('刪除成功！');
    window.location.href='../delete_ip.php';
    </script>");

?>