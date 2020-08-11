<?php
/*
 * 分类管理
 */
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
$in = $_GPC['in'];
$id = $_GPC['id'];//主键id
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$redis = $this->redis();
switch($op){
    case 'index':
        //专题列表
        global $_W;
        global $_GPC;
        $currentyear = date('Y');
        $currentmonth = date('m');
        $years = array();
        $i = 0;

        while ($i <= 10) {
            $years[] = $currentyear + $i;
            ++$i;
        }

        $months = array();
        $i = 1;

        while ($i <= 12) {
            $months[] = $i;
            ++$i;
        }
        break;

    case 'dates' :

        global $_W;
        global $_GPC;
        $redis_prefix = $this->get_prefix();
        $year = trim($_GPC['year']);
        $month = trim($_GPC['month']);
        $day = $this->get_last_day($year, $month);

        if ($month < 10) {
            $month = '0' . (string) $month;
        }

        $calendar = $redis->hGetAll($redis_prefix . 'calendar_' . $year . '_' . $month);

        if (empty($calendar)) {
            $calendar = array();
            $i = 1;

            while ($i <= $day) {
                if ($i < 10) {
                    $i = '0' . $i;
                }

                $calendar[date($year . '-' . $month . '-' . $i)] = false;
                ++$i;
            }
        }else {
            $result = array();
            $i = 1;

            while ($i <= $day) {
                if ($i < 10) {
                    $i = '0' . $i;
                }

                $date = $year . '-' . $month . '-' . $i;
                $result[$date] = false;

                if (isset($calendar[$date])) {
                    $value = trim($calendar[$date]);
                    $result[$date] = false;

                    if (!empty($value)) {
                        $result[$date] = array('taskid' => $value, 'title' => pdo_fetchcolumn('select title from ' . tablename('gpb_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $value)));
                    }
                }

                ++$i;
            }

            $calendar = $result;
        }

        $week = date('w', strtotime(date($year . '-' . $month . '-1')));
        break;

       case 'set':

        global $_W;
        global $_GPC;
        $taskid = intval($_GPC['taskid']);
        $date = trim($_GPC['date']);
        if (empty($taskid) || empty($date)) {
            echo json_encode(['status'=>0,'msg'=>'参数错误']);exit;
//            echo (0, '参数错误');
        }

        $redis_prefix = $this->get_prefix();
        $time = strtotime($date);
        $year = date('Y', $time);
        $month = date('m', $time);
        $task = pdo_fetch('select id ,title from ' . tablename('gpb_shop_seckill_task') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $taskid));

        if (empty($task)) {
            echo json_encode(['status'=>0,'msg'=>'任务未找到']);exit;
//            show_json(0, '任务未找到');
        }

        $redis->hSet($redis_prefix . 'calendar_' . $year . '_' . $month, date('Y-m-d', $time), $taskid);
           echo json_encode(['status'=>1,'msg'=>'成功','data'=>array('taskid' => $task['id'], 'title' => $task['title'])]);exit;
//        show_json(1, array('taskid' => $task['id'], 'title' => $task['title']));
    break;

    case 'delete':
        global $_W;
        global $_GPC;
        $date = trim($_GPC['date']);

        if (empty($date)) {
            echo json_encode(['status'=>0,'msg'=>'参数错误']);exit;
        }

        $time = strtotime($date);
        $year = date('Y', $time);
        $month = date('m', $time);
        $redis_prefix = $this->get_prefix();
        $redis->hDel($redis_prefix . 'calendar_' . $year . '_' . $month, $date);
        echo json_encode(['status'=>1,'msg'=>'']);exit;
    break;

    case 'clear':
        global $_W;
        global $_GPC;
        $year = trim($_GPC['year']);
        $month = trim($_GPC['month']);

        if ($month < 10) {
            $month = '0' . $month;
        }

        $redis_prefix = $this->get_prefix();
        $redis->delete($redis_prefix . 'calendar_' . $year . '_' . $month);
        echo json_encode(['status'=>1,'msg'=>'']);exit;
   break;

    case 'batch_set':
        global $_W;
        global $_GPC;
        $taskid = intval($_GPC['taskid']);
        $year = trim($_GPC['year']);
        $month = trim($_GPC['month']);

        if ($month < 10) {
            $month = '0' . $month;
        }

        $days = $_GPC['days'];
        if (empty($taskid) || empty($year) || empty($month)) {
            echo json_encode(['status'=>0,'msg'=>'参数错误']);exit;

        }

        if (!is_array($days) || empty($days)) {
            echo json_encode(['status'=>0,'msg'=>'参数错误']);exit;
        }

        $task = pdo_fetch('select id ,title from ' . tablename('gpb_shop_seckill_task') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $taskid));

        if (empty($task)) {
            echo json_encode(['status'=>0,'msg'=>'任务未找到']);exit;
        }

        if ($days[0] == 'all') {
            array_shift($days);
        }

        $maxday = $this->get_last_day($year, $month);
        $arr = array();
        $dates = array();
        $i = 1;

        while ($i <= $maxday) {
            if ($i < 10) {
                $i = '0' . $i;
            }

            $date = date($year . '-' . $month . '-' . $i);
            $week = date('w', strtotime($date));

            if ($week == 0) {
                $week = 7;
            }

            if (in_array($week, $days)) {
                $arr[$date] = $taskid;
                $dates[] = $date;
            }

            ++$i;
        }

        $redis_prefix = $this->get_prefix();
        $redis->hMset($redis_prefix . 'calendar_' . $year . '_' . $month, $arr);
        echo json_encode(['status'=>1,'msg'=>'','taskid' => $task['id'], 'title' => $task['title'], 'dates' => implode(',', $dates)]);exit;
//        show_json(1, array('taskid' => $task['id'], 'title' => $task['title'], 'dates' => implode(',', $dates)));
    break;

    case 'batch_delete':
        global $_W;
        global $_GPC;
        $year = trim($_GPC['year']);
        $month = trim($_GPC['month']);

        if ($month < 10) {
            $month = '0' . $month;
        }

        $days = $_GPC['days'];
        if (empty($year) || empty($month)) {
            echo json_encode(['status'=>0,'msg'=>'参数错误']);exit;
        }

        if (!is_array($days) || empty($days)) {
            echo json_encode(['status'=>0,'msg'=>'参数错误']);exit;
        }

        if ($days[0] == 'all') {
            array_shift($days);
        }

        $redis_prefix = $this->get_prefix();
        $calendar = $redis->hGetAll($redis_prefix . 'calendar_' . $year . '_' . $month);

        if (!is_array($calendar)) {
            $calendar = array();
        }

        $maxday = $this->get_last_day($year, $month);
        $dates = array();
        $i = 1;

        while ($i <= $maxday) {
            if ($i < 10) {
                $i = '0' . $i;
            }

            $date = date($year . '-' . $month . '-' . $i);
            $week = date('w', strtotime($date));

            if ($week == 0) {
                $week = 7;
            }

            if (in_array($week, $days)) {
                if (is_array($calendar) && isset($calendar[$date])) {
                    unset($calendar[$date]);
                    $redis->hDel($redis_prefix . 'calendar_' . $year . '_' . $month, $date);
                    $dates[] = $date;
                }
            }

            ++$i;
        }

        if (empty($calendar)) {
            $redis->delete($redis_prefix . 'calendar_' . $year . '_' . $month);
        }
        echo json_encode(['status'=>1,'msg'=>'','dates'=>implode(',', $dates)]);exit;
   break;
    case 'query':
        global $_W;
        global $_GPC;
        $kwd = trim($_GPC['keyword']);
        $params = array();
        $params[':uniacid'] = $_W['uniacid'];
        $condition = ' and uniacid=:uniacid and enabled=1';

        if (!empty($kwd)) {
            $condition .= ' AND `title` LIKE :keyword';
            $params[':keyword'] = '%' . $kwd . '%';
        }

        $ds = pdo_fetchall('SELECT id,title,tag FROM ' . tablename('gpb_shop_seckill_task') . (' WHERE 1 ' . $condition . '  ORDER BY id DESC'), $params);

        foreach ($ds as &$row) {
            $row['roomcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('gpb_shop_seckill_task_room') . ' where taskid=:taskid limit 1', array(':taskid' => $row['id']));
            $row['isused'] = $this->usedDate($row['id']);
        }

        unset($row);
        break;
}
include $this -> template('web/' . $do . '/' . $op);
?>