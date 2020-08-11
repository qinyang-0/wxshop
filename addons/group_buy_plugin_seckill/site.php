<?php
/**
 * 团购分销插件
 *
 * @author 麦芒网络-微擎团队
 * @url www.scmmwl.com
 * Date: 2019/1/19
 * Time: 10:23
 */
defined('IN_IA') or exit('Access Denied');
include_once '../addons/group_buy/function.php';
class Group_buy_plugin_seckillModuleSite extends WeModuleSite
{
    private $dis;
    private $config;
    public $menu_lv1;
    public $menu_lv2;
    public $menu_info;
    public $menu_list = 'gpb_menu_list';//菜单权限
    public $now_pid;
    public $redis;

    /**
     * 构造
     */
    public function __construct()
    {
        global $_W, $_GPC;
        $this->weid = $_W['uniacid'];
        //主站菜单
        $this->menu_info = $this->menu_list($_W);
        //获取一级菜单
        $menu = pdo_getall("gpb_distribution_menu", array('deep' => 1, 'pid' => 0, 'status' => 2), "*", '', array('sort asc'));
        //获取二级菜单
        $this->menu_lv2 = $this->get_menu_lv2($menu);
        if (!empty($_GET['pid'])) {
            $this->now_pid = $_GET['pid'];
        }

    }

    /**
     * 主站菜单
     */
    public function menu_list($w)
    {
        if ($w['user']['uid'] == 1) {
            //总账号  显示全部菜单
            $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status =1  order by sort asc");
            if (!empty($info)) {
                foreach ($info as $k => $v) {
                    $data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $v['id'] . " and status =1  order by sort asc");
                    $info[$k]['data'] = $data;
                }
            }
        } else {
            //不是总账号
//			1.判断是否设置了权限的
            $code = pdo_get('gpb_menu', array('uid' => $w['uid']));
            if ($code) {
                //设置了权限   按照权限来显示菜单
                $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status =1  and id in (" . $code['value'] . ") order by sort asc");
                if (!empty($info)) {
                    foreach ($info as $k => $v) {
                        $data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $v['id'] . " and status =1  and id in (" . $code['value'] . ") order by sort asc");
                        $info[$k]['data'] = $data;
                    }
                }
            } else {
                //没有设置权限  显示全部菜单   除开权限设置
                $info = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = 0 and status = 1  order by sort asc");
                if (!empty($info)) {
                    foreach ($info as $k => $v) {
                        $data = pdo_fetchall("select * from " . tablename($this->menu_list) . " where pid = " . $v['id'] . " and status = 1  order by sort asc");
                        $info[$k]['data'] = $data;
                    }
                }
            }
        }
        return $info;
    }

    //获取所有二级分类
    private function get_menu_lv2($menu)
    {
        foreach ($menu as $k => $v) {
            $chil = pdo_getall("gpb_distribution_menu", array('deep' => 2, 'pid' => $v['id'], 'status' => 2), "*", '', array('sort asc'));
            $menu[$k]['chil'] = $chil;
        }
        return $menu;
    }

    public function usedDate($taskid)
    {
        $this->redis = $this->redis();
        if (is_error($this->redis)) {
            return false;
        }
        global $_W;
        $redis_prefix = $this->get_prefix();

        $calendar = $this->redis->hGetAll($redis_prefix . 'calendar');
        if (!(is_array($calendar)) || empty($calendar)) {
            return false;
        }
        foreach ($calendar as $k => $v) {
            if (!(empty($v)) && is_array($v)) {
                if ($v['taskid'] == $taskid) {
                    return $k;
                }
            }
        }
        return false;
    }

    //开启redis
    public function redis()
    {
        global $_W;
        static $redis = NULL;
        if (is_null($redis)) {
//            var_dump($_W);
//            var_dump(!extension_loaded("redis"));exit;
            if (!extension_loaded("redis")) {
                $this->message_info("PHP 未安装 redis 扩展");
//                echo json_encode(array('status'=>0,'msg'=>'PHP 未安装 redis 扩展'));
//                $error_msg = 'PHP 未安装 redis 扩展';
//                include $this->template('test');
                exit;
            }
            if (!isset($_W["config"]["setting"]["redis"])) {
//                echo json_encode(array('status'=>0,'msg'=>'未配置 redis, 请检查 data/config.php 中参数设置'));
                $this->message_info("未配置 redis, 请检查 data/config.php 中参数设置");
//                $error_msg = '未配置 redis, 请检查 data/config.php 中参数设置';
//                include $this->template('test');
                exit;
            }
            $config = $_W["config"]["setting"]["redis"];
            if (empty($config["server"])) {
                $config["server"] = "127.0.0.1";
            }
            if (empty($config["port"])) {
                $config["port"] = "6379";
            }
            $redis_temp = new Redis();
            if ($config["pconnect"]) {
                $connect = $redis_temp->pconnect($config["server"], $config["port"], $config["timeout"]);
            } else {
                $connect = $redis_temp->connect($config["server"], $config["port"], $config["timeout"]);
            }
            if (!$connect) {
//                echo json_encode(array('status'=>0,'msg'=>'redis 连接失败, 请检查 data/config.php 中参数设置'));
                $this->message_info("redis 连接失败, 请检查 data/config.php 中参数设置");
                exit;
            }
            if (!empty($config["requirepass"])) {
                $redis_temp->auth($config["requirepass"]);
            }
            try {
                $ping = $redis_temp->ping();
            } catch (ErrorException $e) {
//                echo json_encode(array('status'=>0,'msg'=>'redis 无法正常工作，请检查 redis 服务'));
                $this->message_info("redis 无法正常工作，请检查 redis 服务");
                exit;
            }
            if ($ping != "+PONG") {
//                echo json_encode(array('status'=>0,'msg'=>'redis 无法正常工作，请检查 redis 服务'));

                $this->message_info("redis 无法正常工作，请检查 redis 服务");
                exit;
            }
            $redis = $redis_temp;
        } else {
            try {
                $ping = $redis->ping();
            } catch (ErrorException $e) {
                $redis = NULL;
                $redis = $this->redis();
                $ping = $redis->ping();
            }
            if ($ping != "+PONG") {
                $redis = NULL;
                $redis =$this->redis();
            }
        }
        return $redis;
    }

    /**
     * 同步提交刷新页面
     */
    public function message_info($msg, $redirect = '', $type = '', $tips = false)
    {
        global $_W, $_GPC;
        if ($redirect == 'refresh') {
            $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
        }
        if ($redirect == 'referer') {
            $redirect = referer();
        }
//        $redirect = check_url_not_outside_link($redirect);
        if ($redirect == '') {
            $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
        } else {
            $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
        }
        if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
            if ($type != 'ajax' && !empty($_GPC['target'])) {
                exit("
	<script type=\"text/javascript\">
		var url = " . (!empty($redirect) ? 'parent.location.href' : "''") . ";
		var modalobj = util.message('" . $msg . "', '', '" . $type . "');
		if (url) {
			modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
		}
	</script>");
            } else {
                $vars = array();
                $vars['message'] = $msg;
                $vars['redirect'] = $redirect;
                $vars['type'] = $type;
                exit(json_encode($vars));
            }
        }
        if (empty($msg) && !empty($redirect)) {
            header('Location: ' . $redirect);
            exit;
        }
        $label = $type;
        if ($type == 'error') {
            $label = 'danger';
        }
        if ($type == 'ajax' || $type == 'sql') {
            $label = 'warning';
        }
//        var_dump($msg);
//        var_dump( $this->template('web/header'));exit;
        if ($tips) {
            if (is_array($msg)) {
                $message_cookie['title'] = 'MYSQL 错误';
                $message_cookie['msg'] = 'php echo cutstr(' . $msg['sql'] . ', 300, 1);';
            } else {
                $message_cookie['title'] = $caption;
                $message_cookie['msg'] = $msg;
            }
            $message_cookie['type'] = $label;
            $message_cookie['redirect'] = $redirect ? $redirect : referer();
            $message_cookie['msg'] = rawurlencode($message_cookie['msg']);

            isetcookie('message', stripslashes(json_encode($message_cookie, JSON_UNESCAPED_UNICODE)));

            if (!empty($message_cookie['redirect'])) {
                header('Location: ' . $message_cookie['redirect']);
            } else {
                include $this->template('web/message/message');
            }
        } else {
            include $this->template('web/message/message');
        }
        exit;
    }

    /*
     * 设置秒杀任务缓存
     * int $id 专题id
     */
    public function setTaskCache($id)
    {
        global $_W;
        $redis = $this->redis();
        if (is_error($redis)) {
            return NULL;
        }

        $redis_prefix = $this->get_prefix();
        $task = pdo_fetch('select * from ' . tablename('gpb_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $id));
        $redis->delete($redis_prefix . 'info_' . $id);
        $redis->hMset($redis_prefix . 'info_' . $id, $task);
        $allrooms = pdo_fetchall('select * from ' . tablename('gpb_shop_seckill_task_room') . ' where taskid=:taskid and enabled=1 and uniacid=:uniacid order by `displayorder` desc', array(':taskid' => $id, ':uniacid' => $_W['uniacid']));
        $redis->delete($redis_prefix . 'rooms_' . $id);

        foreach ($allrooms as $room) {
            $redis->rPush($redis_prefix . 'rooms_' . $id, json_encode($room));
        }

        $redis->delete($redis_prefix . 'times_' . $id);
        $alltimes = pdo_fetchall('select * from ' . tablename('gpb_shop_seckill_task_time') . ' where taskid=:taskid and uniacid=:uniacid order by `time` asc', array(':taskid' => $id, ':uniacid' => $_W['uniacid']));
        $redisgoods = array();

        foreach ($alltimes as &$time) {
            $goods = pdo_fetchall('select * from ' . tablename('gpb_shop_seckill_task_goods') . ' where taskid=:taskid and timeid=:timeid and uniacid=:uniacid order by displayorder asc', array(':taskid' => $id, ':timeid' => $time['id'], ':uniacid' => $_W['uniacid']));

            if (!empty($goods)) {
                if (!isset($redisgoods[$time['time']]) || !is_array($redisgoods[$time['time']])) {
                    $redisgoods['time-' . $time['time']] = array();
                }

                $redis->rPush($redis_prefix . 'times_' . $id, json_encode($time));
                $redisgoods['time-' . $time['time']] = json_encode($goods);
            }
        }

        $redis->delete($redis_prefix . 'goods_' . $id);

        if (!empty($redisgoods)) {
            $redis->hMset($redis_prefix . 'goods_' . $id, $redisgoods);
        }
    }

    /**
     * 获取今天的秒杀任务
     * @return mixed
     */
    public function getTodaySeckill()
    {
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }

        $redis_prefix = $this->get_prefix();
        global $_W;
        $year = date('Y');
        $month = date('m');
        return $redis->hGet($redis_prefix . 'calendar_' . $year . '_' . $month, date('Y-m-d'));
    }

    /**
     * 删除今天的秒杀任务
     * @return mixed
     */
    public function deleteTodaySeckill()
    {
        global $_W;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }

        $redis_prefix = $this->get_prefix();
        $year = date('Y');
        $month = date('m');
        $date = date('Y-m-d');
        $redis->hDel($redis_prefix . 'calendar_' . $year . '_' . $month, $date);
    }

    /*
     * 检查秒杀商品
     * int $taskid 专题id
     * int $roomid 会场id
     * int $goodsids 商品id
     */
    public function checkTaskGoods($taskid, $roomid, $goodsids)
    {
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        if (empty($goodsids)) {
            return true;
        }
        $error = array();
        $times = $this->getTaskTimes($taskid);
        if (!(is_array($times))) {
            return true;
        }
        foreach ($times as $time) {
            $goods = $this->getSeckillGoods($taskid, $time['time'], 'all');
            if (!(is_array($goods))) {
                continue;
            }
            foreach ($goods as $g) {
                if (in_array($g['goodsid'], $goodsids) && ($g['roomid'] != $roomid)) {
                    $room = $this->getRoomInfo($taskid, $g['roomid']);
                    $goodstitle = pdo_fetchcolumn('select g_name from ' . tablename('gpb_goods') . ' where g_id=:id limit 1', array(':id' => $g['goodsid']));
                    $url = $this->createWebUrl('room', array('op' => 'add', 'taskid' => $taskid, 'id' => $room['id']));
                    if (!(isset($error['goods-' . $g['goodsid']]))) {
                        $error['goods-' . $g['goodsid']] = '商品&lt;span class=\'text text-danger\'&gt;【' . $goodstitle . '】&lt;/span&gt;在会场&lt;a href=\'' . $url . '\' target=\'_blank\'&gt;【' . $room['title'] . '】&lt;/a&gt;中的 &lt;span class=\'text text-danger\'&gt;' . $time['time'] . '&lt;/span&gt; 点场已经存在，不能重复添加';
                    }
                }
            }
        }
        if (!(empty($error))) {
            return error(-1, implode('<br/>', $error));
        }
        return true;
    }

    /*
     * 获取秒杀时间段
     * int $taskid 专题id
     */
    public function getTaskTimes($taskid)
    {
        global $_W;
        global $_GPC;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $redis_prefix = $this->get_prefix();
        $times = $redis->lGetRange($redis_prefix . 'times_' . $taskid, 0, -1);
        $alltimes = array();
        if (empty($times)) {
            return false;
        }
        foreach ($times as $time) {
            $time = json_decode($time, true);
            if (is_array($time)) {
                $alltimes[] = $time;
            }
        }
        return $alltimes;
    }

    /*
     * 获取秒杀商品
     * int $taskid 专题id
     * char $time 时间
     * int $goodsid 商品id
     */
    public function getSeckillGoods($taskid, $time, $goodsid)
    {
        global $_W;
        global $_GPC;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $redis_prefix = $this->get_prefix();
        $timegoods = array();
        $goods = $redis->hGetAll($redis_prefix . 'goods_' . $taskid);
        if (empty($goods)) {
            return false;
        }
        $goods = @json_decode($goods['time-' . $time], true);
        if (!(is_array($goods))) {
            return false;
        }
        foreach ($goods as $g) {
            if (!(is_array($g))) {
                return false;
            }
            if (($g['goodsid'] == $goodsid) || ($goodsid == 'all')) {
                $timegoods[] = $g;
            }
        }
        return $timegoods;
    }

    /*
     * 获取会场信息
     * int $taskid 专题id
     * int $roomid 会场id
     */
    public function getRoomInfo($taskid, $roomid)
    {
        global $_W;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $rooms = $this->getRooms($taskid);
        foreach ($rooms as $room) {
            if ($room['id'] == $roomid) {
                return $room;
            }
        }
        return false;
    }

    /*
    * 获取会场信息
    * int $taskid 专题id
    */
    public function getRooms($taskid)
    {
        global $_W;
        global $_GPC;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }
        $redis_prefix = $this->get_prefix();
        $allrooms = array();
        $rooms = $redis->lGetRange($redis_prefix . 'rooms_' . $taskid, 0, -1);
        foreach ($rooms as $room) {
            $room = json_decode($room, true);
            if (is_array($room)) {
                $allrooms[] = $room;
            }
        }
        return $allrooms;
    }

    //获取前缀
    public function get_prefix()
    {
        global $_W;
        return 'group_buy_' . $_W['uniacid'] . '_' . $_W['account']['key'] . '_seckill_';
    }
    /*
     * 获取秒杀计数
     */
    public function getSeckillCount($taskid, $timeid, $goodsid, $optionid = 0, $openid = '')
    {
        global $_W;
        global $_GPC;
        $optionid = (int) $optionid;
        $redis = $this->redis();
        if (is_error($redis)) {
            return false;
        }

        $date = date('Y-m-d');
        $redis_prefix = $this->get_prefix();
        $keys = $redis->keys($redis_prefix . 'queue_' . $date . '_' . $taskid . '_' . $timeid . '_' . $goodsid . '_*');

        if (empty($keys)) {
            return array('count' => 0, 'notpay' => 0, 'selfcount' => 0, 'selfnotpay' => 0, 'selftotalcount' => 0, 'selftotalnotpay' => 0);
        }

        $count = 0;
        $notpay = 0;
        $selfcount = 0;
        $selftotalcount = 0;
        $selfnotpay = 0;
        $selftotalnotpay = 0;

        foreach ($keys as $key) {
            $arr = explode('_', $key);
            $key_optionid = (int) $arr[11];
            $queue = $redis->lGetRange($key, 0, -1);

            foreach ($queue as $data) {
                $data = @json_decode($data, true);

                if (!is_array($data)) {
                    continue;
                }

                if (0 < $optionid && $key_optionid === $optionid) {
                    ++$count;
                }
                else {
                    if ($optionid == 0) {
                        ++$count;
                    }
                }

                if ($data['status'] <= 0) {
                    ++$notpay;
                }

                if (!empty($openid) && $data['openid'] == $openid) {
                    if ($key_optionid == $optionid) {
                        ++$selfcount;
                    }

                    ++$selftotalcount;
                }

                if ($data['status'] <= 0 && !empty($openid) && $data['openid'] == $openid) {
                    if ($key_optionid === $optionid) {
                        ++$selfnotpay;
                    }

                    ++$selftotalnotpay;
                }
            }
        }

        return array('count' => $count, 'notpay' => $notpay, 'selfcount' => $selfcount, 'selfnotpay' => $selfnotpay, 'selftotalcount' => $selftotalcount, 'selftotalnotpay' => $selftotalnotpay);
    }
    /*
     * 获取最后一天
     * int $year 年
     * int $month 月
     */
    function get_last_day($year, $month)
    {
        return date("t", strtotime((string) $year . "-" . $month . " -1"));
    }
    /**
     * redis 错误提示
     */
    function redis_error_msg($msg)
    {

    }
}