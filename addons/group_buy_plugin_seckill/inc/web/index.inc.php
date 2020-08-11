<?php
/*
 * 专题管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
//$menu_info = $this->menu_info;
switch($op){
	case 'index':
	    //专题列表
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
            $condition .= ' and title  like :keyword';
            $params[':keyword'] = '%' . $_GPC['keyword'] . '%';
        }

        $list = pdo_fetchall('SELECT * FROM ' . tablename('gpb_shop_seckill_task') . (' WHERE 1 ' . $condition . '  ORDER BY id DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);

        foreach ($list as &$row) {
            $row['roomcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_shop_seckill_task_room') . ' where taskid=:taskid limit 1', array(':taskid' => $row['id']));
            $row['isused'] = $this->usedDate($row['id']);
        }

        unset($row);
        $total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('gpb_shop_seckill_task') . (' WHERE 1 ' . $condition), $params);
        $page = pagination($total, $pindex, $psize);
        $category = pdo_fetchall('select id ,`name` from ' . tablename('gpb_shop_seckill_category') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']), 'id');
        break;
    case 'add':
        //修改新增
        $redis = $this->redis;
//        var_dump($item['id']);
//        var_dump($redis);var_dump($_POST);exit;
        if($_GPC['submit'] == '提交'){
            $allgoods = array();
            $alltimes = $_GPC['times'];
            if (!is_array($alltimes) || empty($alltimes)) {
                $this->message_info('未设置任何秒杀点');
            }
            $taskdata = array(
                'title' => trim($_GPC['titles']),
                'enabled' => intval($_GPC['enabled']),
                'cateid' => intval($_GPC['cateid']),
                'tag' => trim($_GPC['tag']),
                'page_title' => trim($_GPC['page_title']),
                'share_title' => trim($_GPC['share_title']),
                'share_desc' => trim($_GPC['share_desc']),
                'share_icon' => trim($_GPC['share_icon']),
                'uniacid' => $_W['uniacid'],
                'closesec' => intval($_GPC['closesec']),
                'times' => implode(',', $alltimes),
                'overtimes' => intval($_GPC['overtimes']),//
                'oldshow' => intval($_GPC['oldshow']),//
            );
            if (!empty($id)) {
                pdo_update('gpb_shop_seckill_task', $taskdata, array('id' => $id));
            }else {
                $taskdata['createtime'] = time();
                pdo_insert('gpb_shop_seckill_task', $taskdata);
                $id = pdo_insertid();
                $taskdata['id'] = $id;
            }

            $notimes = array();
            $i = 0;

            while ($i <= 23) {
                if (!in_array($i, $alltimes)) {
                    $notimes[] = $i;
                }
                ++$i;
            }

            foreach ($alltimes as $i) {
                $time = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task_time') . ' where taskid=:taskid and `time`=:time limit 1', array(':taskid' => $id, ':time' => $i));
                if (empty($time)) {
                    $time = array('uniacid' => $_W['uniacid'], 'taskid' => $id, 'time' => $i);
                    pdo_insert('gpb_shop_seckill_task_time', $time);
                }
            }

            if (!empty($notimes)) {
                foreach ($notimes as $i) {
                    $time = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task_time') . ' where taskid=:taskid and `time`=:time limit 1', array(':taskid' => $id, ':time' => $i));
                    pdo_delete('gpb_shop_seckill_task_time', array('id' => $time['id']));
                    pdo_delete('gpb_shop_seckill_task_goods', array('taskid' => $id, 'timeid' => $time['id']));
                }
            }

            $this->setTaskCache($id);

            $this->message_info('操作成功', $this->createWebUrl('index',array('op'=>'index')), 'success');
        }else{
            if($id){
                $info = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

                $alltimes = array();
                $times = array();

                if (!empty($info)) {
                    $alltimes = explode(',', $info['times']);
                    $times = pdo_fetchall('select * from ' . tablename('gpb_shop_seckill_task_time') . ' where taskid=:taskid and uniacid=:uniacid', array(':taskid' => $info['id'], ':uniacid' => $_W['uniacid']), 'time');

                    foreach ($times as &$t) {
                        $sql = 'select tg.id,tg.goodsid, tg.price as packageprice, tg.maxbuy, g.g_name,g.g_icon,g.g_has_option,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('gpb_shop_seckill_task_goods') . ' tg  
                  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id 
                  where tg.taskid=:taskid and tg.timeid=:timeid and tg.uniacid=:uniacid  group by tg.goodsid order by tg.displayorder asc ';
                        $goods = pdo_fetchall($sql, array(':taskid' => $info['id'], ':uniacid' => $_W['uniacid'], ':timeid' => $t['id']), 'time');

                        foreach ($goods as &$g) {
                            $options = array();

                            if ($g['hasoption']) {
                                $g['optiontitle'] = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price as packageprice,tg.maxbuy,g.g_name,g.g_price,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('gpb_shop_seckill_task_goods') . '  tg  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $t['id'], ':taskid' => $info['id'], ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));

                                foreach ($g['optiontitle'] as $go) {
                                    $options[] = $go['optionid'];
                                }
                            }

                            $g['option'] = implode(',', $options);
                        }

                        unset($g);
                        $t['goods'] = $goods;
                    }

                    unset($t);
                }
            }
            $category = pdo_fetchall('select * from ' . tablename('gpb_shop_seckill_category') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']), 'id');
        }
        break;
    case 'state':
        //快捷设置
        $id = $_GPC['id'];//商品id
        if(empty($id)){
            echo json_encode(['status'=>1,'msg'=>'请传入专题id','data'=>array()]);exit;
        }
        $val = $_GPC['val'];
//        var_dump($val);exit;
        if(empty($val) && $val!=0){
            echo json_encode(['status'=>1,'msg'=>'请传入修改值','data'=>array()]);exit;
        }
        $res = pdo_update('gpb_shop_seckill_task',array($_GPC['field']=>$val),array('id'=>$id));
        if($res){
            echo json_encode(['status'=>0,'msg'=>'更新成功','data'=>array()]);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'更新失败','data'=>array()]);exit;
        }
        break;

    case 'delete':
        //删除
        if (empty($id)) {
            $id = is_array($_GPC['id']) ? implode(',', $_GPC['id']) : 0;
        }

        $items = pdo_fetchall('SELECT id,title FROM ' . tablename('gpb_shop_seckill_task') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_delete('gpb_shop_seckill_task', array('id' => $item['id']));
            pdo_delete('gpb_shop_seckill_task_time', array('taskid' => $item['id']));
            pdo_delete('gpb_shop_seckill_task_goods', array('taskid' => $item['id']));
            $this->setTaskCache($item['id']);
            $taskid = $this->getTodaySeckill();

            if ($taskid == $id) {
                $this->deleteTodaySeckill();
            }
        }
        $this->message_info('删除成功', $this->createWebUrl('index',array('op'=>'index')), 'success');
        break;

}
include $this -> template('web/' . $do . '/' . $op);
?>