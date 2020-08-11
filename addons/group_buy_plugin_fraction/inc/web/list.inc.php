<?php
header("Content-type:text/html;charset=utf-8");
global $_W,$_GPC;
$do = $_GPC['do'];
$op = empty($_GPC['op']) ? 'index' : $_GPC['op'];

$data = json_decode($_POST['name']);

$data = $this->list_info(get_object_vars($data));
//echo '<pre>';var_dump(htmlspecialchars($data));exit;

echo json_encode($data);exit;

include $this->template('web/'.$do.'/'.$op);
?>