<?php
/*
 * 广告管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块

switch($op){
    case 'index':
        //广告列表
        global $_W;
        global $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $condition = ' and uniacid=:uniacid';
        $params = array(':uniacid' => $_W['uniacid']);

        if ($_GPC['enabled'] != '') {
            $condition .= ' and enabled=' . intval($_GPC['enabled']);
        }

        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);
            $condition .= ' and advname  like :keyword';
            $params[':keyword'] = '%' . $_GPC['keyword'] . '%';
        }

        $list = pdo_fetchall('SELECT * FROM ' . tablename('gpb_shop_seckill_adv') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('gpb_shop_seckill_adv') . (' WHERE 1 ' . $condition), $params);
        $page = pagination($total, $pindex, $psize);
        break;

    case 'add':
        $id = intval($_GPC['id']);

        if ($_W['ispost']) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'advname' => trim($_GPC['advname']),
                'link' => trim($_GPC['link']),
                'enabled' => intval($_GPC['enabled']),
                'displayorder' => intval($_GPC['displayorder']),
                'thumb' => trim($_GPC['thumb']));

            if (!empty($id)) {
                pdo_update('gpb_shop_seckill_adv', $data, array('id' => $id));
            }
            else {
                pdo_insert('gpb_shop_seckill_adv', $data);
                $id = pdo_insertid();
            }

            $this->message_info('操作成功', $this->createWebUrl('adv',array('op'=>'index')), 'success');
        }

        $info = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_adv') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
        break;
    case 'delete':
        //删除
        $id = intval($_GPC['id']);
        $item = pdo_fetch('SELECT id,advname FROM ' . tablename('gpb_shop_seckill_adv') . (' WHERE id = \'' . $id . '\'  AND uniacid=') . $_W['uniacid'] . '');
        if (empty($item)) {
            echo json_encode(array('status'=>1,'msg'=>'抱歉，幻灯片不存在或是已经被删除！','data'=>array()));exit;
        }
        pdo_delete('gpb_shop_seckill_adv', array('id' => $id));
        echo json_encode(array('status'=>0,'msg'=>'删除成功','data'=>array()));exit;
        break;

    case 'state':
        //快捷设置
        $id = $_GPC['id'];//商品id
        if(empty($id)){
            echo json_encode(['status'=>1,'msg'=>'请传入幻灯片id','data'=>array()]);exit;
        }
        $val = $_GPC['val'];
//        var_dump($val);exit;
        if(empty($val) && $val!=0){
            echo json_encode(['status'=>1,'msg'=>'请传入修改值','data'=>array()]);exit;
        }
        $res = pdo_update('gpb_shop_seckill_adv',array($_GPC['field']=>$val),array('id'=>$id));
        if($res){
            echo json_encode(['status'=>0,'msg'=>'更新成功','data'=>array()]);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'更新失败','data'=>array()]);exit;
        }
        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>