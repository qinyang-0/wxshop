<?php


require $_SERVER['DOCUMENT_ROOT'].'/framework/bootstrap.inc.php';

$res = pdo_insert("gpb_print_log",array('send_state'=>1));
sleep(10);
$res = pdo_insert("gpb_print_log",array('send_state'=>1));
?>