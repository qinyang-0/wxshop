<?php
/*
 * 商品管理
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
        $condition = ' and tg.uniacid=:uniacid';
        $params = array(':uniacid' => $_W['uniacid']);
        $taskid = intval($_GPC['taskid']);
        $alltimes = array();

        if (!empty($taskid)) {
            $task = pdo_fetch('select id,title,times from ' . tablename('gpb_shop_seckill_task') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $taskid, ':uniacid' => $_W['uniacid']));

            if (!empty($task)) {
                $condition .= ' and tg.taskid=' . $taskid;
            }
        }

        $roomid = intval($_GPC['roomid']);

        if (!empty($roomid)) {
            $room = pdo_fetch('select id,taskid, title from ' . tablename('gpb_shop_seckill_task_room') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $roomid, ':uniacid' => $_W['uniacid']));

            if (!empty($room)) {
                $condition .= ' and tg.roomid=' . $roomid;

                if (empty($taskid)) {
                    $task = pdo_fetch('select id,title,times from ' . tablename('gpb_shop_seckill_task') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $room['taskid'], ':uniacid' => $_W['uniacid']));

                    if (!empty($task)) {
                        $condition .= ' and tg.taskid=' . $task['id'];
                    }
                }
            }
        }

        if (!empty($task)) {
            $alltimes = explode(',', $task['times']);
        }
        else {
            $i = 0;

            while ($i <= 23) {
                $alltimes[] = $i;
                ++$i;
            }
        }

        if ($_GPC['time'] != '') {
            $condition .= ' and t.time=' . intval($_GPC['time']);
        }

        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);
            $condition .= ' and ( g.g_name  like :keyword or task.title  like :keyword)';
            $params[':keyword'] = '%' . $_GPC['keyword'] . '%';
        }

			$list = pdo_fetchall('select tg.id,tg.goodsid,tg.total, tg.taskid,tg.roomid, tg.timeid, tg.price, g.g_name,g.g_icon, t.time ,task.title as tasktitle, r.title as roomtitle,g.g_has_option,g.g_price 
from ' . tablename('gpb_shop_seckill_task_goods') . ' tg
                  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id
                  left join ' . tablename('gpb_shop_seckill_task_room') . ' r on tg.roomid = r.id
                  left join ' . tablename('gpb_shop_seckill_task_time') . ' t on tg.timeid = t.id
                  left join ' . tablename('gpb_shop_seckill_task') . (' task on tg.taskid =task.id
                  where 1 ' . $condition . '  group by tg.timeid,tg.goodsid order by t.time asc , tg.displayorder asc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
        $redis = $this->redis();

        foreach ($list as &$g) {
            if ($g['hasoption']) {
                $total = 0;
                $count = 0;
                $notpay = 0;
                $options = pdo_fetchall('select tg.id,tg.goodsid,tg.total,tg.optionid,tg.price,g.g_name,g.g_price,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('ewei_shop_seckill_task_goods') . '  tg  left join ' . tablename('ewei_shop_goods') . ' g on tg.goodsid = g.g_id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $g['timeid'], ':taskid' => $g['taskid'], ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
                $price = $options[0]['price'];
                $marketprice = $options[0]['marketprice'];

                foreach ($options as $option) {
                    $total += $option['total'];

                    if ($option['price'] < $price) {
                        $price = $option['price'];
                    }

                    if ($marketprice < $option['marketprice']) {
                        $marketprice = $option['marketprice'];
                    }
                }

                $g['price'] = $price;
                $g['marketprice'] = $marketprice;
                $g['total'] = $total;
                $counts = $this->getSeckillCount($g['taskid'], $g['timeid'], $g['goodsid'], 0);
                $g['count'] = $counts['count'];
                $g['notpay'] = $counts['notpay'];
                $g['percent'] = ceil($g['count'] / (empty($g['total']) ? 1 : $g['total']) * 100);
            }
            else {
                $counts = $this->getSeckillCount($g['taskid'], $g['timeid'], $g['goodsid']);
                $g['count'] = $counts['count'];
                $g['notpay'] = $counts['notpay'];
                $g['percent'] = ceil($g['count'] / (empty($g['total']) ? 1 : $g['total']) * 100);
            }

            $g['thumb'] = tomedia($g['thumb']);
        }

        unset($g);
        $total = count(pdo_fetchall('select tg.id from ' . tablename('gpb_shop_seckill_task_goods') . ' tg
                  left join ' . tablename('gpb_goods') . ' g on tg.goodsid = g.g_id
                  left join ' . tablename('gpb_shop_seckill_task_room') . ' r on tg.roomid = r.id
                  left join ' . tablename('gpb_shop_seckill_task_time') . ' t on tg.timeid = t.id
                  left join ' . tablename('gpb_shop_seckill_task') . (' task on tg.taskid =task.id
                  where 1 ' . $condition . '  group by tg.timeid,tg.goodsid order by t.time asc , tg.displayorder asc '), $params));
        $page = pagination($total, $pindex, $psize);

        break;
    case 'delete':
        //删除
        $id = intval($_GPC['id']);
        $item = pdo_fetch('SELECT *  FROM ' . tablename('gpb_shop_seckill_task_goods') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

        if (!empty($item)) {
            $task = pdo_fetch('select id,title from ' . tablename('gpb_shop_seckill_task') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['taskid'], ':uniacid' => $_W['uniacid']));
            $room = pdo_fetch('select id,title from ' . tablename('gpb_shop_seckill_task') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['roomid'], ':uniacid' => $_W['uniacid']));
            $goods = pdo_fetch('select g_id,g_name from ' . tablename('gpb_goods') . ' where g_id=:id and weid=:uniacid limit 1', array(':id' => $item['goodsid'], ':uniacid' => $_W['uniacid']));
            pdo_delete('gpb_shop_seckill_task_goods', array('taskid' => $item['taskid'], 'timeid' => $item['timeid'], 'goodsid' => $item['goodsid']));
            $this->setTaskCache($task['id']);
        }
        echo json_encode(array('status'=>0,'msg'=>'删除成功','data'=>array()));exit;
        break;

}
include $this -> template('web/' . $do . '/' . $op);
?>