<?php
/*
 * 会场管理
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
        //专题列表
        global $_W;
        global $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $condition = ' and r.uniacid=:uniacid';
        $params = array(':uniacid' => $_W['uniacid']);
        $taskid = intval($_GPC['taskid']);

        if (!empty($taskid)) {
            $task = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $taskid));

            if (!empty($task)) {
                $condition .= '  and r.taskid=' . $taskid;
            }
        }

        if ($_GPC['enabled'] != '') {
            $condition .= ' and r.enabled=' . intval($_GPC['enabled']);
        }

        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);
            $condition .= ' and ( r.title  like :keyword or t.title like :keyword)';
            $params[':keyword'] = '%' . $_GPC['keyword'] . '%';
        }

        $list = pdo_fetchall('SELECT r.*, t.title as task_title FROM ' . tablename('gpb_shop_seckill_task_room') . ' r left join ' . tablename('gpb_shop_seckill_task') . (' t  on r.taskid = t.id WHERE 1 ' . $condition . '  ORDER BY r.displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
        foreach ($list as &$row) {
            $times = pdo_fetchall('select id, time from ' . tablename('gpb_shop_seckill_task_time') . ' where taskid=:taskid and uniacid=:uniacid ', array(':taskid' => $row['taskid'], ':uniacid' => $_W['uniacid']));

            foreach ($times as &$time) {
                $time['goodscount'] = pdo_fetchcolumn('select count(DISTINCT  goodsid)  from ' . tablename('gpb_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and  timeid=:timeid and uniacid=:uniacid ', array(':taskid' => $row['taskid'], ':roomid' => $row['id'], ':uniacid' => $_W['uniacid'], ':timeid' => $time['id']));
            }

            unset($time);
            $row['times'] = $times;
        }

        unset($row);
        $total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('gpb_shop_seckill_task_room') . ' r left join ' . tablename('gpb_shop_seckill_task') . (' t  on r.taskid = t.id  WHERE 1 ' . $condition), $params);
        $page = pagination($total, $pindex, $psize);
//        var_dump($list);exit;
        break;
    case 'add':
        //修改新增
        $roomid = intval($_GPC['id']);
        $taskid = intval($_GPC['taskid']);
//        if (empty($taskid)) {
//            $this->message('未选择专题', webUrl('seckill/task'), 'error');
//        }

        $task = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $taskid));

//        if (empty($task)) {
//            $this->message('未选择专题', webUrl('seckill/task'), 'error');
//        }

        $times = pdo_fetchall('select * from ' . tablename('gpb_shop_seckill_task_time') . ' where taskid=:taskid order by `time` asc ', array(':taskid' => $taskid));
        $redis = $this->redis();
//        var_dump($redis);exit();
        if ($_GPC['submit'] == '提交') {
            $allgoods = array();
            $roomdata = array(
                'title' => trim($_GPC['title']),
                'enabled' => intval($_GPC['enabled']),
                'page_title' => trim($_GPC['page_title']),
                'share_title' => trim($_GPC['share_title']),
                'share_desc' => trim($_GPC['share_desc']),
                'share_icon' => trim($_GPC['share_icon']),
                'uniacid' => $_W['uniacid'],
                'oldshow' => intval($_GPC['oldshow']),
                'tag' => trim($_GPC['tag']),
                'taskid' => $taskid,
                'diypage' => intval($_GPC['diypage'])
            );

            if (!empty($roomid)) {
                pdo_update('gpb_shop_seckill_task_room', $roomdata, array('id' => $roomid));
				pdo_update("gpb_shop_seckill_task",array('oldshow'=>intval($_GPC['oldshow'])),array('id' => $taskid));
            } else {
                $roomdata['createtime'] = time();
                $res = pdo_insert('gpb_shop_seckill_task_room', $roomdata);
                if(empty($res)){
                	echo '<pre>';
					var_dump($res);
					pdo_debug();
					exit;
                }else{
                	$roomid = pdo_insertid();
                }
				pdo_update("gpb_shop_seckill_task",array('oldshow'=>intval($_GPC['oldshow'])),array('id' => $taskid));
            }
			if(empty($roomid)){
				$this->message_info('请先添加会场');
			}
			
			
            foreach ($times as $time) {
                $timeid = $time['id'];
                $goodsids = array();
                $open = trim($_GPC['timeopen'][$time['time']]);
//                var_dump($time['time']);var_dump($open);exit;
                if (empty($open)) {
                    pdo_delete('gpb_shop_seckill_task_goods', array('taskid' => $taskid, 'roomid' => $roomid, 'timeid' => $time['id']));
                }
                else {
                    $timegoods = $_GPC['time-' . $time['time'] . 'packagegoods'];

                    if (empty($timegoods)) {
                        $this->message_info('未添加任何商品');
                    }

                    if (is_array($timegoods)) {
                        $goodsids = array();

                        foreach ($timegoods as $k => $v) {
                            $count = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid  and goodsid=:goodsid  limit 1', array(':taskid' => $taskid, ':roomid' => $roomid, ':goodsid' => $k));

                            if ($count <= 0) {
                                $goodsids[] = $k;
                            }

                            if (empty($v)) {
                                $prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packgoods' . $k]));

                                if (empty($prices[4])) {
                                    $goods = pdo_fetch('select g_name from ' . tablename('gpb_goods') . ' where g_id=:id and weid=:uniacid limit 1', array(':id' => $k, ':uniacid' => $_W['uniacid']));
//                                    $this->message_info('商品' . $goods['g_name'] . '库存不能为0！');
                                }
                            }else {
                                $optionids = explode(',', $v);
                                $optionids = array_filter($optionids);

                                foreach ($optionids as $option) {
                                    $prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packagegoodsoption' . $option]));

                                    if (empty($prices[4])) {
                                        $goods = pdo_fetch('select g_name from ' . tablename('gpb_goods') . ' where g_id=:id and weid=:uniacid limit 1', array(':id' => $k, ':uniacid' => $_W['uniacid']));
//                                        $this->message_info('商品' . $goods['g_name'] . '库存不能为0！');
                                    }
                                }
                            }
                        }

                        $check = $this->checkTaskGoods($taskid, $roomid, $goodsids);

                        if (is_error($check)) {
                            $this->message_info($check['message']);
                        }

                        $displayorder = 0;
//                        var_dump($timegoods);exit;
                        foreach ($timegoods as $k => $v) {
                            if (empty($v)) {
                                $prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packgoods' . $k]));

                                $data = array(
                                    'displayorder' => $displayorder,
                                    'uniacid' => $_W['uniacid'],
                                    'taskid' => $taskid,
                                    'roomid' => $roomid,
                                    'timeid' => $timeid,
                                    'goodsid' => $k,
                                    'price' => $prices[0],
                                    'commission1' => $prices[1],
                                    'commission2' => $prices[2],
                                    'commission3' => $prices[3],
                                    'total' => $prices[4],
                                    'maxbuy' => $prices[5],
                                    'totalmaxbuy' => $prices[5]
                                );
                                $goods = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid and goodsid=:goodsid  limit 1', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid, ':goodsid' => $k));

                                if (empty($goods)) {
                                    pdo_insert('gpb_shop_seckill_task_goods', $data);
                                    $goodsids[] = pdo_insertid();
                                }
                                else {
                                    pdo_update('gpb_shop_seckill_task_goods', $data, array('id' => $goods['id']));
                                    $goodsids[] = $goods['id'];
                                }

                                $data['time'] = $time['time'];
                                $allgoods[] = $data;
                            }else {
                                //规格设置
                                $v = trim($v,',');
                                $optionids = explode(',', $v);
                                $optionids = array_filter($optionids);

                                foreach ($optionids as $option) {
                                    $prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packagegoodsoption' . $option]));
                                    $data = array(
                                        'displayorder' => $displayorder,
                                        'uniacid' => $_W['uniacid'],
                                        'taskid' => $taskid,
                                        'roomid' => $roomid,
                                        'timeid' => $timeid,
                                        'goodsid' => $k,
                                        'optionid' => $option,
                                        'price' => $prices[0],
                                        'commission1' => $prices[1],
                                        'commission2' => $prices[2],
                                        'commission3' => $prices[3],
                                        'total' => $prices[4],
                                        'maxbuy' => $prices[5],
                                        'totalmaxbuy' => $prices[6]
                                    );
//									echo '<pre>';print_r($data);echo '<br/>****************************<br/>';
                                    $goods = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid and goodsid=:goodsid and optionid=:optionid limit 1', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid, ':goodsid' => $k, ':optionid' => $option));

                                    if (empty($goods)) {
                                        pdo_insert('gpb_shop_seckill_task_goods', $data);
                                        $goodsids[] = pdo_insertid();
                                    }
                                    else {
                                        pdo_update('gpb_shop_seckill_task_goods', $data, array('id' => $goods['id']));
                                        $goodsids[] = $goods['id'];
                                    }

                                    $data['time'] = $time['time'];
                                    $allgoods[] = $data;
                                }
                            }

                            ++$displayorder;
                        }
                    }

                    if (empty($goodsids)) {
                        pdo_query('delete from ' . tablename('gpb_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid ', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid));
                    }
                    else {
                        pdo_query('delete from ' . tablename('gpb_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid  and id not in (' . implode(',', $goodsids) . ')', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid));
                    }
                }
            }

            $this->setTaskCache($taskid);
//			exit('1');
            $this->message_info('操作成功', $this->createWebUrl('room',array('op'=>'index')), 'success');
        }else{
            $info = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task_room') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $roomid, ':uniacid' => $_W['uniacid']));
            $roomtimes = array();
//var_dump($times);exit();
            if (!empty($info)) {
                foreach ($times as &$t) {
                    $sql = 'select tg.id,tg.goodsid, tg.price as packageprice, tg.maxbuy,tg.totalmaxbuy, g.g_name,g.g_icon,g.g_has_option,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('gpb_shop_seckill_task_goods') . ' tg  
                  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id 
                  where tg.taskid=:taskid and tg.roomid=:roomid and  tg.timeid=:timeid and tg.uniacid=:uniacid  group by tg.goodsid order by tg.displayorder asc ';
                    $goods = pdo_fetchall($sql, array(':taskid' => $info['taskid'], ':roomid' => $roomid, ':timeid' => $t['id'], ':uniacid' => $_W['uniacid']), 'time');
//var_dump($goods);
                    foreach ($goods as &$g) {
                        $options = array();
                        $g['hasoption'] = $g['g_has_option'];
//                        var_dump($g['hasoption']);
                        if ($g['hasoption']) {

                            $g['optiontitle'] = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price as packageprice,tg.maxbuy,tg.totalmaxbuy, g.g_name,g.g_price,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('gpb_shop_seckill_task_goods') . ' as tg  left join ' . tablename('gpb_goods') . ' as g on tg.goodsid = g.g_id  where tg.roomid=:roomid and tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $t['id'], ':taskid' => $info['taskid'], ':roomid' => $roomid, ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
//                            var_dump( $g['optiontitle'] );
                            foreach ($g['optiontitle'] as $go) {
                                $options[] = $go['optionid'];
                            }
                        }

                        $g['option'] = implode(',', $options);
                    }

                    unset($g);
                    $t['goods'] = $goods;
//                    var_dump($goods);
                    if (!empty($goods)) {
                        $roomtimes[] = $t['time'];
                    }
                }

                unset($t);
            }
            $pages = false;
//            if (p('diypage')) {
//                $pages = p('diypage')->getPageList('allpage', ' and type=7 ');
//                $pages = $pages['list'];
//            }
        }
        break;
    case 'get_goods':
        $time = intval($_GPC['time']);
        $uniacid = intval($_W['uniacid']);
        $kwd = trim($_GPC['keyword']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 5;
        $params = array();
        $params[':uniacid'] = $uniacid;
        $condition = ' and g.g_is_online=1 and g.g_is_del=1 and (g.`type`=1 OR g.`type` IS NULL)  and g.weid=:uniacid';

        if (!empty($kwd)) {
            $condition .= ' AND (`g_name` LIKE :keywords )';
            $params[':keywords'] = '%' . $kwd . '%';
        }

        $info = pdo_fetchall('SELECT *
            FROM ' . tablename('gpb_goods') . ' as g
            left join '.tablename('gpb_goods_stock').' as s on s.goods_id = g.g_id'.('
            WHERE 1 ' . $condition . ' ORDER BY g_order DESC,g_id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('gpb_goods') . ' as g WHERE 1 ' . $condition . ' ', $params);
        $page = pagination($total, $pindex, $psize);
        foreach ($info as &$v){
            $v['g_icon']= tomedia($v['g_icon']);
        }
        break;
    case 'get_goods_option':
        $uniacid = intval($_W['uniacid']);
        $goodsid = intval($_GPC['goodsid']);
        $time = intval($_GPC['time']);
        $pid = intval($_GPC['pid']);
        $selectorid = trim($_GPC['selectorid']);
        $hasoption = 0;
        $params = array(':uniacid' => $uniacid, ':goodsid' => $goodsid);
        $commission_level = 0;
//        if (p('commission')) {
//            $data = m('common')->getPluginset('commission');
//            $commission_level = $data['level'];
//        }
        $goods = pdo_fetch('select * from ' . tablename('gpb_goods') . ' as g left join '.tablename('gpb_goods_stock').' as s on s.goods_id = g.g_id where g.weid = :uniacid and g_id = :goodsid ', $params);

        $stock = $goods['num'];
//        if (!empty($pid)) {
//            $packgoods = pdo_fetch('select id,title,packageprice,commission1,commission2,commission3,`option`,goodsid from ' . tablename('gpb_package_goods') . '
//                        where pid = ' . $pid . ' and uniacid = :uniacid and goodsid = :goodsid ', $params);
//        }else {
            $packgoods = array('title' => $goods['g_name'], 'marketprice' => $goods['g_price'], 'packageprice' => 0, 'commission1' => 0, 'commission2' => 0, 'commission3' => 0);
//        }
//        var_dump($goods['g_has_option']);exit;
        if ($goods['g_has_option']) {
            $hasoption = 1;
            $option = array();
            $option = pdo_fetchall('SELECT * FROM ' . tablename('gpb_goods_option') . '
            WHERE weid = :uniacid and ggo_g_id = :goodsid  ORDER BY ggo_order DESC,ggo_id DESC ', $params);
//            $package_option = pdo_fetchall('SELECT * FROM ' . tablename('gpb_package_goods_option') . '
//            WHERE uniacid = :uniacid and goodsid = :goodsid  and pid = ' . $pid . ' ', $params);
            $package_option = pdo_fetchall('SELECT * FROM '.tablename('gpb_shop_seckill_task_goods').'  WHERE uniacid = :uniacid and goodsid = :goodsid ', $params);
            foreach ($option as $key => $value) {
                foreach ($package_option as $k => $val) {
                    if ($value['ggo_id'] == $val['optionid']) {
                        $option[$key]['packageprice'] = $val['price'];
                        $option[$key]['commission1'] = $val['commission1'];
                        $option[$key]['commission2'] = $val['commission2'];
                        $option[$key]['commission3'] = $val['commission3'];
                        $option[$key]['total'] = $val['total'];
                        $option[$key]['maxbuy'] = $val['maxbuy'];
                        $option[$key]['totalmaxbuy'] = $val['totalmaxbuy'];
                        $option[$key]['optionid'] = $val['optionid'];
						$option[$key]['total'] = $val['total'];
                        break;
                    }else{
                        $option[$key]['total'] = $value['ggo_stock'];
                    }
                }

                if (strpos($packgoods['option'], $value['ggo_id']) !== false) {
                    $option[$key]['isoption'] = 1;
                }
            }
        }else {
            $packgoods['marketprice'] = $goods['g_price'];
        }
        break;

    case "option":
        $uniacid = intval($_W['uniacid']);
        $options = is_array($_GPC['option']) ? implode(',', array_filter($_GPC['option'])) : 0;
        $options = intval($options);
        $option = pdo_fetch('SELECT ggo_id,ggo_title FROM ' . tablename('gpb_goods_option') . '
            WHERE weid = ' . $uniacid . ' and ggo_id = ' . $options . '  ORDER BY ggo_order DESC,ggo_id DESC LIMIT 1');
        echo json_encode(['status'=>0,'msg'=>'成功','data'=>array('data'=>$option)]);exit;
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
        $res = pdo_update('gpb_shop_seckill_task_room',array($_GPC['field']=>$val),array('id'=>$id));
        if($res){
            echo json_encode(['status'=>0,'msg'=>'更新成功','data'=>array()]);exit;
        }else{
            echo json_encode(['status'=>1,'msg'=>'更新失败','data'=>array()]);exit;
        }
        break;

    case 'delete':
        //删除
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }
        $items = pdo_fetchall('SELECT id,taskid, title FROM ' . tablename('gpb_shop_seckill_task_room') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
//        var_dump($items);exit;
        foreach ($items as $item) {
            pdo_delete('gpb_shop_seckill_task_room', array('id' => $item['id']));
            pdo_delete('gpb_shop_seckill_task_goods', array('taskid' => $item['taskid'], 'roomid' => $item['id']));
            $task = pdo_fetch('select id,title from ' . tablename('gpb_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $item['taskid']));
            $this->setTaskCache($task['id']);
        }
        echo json_encode(array('status'=>0,'msg'=>'删除成功','data'=>array()));exit;
        break;

}
include $this -> template('web/' . $do . '/' . $op);
?>