<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 11:52
 */
//include_once '../addons/group_buy/site.php';
class distribution
{
    //私有变量定义
    private $config;
    private $uid;
    private $weid;
    //配置字段
    public $config_arr = [
        'distribution_state',
        "distribution_leader_parsent",
        'distribution_lv1_parsent',
        'distribution_lv2_parsent',
        'distribution_lv3_parsent',
        'distribution_leader_fixed',
        'distribution_lv1_fixed',
        'distribution_lv2_fixed',
        'distribution_lv3_fixed',
        'distribution_commoned_state',
        'distribution_commoned_condition',
        'distribution_commoned_value',
        'distribution_lv',
        'distribution_type',
        'distribution_isself',
        'distribution_commoned_money',
        'distribution_exa',
        'distribution_cash_comment',
        'distribution_cash_charge',
        'distribution_site_name',
        'distribution_playbill_img',
        'distribution_put_pic',
        'distribution_put_btn',
        'distribution_put_comment',
        'distribution_type_retreat',
        'distribution_site_name_info',
    ];
    //配置显示
    public $config_arr_name = [
        'distribution_state'=>"是否开启分销",
        'distribution_site_name_info'=>"分销-名称自定义",
        "distribution_leader_parsent"=>"自身购买佣金比例(%)",
        'distribution_lv1_parsent'=>"一级佣金比例(%)",
        'distribution_lv2_parsent'=>"二级佣金比例(%)",
        'distribution_lv3_parsent'=>"三级佣金比例(%)",
        'distribution_leader_fixed'=>"自身佣金固定金额(元)",
        'distribution_lv1_fixed'=>"一级佣金固定金额(元)",
        'distribution_lv2_fixed'=>"二级佣金固定金额(元)",
        'distribution_lv3_fixed'=>"三级佣金固定金额(元)",
        'distribution_commoned_state'=>"推荐奖是否开启",
        'distribution_commoned_money'=>"推荐奖金额",
        'distribution_commoned_condition'=>"推荐奖条件",
        'distribution_commoned_value'=>"推荐奖满足条件",
        'distribution_lv'=>"分销等级",
        'distribution_type'=>"分佣类型",
        'distribution_isself'=>"自身是否分佣",
        'distribution_exa'=>'审核设置',
        'distribution_cash_comment'=>'提现说明',
        'distribution_cash_charge'=>'提现手续费',
        'distribution_site_name'=>'后台名称',
        'distribution_playbill_img'=>'分销推广海报背景图',
        'distribution_put_pic'=>"分销申请顶部图片",
        'distribution_put_btn'=>"分销申请按钮",
        'distribution_put_comment'=>"分销申请",
    ];
    //
    public $config_arr_key = [
        'distribution_commoned_condition',
        'distribution_commoned_value',
    ];
    //推荐奖配置键值对
    public $config_commoned_condition_key_value = [
        'num'=>'下级有效交易单数大于等于',
        'all_money'=>'下级交易总金额大于等于',
        'solo_money'=>'下级单笔交易金额大于等于',
        'commoned_times'=>"推荐人数",
    ];
    //ID生成参数
    //开始时间,固定一个小于当前时间的毫秒数即可
    const twepoch =  1474990000000;//2016/9/28 0:0:0
    //机器标识占的位数
    const workerIdBits = 2;
    //数据中心标识占的位数
    const datacenterIdBits = 2;
    //毫秒内自增数点的位数
    const sequenceBits = 3;
    protected $workId = 0;
    protected $datacenterId = 0;
    static $lastTimestamp = -1;
    static $sequence = 0;
    //构造函数
    public function __construct($weid,$uid='')
    {
        $this->uid = $uid;
        $this->weid = $weid;
        $this->getconfig();
        //是否存在视图
        $has_view_table = pdo_tableexists("gpb_user_distribution_log");
        if(!$has_view_table){
//            exit("1");
            $res = $this->create_view_table();
        }
    }
    //获取固定配置值
    public function get_array_value($key){
        return $this->$key;
    }
    //创建视图
    private function create_view_table(){
        $sql = "CREATE
    VIEW ".tablename("gpb_user_distribution_log")."
    AS
(SELECT * FROM ".tablename("gpb_member")." m,".tablename("gpb_order_snapshot")." os where m.m_openid=os.oss_buy_openid)";
        $res = pdo_run($sql);
        return $res;
    }

    //获取配置
    public function getconfig(){

        foreach ($this->config_arr as $k=>$v){
            $this->config[$v] = $this->getkeyvalue("{$v}");
            if($this->config[$v]=='empty'){
//                echo $this->config[$v]."<br/>";
                $this->setkeyvalue($v,'','insert');
            }
        }
        return $this->config;
    }
    //设置配置
    public function setconfig($key='',$value=''){
        return $this->setkeyvalue($key,$value);
    }

    //获取配置表信息
    public function getkeyvalue($key=''){
        if(empty($key)) return false;
        $info = pdo_get("gpb_config","`key`='{$key}' and `weid`='{$this->weid}'");
//        echo "<pre/>";
//        exit(var_dump($info));
        if(empty($info)){
            return 'empty';
        }
        if(strlen($info['value'])>1 && !is_numeric($info['value'])){
            $is_ser = serialize(unserialize($info['value']))==$info['value']?true:false;
        }else{
            $is_ser = false;
        }


        $arr = $is_ser?unserialize($info['value']):(!empty($info['value'])?$info['value']:'');
        return $arr;
    }

    //设置配置表信息
    private function setkeyvalue($key='',$value='',$model='update',$type=8){
        if(empty($key)) return false;
        if(in_array($key,$this->config_arr_key)){
//            echo "<pre/>";
//            exit(var_dump($value));
            $data = [
                "name"=>$this->config_arr_name[$key],
                "type"=>8,
                "weid"=>$this->weid,
                "key"=>$key,
                'status'=>1,
                'value'=>serialize($value),
            ];
        }else{
            $data = [
                "name"=>$this->config_arr_name[$key],
                "type"=>8,
                "weid"=>$this->weid,
                "key"=>$key,
                'status'=>1,
                'value'=>$value,
            ];
        }
        if($model=='insert'){
            $data['time'] = time();
            $res = pdo_insert('gpb_config',$data);
        }else{
            $data['time'] = time();
//            echo "<pre/>";
//            exit(var_dump($data));
            $res = pdo_update('gpb_config',$data,array('weid'=>$this->weid,'key'=>$key));
//            if(!$res){
//                exit;
//            }
        }

        return $res?['status'=>0,"msg"=>"修改成功"]:['status'=>1,"msg"=>"修改失败"];
    }

    /**
     * 获取当前团队信息
     * $user_id int 当前用户id
     * $lv string 返回团队形式 all:上下级所有团队,top:获取上级团队,under:下级团队
     * return $arr array 二维数组,
     */
    public function getteamInfo($user_id=0,$lv='all'){
        if(empty($user_id)){
            $team = pdo_getAll("gpb_distribution_group","leader_id='{$user_id}'");
        }else{
            switch($lv){
                //直属团队
                case "under" :
                    $team = pdo_getAll("gpb_distribution_group","leader_id='{$user_id}'");
                    break;
                case "top":
                    $team = pdo_getAll("gpb_distribution_group","find_in_set('{$user_id}', lv1) or find_in_set('{$user_id}', lv2) or find_in_set('{$user_id}', lv3)");
                    break;
                case "all":
                    $team = pdo_getAll("gpb_distribution_group","find_in_set('{$user_id}', lv1) or find_in_set('{$user_id}', lv2) or find_in_set('{$user_id}', lv3) or find_in_set('{$user_id}', leader_id)");
                    break;
                default :
                    return ['status'=>1,"msg"=>"无此类型团队"];
            }
        }

        return ['status'=>0,"msg"=>"获取成功","data"=>$team];
    }
    /**
     * 团队关系建立
     * $pid int 邀请人id
     * $uid int 被邀请人id
     * return $result array 返回数组 code-0绑定成功 -1绑定失败,进入重新绑定流程
     */
    public function bingteam($uid=0,$pid=0){
        if($uid<1){
            return $this->ReturnArray("用户唯一标识错误");
        }
        //建立分销用户绑定
        $user = [
            'uid'=>$uid,
            'weid'=>$this->weid,
            'check_state'=>1,
            'create_time'=>time(),
            'update_time'=>time(),
            'status'=>1,
        ];
        $user = pdo_get("gpb_distribution_money",$user);
        if(empty($user) && $pid==0){
            return $this->ReturnArray("您还未成为分销用户");
        }
        if($pid==0){
            //是否已是其他人下级
            $group_log = pdo_get("gpb_distribution_group_log",['weid'=>$this->weid,'uid'=>$uid]);
            if(!empty($group_log)){
                //是其他人下级
                $pid = $group_log['pid'];
            }
        }
        if($pid==0){
        	$is_hasteam = pdo_get("gpb_distribution_group",array('leader_id'=>$uid,'weid'=>$this->weid,'status'=>1));
			if($is_hasteam){
				return $this->ReturnArray("绑定成功",0,$is_hasteam);
			}
            //无上级，自己成为leader
            $data = [
                'leader_id'=>$uid,
                'create_time'=>time(),
                'update_time'=>time(),
                'weid'=>$this->weid,
                'status'=>1
            ];
            $res = pdo_insert("gpb_distribution_group",$data);
            return $res?$this->ReturnArray("绑定成功",0,$data):$this->ReturnArray('绑定失败，请重试');
        } else {
            //如果是自己
            if($pid == $uid){
                return $this->ReturnArray("无法绑定自己");
            }
            //是否上级存在
            $p_info = pdo_get("gpb_distribution_money",['uid'=>$pid,'weid'=>$this->weid]);
            if(empty($p_info)){
                //无上级返回失败
                return $this->ReturnArray("非法上级");
            }
            //是否已是其他人下级
            $group_log = pdo_get("gpb_distribution_group_log",['weid'=>$this->weid,'uid'=>$uid]);
            if(!empty($group_log)){
                //是其他人下级
                return $this->ReturnArray("非法上级");
            }
            //有上级，获取上级团队信息
            $top_team = pdo_get("gpb_distribution_group",['leader_id'=>$pid]);
            if(empty($top_team)){
                //不存在team
                return $this->ReturnArray("团队不存在");
            }
            $sql = "update ".tablename("gpb_distribution_group")." set `lv1`=CONCAT(lv1,',{$uid}') where `id`='{$top_team['id']}'";
//            exit($sql);
            $res = pdo_query($sql);
            //是否有二级团队
            $sql = "select * from ".tablename("gpb_distribution_group")." where find_in_set('{$pid}',lv1)";
            $mid_team = pdo_fetchall($sql);
            if(!empty($mid_team[0])){
                $mid_team = $mid_team[0];
				if($mid_team['id'] == $uid){
					return $this->ReturnArray("无法绑定自己");
				}
                $sql = "update ".tablename("gpb_distribution_group")." set `lv2`=CONCAT(lv2,',{$uid}') where `id`='{$mid_team['id']}'";
                pdo_query($sql);
            }
            //是否有三级团队
            $sql = "select * from ".tablename("gpb_distribution_group")." where find_in_set('{$pid}',lv2)";
            $lv2_team = pdo_fetchall($sql);
            if(!empty($lv2_team[0])){
                $lv2_team = $lv2_team[0];
				if($lv2_team['id'] == $uid){
					return $this->ReturnArray("无法绑定自己");
				}
                $sql = "update ".tablename("gpb_distribution_group")." set `lv3`=CONCAT(lv3,',{$uid}') where `id`='{$lv2_team['id']}'";
                pdo_query($sql);
            }
            //加入日志
            $log = [
                'uid'=>$uid,
                'pid'=>$pid,
                'create_time'=>time(),
                'update_time'=>time(),
                'status'=>1,
                'weid'=>$this->weid
            ];
            pdo_insert('gpb_distribution_group_log',$log);
            return $res?$this->ReturnArray("绑定成功",0):$this->ReturnArray('绑定失败，请重试');
        }
    }
    /**
     * 用户佣金增加
     * $uid int 用户id
     * $money double 增加金额
     * $msg string 增加资金途径
     */
    public function addmoney($uid=0,$money=0,$msg = ''){
        if($uid<1){
            return $this->ReturnArray("用户不存在");
        }
        if($money<=0){
            return $this->ReturnArray("金额错误");
        }
        $user = pdo_get("gpb_distribution_money",['uid'=>$uid,'weid'=>$this->weid,'check_state'=>1]);
        if(empty($user)){
            return $this->ReturnArray("该用户不是分销用户");
            //没有记录先插入
            $user = [
                'uid'=>$uid,
                'create_time'=>time(),
                'update_time'=>time(),
                'status'=>1,
            ];
            pdo_insert("gpb_distribution_money",$user);
        }
        $money = doubleval($money);
        $sql = "update ".tablename("gpb_distribution_money")." set `money` = money+{$money} where `uid`='{$uid}' and `check_state`='1'; ";
        $res = pdo_query($sql);
		$user_money = $user['money'] + $money;
        $this->moneychangelog($uid,1,$money,"{$msg},佣金增加{$money}元",$user_money);
        return $res?$this->ReturnArray("佣金修改成功",0):$this->ReturnArray("佣金修改失败");
    }
    /**
     * 佣金冻结
     * $uid int 用户id
     * $money double 冻结金额
     */
    public function frize_money($uid=0,$money=0,$msg = ''){
        if($uid<1){
            return $this->ReturnArray("用户不存在");
        }
        if($money<=0){
            return $this->ReturnArray("金额错误");
        }
        $user = pdo_get("gpb_distribution_money",['uid'=>$uid,'weid'=>$this->weid,'check_state'=>1]);
        if(empty($user)){
            return $this->ReturnArray("该用户不是分销用户");
            //没有记录先插入
            $user = [
                'uid'=>$uid,
                'create_time'=>time(),
                'update_time'=>time(),
                'status'=>1,
            ];
            pdo_insert("gpb_distribution_money",$user);
        }
        if(($user['money']-$money)<0){
            return $this->ReturnArray("用户金额不足");
        }
        $sql = "update ".tablename("gpb_distribution_money")." set `money` = money-{$money},`frize_money`= frize_money+{$money} where `uid`='{$uid}' and `check_state`='1';";
        $res = pdo_query($sql);
		$user_money = $user['money'] - $money;
        $this->moneychangelog($uid,3,$money,"{$msg},冻结资金{$money}元",$user_money);
        return $res?$this->ReturnArray("冻结资金{$money}元成功",0):$this->ReturnArray("佣金修改失败");
    }
    /**
     * 佣金解冻
     * $uid int 用户id
     * $money double 解冻金额
     */
    public function unfrize_money($uid=0,$money=0,$msg = ''){
        if($uid<1){
            return $this->ReturnArray("用户不存在");
        }
        if($money<=0){
            return $this->ReturnArray("金额错误");
        }
        $user = pdo_get("gpb_distribution_money",['uid'=>$uid,'weid'=>$this->weid,'check_state'=>1]);
        if(empty($user)){
            //没有记录先插入
            return $this->ReturnArray("该用户不是分销用户");
            $user = [
                'uid'=>$uid,
                'create_time'=>time(),
                'update_time'=>time(),
                'status'=>1,
            ];
            pdo_insert("gpb_distribution_money",$user);
        }
        if(($user['frize_money']-$money)<0){
            return $this->ReturnArray("可解冻资金不足");
        }
        $sql = "update ".tablename("gpb_distribution_money")." set `money` = money+{$money},`frize_money`= frize_money-{$money} where `uid`='{$uid}' and `check_state`='1' ";
        $res = pdo_query($sql);
		$user_money = $user['money'] + $money;
        $this->moneychangelog($uid,5,$money,"{$msg},解冻资金{$money}元",$user_money);
        return $res?$this->ReturnArray("解冻资金{$money}元成功",0):$this->ReturnArray("佣金修改失败");
    }
    /**
     * 佣金变动日志记录
     * $uid int 用户id
     * $money 变动金额
     * $type 变动金额类型
     * $msg 变动信息
     */
    public function moneychangelog($uid=0,$type=1,$money=0,$msg='',$change=0){
        $log = [
            'uid'=>$uid,
            'info'=>$msg,
            'weid'=>$this->weid,
            'type'=>$type,
            'money'=>$money,
            'create_time'=>time(),
            'update_time'=>time(),
            'change'=>$change,
        ];
        $res = pdo_insert("gpb_distribution_money_log",$log);
        return $res?$this->ReturnArray('日志写入成功',0):$this->ReturnArray('日志写入失败');
    }
    /**
     * 用户佣金体现申请
     * $uid int 用户id
     * $money double 用户提现金额
     */
    public function cash_money($uid=0,$money=0,$cash_type=1,$case_value=''){
        if($uid<1){
            return $this->ReturnArray("用户参数错误");
        }
        if($money<=0){
            return $this->ReturnArray("金额必须大于0");
        }
        //用户资金验证
        $user = pdo_get("gpb_distribution_money",['uid'=>$uid,'weid'=>$this->weid,'check_state'=>1]);
        if(empty($user)){
            return $this->ReturnArray("该用户不是分销用户");
        }
        //手续费
        $charge_money  = $this->config['distribution_cash_charge'];
        $charge_money = floatval($charge_money);
        $charge_money = round($charge_money,2);
        if($user['money']-$money-$charge_money<0){
            return $this->ReturnArray("可提现金额不足{$money}元+手续费{$charge_money}元");
        }
        $old_log = pdo_get('gpb_distribution_cash_money',array('uid'=>$uid,'money'=>$money,'check_state'=>0,'weid'=>$this->weid,'status'=>1,'charge_money'=>$charge_money,'create_time >'=>(time()-60)));
        if(!empty($old_log)){
            return $this->ReturnArray("已申请提现，请一分钟后再试");
        }
        $log = [
            'uid'=>$uid,
            'money'=>$money,
            'check_state'=>0,
            'weid'=>$this->weid,
            'cash_sn'=>$this->nextId(),
            'status'=>1,
            'charge_money'=>$charge_money,
            'cash_type'=>$cash_type,
            'case_value'=>$case_value,
            'create_time'=>time(),
            'update_time'=>time(),
        ];
        $res = $id = pdo_insert("gpb_distribution_cash_money",$log);
        if($res){
            //减少用户可用资金，并增加提现中金额
            $sql = "update ".tablename("gpb_distribution_money")." set money=money-{$money}-{$charge_money},cash_money=cash_money+{$money} where `uid`='{$uid}' and `weid`='{$this->weid}'";
            $res = pdo_query($sql);
            if(!$res){
                pdo_delete("gpb_distribution_cash_money",['id'=>$id]);
            }
            //日志写入
            $change = $user['money']-$money;
            $changes = $change-$charge_money;
            $this->moneychangelog($uid,2,$money,"提现扣除佣金{$money}元",$change);
            $this->moneychangelog($uid,2,$charge_money,"提现扣除手续费{$charge_money}元",$changes);
        }
        return $res?$this->ReturnArray('提现申请提交成功，请等待管理员审核',0):$this->ReturnArray('提现申请提交失败');
    }
    /**
     * 生成提现订单号
     */
    public function nextId(){
        $timestamp = $this->timeGen();
        $lastTimestamp = self::$lastTimestamp;
        //判断时钟是否正常
        if ($timestamp < $lastTimestamp) {
            throw new \Exception("Clock moved backwards.  Refusing to generate id for %d 
milliseconds", ($lastTimestamp - $timestamp));
        }
        //生成唯一序列
        if ($lastTimestamp == $timestamp) {
            $sequenceMask = -1 ^ (-1 << self::sequenceBits);
            self::$sequence = (self::$sequence + 1) & $sequenceMask;
            if (self::$sequence == 0) {
                $timestamp = $this->tilNextMillis($lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }

        self::$lastTimestamp = $timestamp;

        //时间毫秒/数据中心ID/机器ID,要左移的位数
        $timestampLeftShift = self::sequenceBits + self::workerIdBits +
            self::datacenterIdBits;
        $datacenterIdShift = self::sequenceBits + self::workerIdBits;
        $workerIdShift = self::sequenceBits;
        //组合4段数据返回: 时间戳.数据标识.工作机器.序列
        $nextId = (($timestamp - self::twepoch) << $timestampLeftShift) |
            ($this->datacenterId << $datacenterIdShift) |
            ($this->workId << $workerIdShift) | self::$sequence;

        $id = str_pad(abs($nextId),10,0,STR_PAD_LEFT);
        return date('mdhi'). substr($id,3);
        //return time() . $id;
        //return $id;
    }
    //取当前时间毫秒
    protected function timeGen(){
        $timestramp = (float)sprintf("%.0f", microtime(true) * 1000);
        return  $timestramp;
    }
    //取下一毫秒
    protected function tilNextMillis($lastTimestamp) {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }
        return $timestamp;
    }
    /**
     * 管理员操作提现（同意、拒绝）
     * $cashid int 提现主键
     * $admin_id int 操作人员id
     * $check_state int 变更状态 1同意，-1拒绝
     * $comment text 拒绝理由
     */
    public function check_cash($cashid=0,$admin_id=0,$check_state=0,$comment=''){
        global $_W,$_GPC;
        if($cashid<1){
            return $this->ReturnArray("参数错误");
        }
        if($admin_id<1){
            return $this->ReturnArray("操作人员信息获取失败");
        }
        if($check_state!=1 && $check_state!=-1){
            return $this->ReturnArray("变更状态不存在");
        }
//        if($check_state==-1 && empty($comment)){
//            return $this->ReturnArray("请填写拒绝理由/说明");
//        }
//        if($check_state==1 && empty($comment)){
//            return $this->ReturnArray("请填写同意理由/说明");
//        }
        $log = [
            'admin_id'=>$admin_id,
            'check_state'=>$check_state,
            'comment'=>$comment,
            'update_time'=>time(),
        ];
        //step1 获取用户提现详情
        $cash_info = pdo_get("gpb_distribution_cash_money",['id'=>$cashid]);

        if($cash_info['check_state']!=0){
            return $this->ReturnArray("该提现已审核过");
        }
        //获取当前域名，如果是测试站点的域名只允许提现最高2元
        $now_name = $_SERVER['SERVER_NAME'];
        if($now_name == 'test12.scmmwl.com' && $check_state==1){
            if($cash_info['money'] > 2){
                return $this->ReturnArray("测试站最高只能测试提现2元");
            }
            $today_time = date('Y-m-d',time());
            $today_count = pdo_get('gpb_distribution_money_log',array('type'=>4,'create_time >'=>strtotime($today_time),'create_time <='=>(strtotime($today_time)+24*60*60),'uid'=>$cash_info['uid']));
            if(!empty($today_count)){
                return $this->ReturnArray("测试站每天最多提现一次");
            }
        }

        if(!empty($cash_info) && $check_state==1){
            if($cash_info['cash_type']==1){
                //微信打款
                //提现同意，进行打款
                //step1 获取用户提现详情
//            $cash_info = pdo_get("gpb_distribution_cash_money",['id'=>$cashid]);
                $uid = $cash_info['uid'];
                //step2 获取用户信息
                $user = pdo_get("gpb_member",['m_id'=>$uid]);
                $openid = $user['m_openid'];
                //step3 获取当前模块相应支付参数
                $mchid = $_W['account']['setting']['payment']['wechat']['mchid'];
                $appid = $_W['account']['key'];
                $signkey = $_W['account']['setting']['payment']['wechat']['signkey'];
                $pem_cert = pdo_get("gpb_config",array('key'=>'cert_address','weid'=>$this->weid));
                $pem_cert = $pem_cert['value'];
                if(empty($pem_cert)){
                    return $this->ReturnArray("请上传支付证书");
                }
                $pem_key = pdo_get("gpb_config",array('key'=>'key_address','weid'=>$this->weid));
                $pem_key = $pem_key['value'];
                if(empty($pem_key)){
                    return $this->ReturnArray("请上传支付密钥");
                }
                $result = $this -> cash($cash_info['cash_sn'],$openid,$cash_info['money'],$mchid,$appid,$signkey,'..'.$pem_cert,'..'.$pem_key);
//            echo "<pre/>";
//            exit(var_dump($result));
                if($result['status']==1 and $result['data']['return_code'] == 'SUCCESS' and $result['data']['result_code']=='SUCCESS'){
                    //打款成功处理
                    //更新用户信息
                    $sql = "update ".tablename("gpb_distribution_money")." set cash_money = cash_money-{$cash_info['money']},used_mondey = used_mondey+{$cash_info['money']} where `uid`='{$uid}'";
                    $resu = pdo_query($sql);
                    //提现日志写入
                    $dis_moneus = pdo_get("gpb_distribution_money",array('uid'=>$uid),array('money'));
                    $this->moneychangelog($uid,4,$cash_info['money'],"用户提现成功",$dis_moneus['money']);
                    //成功修改状态
                    pdo_update('gpb_distribution_cash_money',array('check_state'=>1,'comment'=>'提现成功','update_time'=>time(),'admin_id'=>$admin_id),array('id'=>$cash_info['id']));
                    return $this->ReturnArray("提现成功",0);

                }elseif($result['status']==1 and $result['data']['return_code'] == 'SUCCESS' and $result['data']['result_code']=='FAIL' and $result['data']['err_code_des'] == "余额不足"){
                    //重置打款信息
                    $log = [
                        'admin_id'=>$admin_id,
                        'check_state'=>0,
                        'comment'=>'打款失败,商户余额不足',
                        'update_time'=>time(),
                    ];
                    pdo_update("gpb_distribution_cash_money",$log,['id'=>$cashid]);
                    return $this->ReturnArray("打款失败,商户余额不足");
                }elseif($result['status']==1 and $result['data']['return_code'] == 'SUCCESS' and $result['data']['result_code']=='FAIL' and $result['data']['err_code_des'] != "余额不足"){
                    //重置打款信息
                    $log = [
                        'admin_id'=>$admin_id,
                        'check_state'=>0,
                        'comment'=>"打款失败,{$result['data']['err_code_des']}",
                        'update_time'=>time(),
                    ];
                    pdo_update("gpb_distribution_cash_money",$log,['id'=>$cashid]);
                    return $this->ReturnArray("打款失败,{$result['data']['err_code_des']}");
                }
                $res = pdo_update("gpb_distribution_cash_money",$log,['id'=>$cashid]);
                return $this->ReturnArray("审核成功",0,$log);
            }else{
                $uid = $cash_info['uid'];
                //step2 获取用户信息
                $user = pdo_get("gpb_member",['m_id'=>$uid]);
                $openid = $user['m_openid'];
                //线下打款
                $sql = "update ".tablename("gpb_distribution_money")." set cash_money = cash_money-{$cash_info['money']},used_mondey = used_mondey+{$cash_info['money']} where `uid`='{$uid}'";
                $resu = pdo_query($sql);
                //提现日志写入
                $dis_moneus = pdo_get("gpb_distribution_money",array('uid'=>$uid),array('money'));
                $this->moneychangelog($uid,4,$cash_info['money'],"用户提现成功",$dis_moneus['money']);
                //成功修改状态
                pdo_update('gpb_distribution_cash_money',array('check_state'=>1,'comment'=>'提现成功','update_time'=>time(),'admin_id'=>$admin_id),array('id'=>$cash_info['id']));
                return $this->ReturnArray("提现成功",0);
            }

        }elseif(!empty($cash_info)){
            //金额返回
            $uid  = $cash_info['uid'];
            $dis_moneys = pdo_get("gpb_distribution_money",array('uid'=>$uid),array('money'));
            $money  = $cash_info['money'];
            $charge_money  = $cash_info['charge_money'];
            $sql = "update ".tablename("gpb_distribution_money")." set money=money+{$money}+{$charge_money},cash_money=cash_money-{$money} where `uid`='{$uid}' and `weid`='{$this->weid}'";
            $res = pdo_query($sql);
            if(!$res){
                return $this->ReturnArray("审核失败，请重试");
            }else{
                //日志记录
                $a = (double)$dis_moneys['money'] + $money;
				$b = $a + $charge_money;
                $this->moneychangelog($uid,1,$money,"提现被拒返回佣金{$money}元",$a);
                $this->moneychangelog($uid,1,$charge_money,"提现被拒返回手续费{$charge_money}元",$b);
            }
            //拒绝操作
            $res = pdo_update("gpb_distribution_cash_money",$log,['id'=>$cashid]);
            if(!$res){
                return $this->ReturnArray("审核失败，请重试");
            }
            return $this->ReturnArray("审核成功",0,$log);
        }elseif(!$cash_info){
            return $this->ReturnArray("审核失败，请重试");
        }
    }
    /**
     * 提现(由于是小程序，将采用企业付款到用户零钱的形式)
     * @param $order 订单号
     * @param $openid 收钱用户openid
     * @param $money 金额
     * @param $mchid  商户号
     * @param $appid appid
     * @param $key 支付密匙
     * @param $pem_cert cert文件路径
     * @param $pem_key key文件路径
     * return array
     */
    public function cash($order,$openid,$money,$mchid,$appid,$key,$pem_cert,$pem_key){
        if(empty($order)){
            return array('status'=>0,'msg'=>'订单号错误');
        }
        if(empty($openid)){
            return array('status'=>0,'msg'=>'请传入提现用户');
        }
        if(empty($money)){
            return array('status'=>0,'msg'=>'请传入提现金额');
        }
        if(empty($mchid)){
            return array('status'=>0,'msg'=>'清传入商户号');
        }
        if(empty($appid)){
            return array('status'=>0,'msg'=>'请传入appid');
        }
        if(empty($key)){
            return array('status'=>0,'msg'=>'请传入微信支付密匙');
        }
        if(empty($pem_cert)){
            return array('status'=>0,'msg'=>'请传入pem证书路径');
        }
        if(empty($pem_key)){
            return array('status'=>0,'msg'=>'请传入key证书路径');
        }
        if(!file_exists($pem_cert)){
            return array('status'=>0,'msg'=>'pem证书路径错误');
        }
        if(!file_exists($pem_key)){
            return array('status'=>0,'msg'=>'key证书路径错误');
        }
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';//请求地址
        $data = [
            'mch_appid'=>$appid,//公众号appid
            'mchid'=>$mchid,//商户号
            'nonce_str'=>$this->randomkeys(),//随机字符串
            'partner_trade_no'=>$order,//订单号
            'openid'=>$openid,
            'check_name'=>'NO_CHECK',//是否验证姓名
            'amount'=>$money*100,  //提现金额单位（分）
            'desc'=>'提现',//说明
            'spbill_create_ip'=>$_SERVER['SERVER_ADDR'],//ip地址
        ];
        $sign = $this->MakeSign($data, $key); //算签名
        $data_xml =  $this->array_xml($data,$sign);
        $responseXml = $this->curpost($url, $this->array_xml($data,$sign),$pem_cert,$pem_key);//post提交数据
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);//xml转换
        //打印数据  判断是否成提现
        return array('status'=>1,'msg'=>'','data'=>$this->object_to_array($unifiedOrder));
    }
    /**
     * 对象转数组
     */
    public function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object_to_array($v);
            }
        }
        return $obj;
    }
    /**
     * cur请求
     * $url 请求地址
     * $post post数据
     * $cert cert证书地址
     * $key key 证书地址
     * return array
     */
    public function curpost($url='',$postData='',$cert,$key){
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $get = getcwd();
        $get = substr($get,0,strlen($get)-3);
//		$get = "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //第一种方法，cert 与 key 分别属于两个.pem文件
//		$a = getcwd().'/extend/wxpay/cert/apiclient_cert.pem';
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$cert);
//      curl_setopt($ch,CURLOPT_SSLCERT,'../addons/wl_appointment/cert/1482977942_20181012_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$key);
//      curl_setopt($ch,CURLOPT_SSLKEY,'../addons/wl_appointment/cert/1482977942_20181012_key.pem');
        //第二种方式，两个文件合成一个.pem文件
//        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
        $data = curl_exec($ch);
        if($data === false)
        {
            echo 'Curl error: ' . curl_error($ch);exit();
        }
        curl_close($ch);
        return $data;
    }
    /**
     * array转xml
     * @param string 将array转为xml
     * @param string 签名
     * return xml 数据
     */
    public function array_xml($array,$sign){
        ksort($array);
        $xml = '<xml>';
        foreach($array as $k=>$v){
            if(!is_array($v)){
                $xml .= '<'.$k.'>'.$v.'</'.$k.'>';
            }
        }
        $xml .= '<sign>'.$sign.'</sign>';
        $xml .='</xml>';
        return $xml;
    }
    /**
     * 生成签名, $KEY就是支付key
     * @param $params array 需要签名的数组
     * @param $KEY string 密匙
     * @return 签名
     */
    public function MakeSign($params,$KEY){
//  	return $params;
//      //签名步骤一：按字典序排序数组参数
        ksort($params);
        $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v

        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    /**
     * 将参数拼接为url: key=value&key=value
     * @param $params array 需要转换的数据
     * @return string 返回拼接成功的字符串
     */
    public function ToUrlParams( $params ){
        $buff = "";
        foreach ($params as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
    /**
     * 随机字符串
     * return string 32位随机字符串
     */
    private function randomkeys($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return strtoupper($str);
    }
    /**
     * 消费记录
     * $uid int 用户id
     * $order_sn string 订单号
     */
    public function setlog($uid=0,$order_sn=""){
        $team = $this->getteamInfo($uid);
        $order = pdo_get();
    }
	/**
	 * 佣金计算
	 */
	public function user_order_goods_commiosn($code=''){
		if(empty($code)){
			return '';
		}
	}
    /**
     * 佣金计算(根据订单金额来)
     * $osn string 订单号
     */
    public function usercost($osn='',$type = 1){
        //获取当前配置
        $config = $this->getconfig();
        if($config['distribution_state']!=1){
            return $this->ReturnArray('未开启分销',0);
        }
        if(empty($config['distribution_type']) || $config['distribution_type']<1){
            return $this->ReturnArray("请设置分佣类型");
        }
        //获取当前分佣等级参数是否配置
        for($i=1;$i<=$config['distribution_lv'];$i++){
            switch($config['distribution_type']){
                case 1:
                    //百分比分佣
                    if(empty($config["distribution_lv{$i}_parsent"])){
                        return $this->ReturnArray("当前开启分佣等级为{$config['distribution_lv']}级，请设置{$i}级分佣比例");
                    }
                break;
                case 2:
                    //固定分佣
                    if(empty($config["distribution_lv{$i}_fixed"])){
                        return $this->ReturnArray("当前开启分佣等级为{$config['distribution_lv']}级，请设置{$i}级分佣金额");
                    }
                break;
            }
        }
        if($osn=='' || empty($osn)){
            return $this->ReturnArray('订单参数错误');
        }
        $order = pdo_get("gpb_order",['go_code'=>$osn,'weid'=>$this->weid,"go_status"=>100]);
        if(empty($order)){
            return $this->ReturnArray('订单不存在');
        }

		//获取订单快照
		$commiosn = pdo_fetchall("select oss_commiosn from ".tablename('gpb_order_snapshot')." where oss_go_code = '".$osn."'");
        $openid = $order['openid'];
        $user = pdo_get("gpb_member",['m_openid'=>$openid,'weid'=>$this->weid]);
        $uid = $user['m_id'];


        //下单时间大于成为下级时间才计算
        $u_group_info = pdo_fetch("select * from ".tablename("gpb_distribution_group_log")." where uid='{$uid}' and `weid`='{$this->weid}' and `status`='1'");
        if(intval($u_group_info['create_time'])>intval($order['go_add_time'])){
            return $this->ReturnArray('下单时间小于成为分销下级时间不计算佣金');
        }

        //计算订单总金额
        $total_money = $order['go_all_price']-$order['go_fdc_price'];
//      $total_money = $order['go_real_price'];
        //获取所有团队信息从低到高找
        $all_lv2 = '';//直属上级
        $all_lv1 = '';//上级的上级
        $all_lv0 = '';//lear级
        $all_lv4 = '';//自身

        if($this->config['distribution_lv']==3){
            //所属最低级所在团队 自身属于lv3 ；leader参与分佣
            $sql = "select * from ".tablename("gpb_distribution_group")." where find_in_set('{$uid}',lv3) and `weid`='{$this->weid}'";
            $team = pdo_fetchall($sql);
            if(!empty($team[0])){
                //存在团队
                $team = $team[0];

                $all_lv0 = $team['leader_id'];
            }
        }

        if($this->config['distribution_lv']>=2) {
            //所属二级团队 自身所属lv2； leader 参与分佣
            $sql = "select * from " . tablename("gpb_distribution_group") . " where find_in_set('{$uid}',lv2) and `weid`='{$this->weid}'";
            $team2 = pdo_fetchall($sql);
            if (!empty($team2[0])) {
                //存在团队
                $team = $team2[0];

                $all_lv1 = $team['leader_id'];
            }
        }
        if($this->config['distribution_lv']>=1) {
            //所属三级团队 自身所属lv1 leader参与分佣
            $sql = "select * from " . tablename("gpb_distribution_group") . " where find_in_set('{$uid}',lv1) and `weid`='{$this->weid}'";
            $team3 = pdo_fetchall($sql);
            if (!empty($team3[0])) {
                $team = $team3[0];
                $all_lv2 = $team['leader_id'];
            }
        }
        if($this->config['distribution_isself']==1) {
            //是否自身参与分佣
            $all_lv4 = $uid;
        }
		if($commiosn){
            $arr = [];
			foreach($commiosn as $ks=>$vs){
				$oss_commison = unserialize($vs['oss_commiosn']);
				$arr[$all_lv0] += !empty($oss_commison[2]['money'])?$oss_commison[2]['money']:0;
				$arr[$all_lv1] += !empty($oss_commison[1]['money'])?$oss_commison[1]['money']:0;
				$arr[$all_lv2] += !empty($oss_commison[0]['money'])?$oss_commison[0]['money']:0;
			}
		}else{
			$arr = [];
            if(!empty($all_lv0)){
                //最高级分佣最少
                $arr[$all_lv0] = $total_money*$config['distribution_lv3_parsent']/100;
            }
            if(!empty($all_lv1)){
                $arr[$all_lv1] = $total_money*$config['distribution_lv2_parsent']/100;
            }
            if(!empty($all_lv2)){
                $arr[$all_lv2] = $total_money*$config['distribution_lv1_parsent']/100;
            }
            if(!empty($all_lv4)){
                $arr[$all_lv4] = $total_money*$config['distribution_leader_parsent']/100;
            }
		}
//      //佣金类型判定
//      if($config['distribution_type']==1){
//          //百分比分佣
//          //生成键值对, key 为用户id,value为佣金金额
//          $arr = [];
//          if(!empty($all_lv0)){
//              //最高级分佣最少
//              $arr[$all_lv0] = $total_money*$config['distribution_lv3_parsent']/100;
//          }
//          if(!empty($all_lv1)){
//              $arr[$all_lv1] = $total_money*$config['distribution_lv2_parsent']/100;
//          }
//          if(!empty($all_lv2)){
//              $arr[$all_lv2] = $total_money*$config['distribution_lv1_parsent']/100;
//          }
//          if(!empty($all_lv4)){
//              $arr[$all_lv4] = $total_money*$config['distribution_leader_parsent']/100;
//          }
//      }elseif($config['distribution_type']==2){
//          //固定金额分佣
//          //生成键值对, key 为用户id,value为佣金金额
//          $arr = [];
//          if(!empty($all_lv0)){
//              $arr[$all_lv0] = $config['distribution_lv3_fixed'];
//          }
//          if(!empty($all_lv1)){
//              $arr[$all_lv1] = $config['distribution_lv2_fixed'];
//          }
//          if(!empty($all_lv2)){
//              $arr[$all_lv2] = $config['distribution_lv1_fixed'];
//          }
//          if(!empty($all_lv4)){
//              $arr[$all_lv4] = $config['distribution_leader_fixed'];
//          }
//      }else{
//          return $this->ReturnArray("请设置费用类型");
//      }
        if(empty($arr)){
            return $this->ReturnArray("无人参与分佣",0);
        }
		if($type == 2){
			return $arr;
		}
		if($this->check_base64_out_json($user['m_nickname'])){
			$user['m_nickname'] = base64_decode($user['m_nickname']);
		}
        if (file_exists(dirname(__FILE__)."/dis_log.txt") && filesize(dirname(__FILE__)."/dis_log.txt") > 100000) {
            unlink(dirname(__FILE__)."/dis_log.txt");//这里是直接删除，
        }
        //佣金处理
        foreach ($arr as $k=>$v){
            if(doubleval($v)>0 && intval($k)>0){
                $f = fopen(dirname(__FILE__)."/dis_log.txt",'a+');
                $write = serialize($_SERVER)."\n".date("Y-m-d H:i:s",time())."{$user['m_nickname']}({$order['openid']})消费{$total_money}元，{$k}获得佣金{$v}元\n";
                fwrite($f,$write);
                fclose($f);
                $this->addmoney($k,$v,"{$user['m_nickname']}消费{$total_money}元，获得佣金{$v}元");
            }
        }
        return $this->ReturnArray("分佣计算完成",0);
    }
	/**
	 * 通过商品id  计算佣金
	 * @param $id 商品id
	 * @param $gid 多规格id
	 * return
	 */
	public function user_goods_ticket($id,$openid,$num=1,$gid=0,$order_code=''){
		if(empty($id)){
			return ['code'=>2,'msg'=>'id错误'];
		}
		$config = $this->getconfig();//分销总配置
		if($config['distribution_state']!=1){
			return ['code'=>2,'msg'=>'未开启分销'];
        }
		if(empty($config['distribution_type']) || $config['distribution_type']<1){
			return ['code'=>2,'msg'=>'请设置分佣类型'];
        }
		if($gid){
			$info = pdo_fetch("select o.ggo_market_price as g_price,o.ggo_id,g.dis_type,g.dis_rule from ".tablename("gpb_goods")." g join ".tablename('gpb_goods_option')." o on g.g_id = o.ggo_g_id where g.g_id = :id and o.ggo_id = :ggo_id",array(':id'=>$id,':ggo_id'=>$gid));
		} else {
			$info = pdo_get('gpb_goods',array('g_id'=>$id));
		}
		if(empty($info)){
			$info['dis_type'] = 2;
//			return ['code'=>2,'msg'=>'找不到商品'];
		}
		if($info['dis_type'] == 1){
			//启用商品独立佣金
			$i = 1;//标识 1.统一 2.详细
			if(empty($info['ggo_id'])){
				//不是多规格商品
				$i = 1;
			} else {
				//是多规格商品
				if($info['dis_rule'] == 1){
					//统一分销佣金(就是每个等级好多佣金，不算多规格信息)
					$i = 1;
				}else{
					//多规格商品佣金（详细的多规格商品佣金）
					$i = 2;
				}
			}
			if($i == 1){
				//统一
				$config_goods = pdo_fetchall("select g_id,price,level from ".tablename('gpb_goods_distribution')." where g_id = :id and weid = :weid order by level asc ",array(':id'=>$id,':weid'=>$this->weid));
			} else {
				//详细
				$config_goods = pdo_fetchall("select g_id,price,level from ".tablename('gpb_goods_distribution')." where g_id = :id and ggo_id = :ggo_id and weid = :weid order by level asc ",array(':id'=>$id,':weid'=>$this->weid,':ggo_id'=>$gid));
			}
			if($config_goods){
				foreach($config_goods as &$vs){
					if(empty($vs['price'])){
						//当单品的配置是空时，根据总配置来
						$vs['distribution_type'] = 2;
						$vs['price'] = 0;
					} else {
						if($vs['price'] == -1){
//								总配置
							$vs['distribution_type'] = 1;
							$vs['price'] = $config['distribution_lv'.$vs['level'].'_parsent'];
						}else{
							//有配置信息
							if(!strstr($vs['price'],'%')){
								//固定金额
								$vs['distribution_type'] = 2;
							}else{
								//百分比
								$vs['distribution_type'] = 1;
							}
							$vs['price'] = trim($vs['price'],'%');
						}
					}
				}
			}
			$info['config'] = $config_goods;
		} else {
			//根据平台总配置来
			for($i=1;$i<=$config['distribution_lv'];$i++){
				$info['config'][$i-1]['distribution_type'] = 1;
				$info['config'][$i-1]['level'] = $i;
				$info['config'][$i-1]['price'] = trim($config['distribution_lv'.$i.'_parsent']);
			}
		}
		$all_lv1 = '';//直属上级
        $all_lv2 = '';//上级的上级
        $all_lv3 = '';//lear级
        $all_lv1_money = $all_lv2_money = $all_lv3_money = 0;
		$user = pdo_fetch('select m_id,m_nickname from '.tablename('gpb_member')." where m_openid = :openid and weid = :weid",array(':openid'=>$openid,':weid'=>$this->weid));
		if($this->check_base64_out_json($user['m_nickname'])) {
			$user['m_nickname'] = base64_decode($user['m_nickname']);
		}
		$uid = $user['m_id'];
        if($this->config['distribution_lv']==3){
            //所属最低级所在团队 自身属于lv3;leader参与分佣(上三级)
            $sql = "select * from ".tablename("gpb_distribution_group")." where find_in_set('{$uid}',lv3) and `weid`='{$this->weid}'";
            $team = pdo_fetchall($sql);
            if(!empty($team[0])){
                //存在团队
                $team = $team[0];
                $all_lv3 = $team['leader_id'];
            }
        }
        if($this->config['distribution_lv']>=2) {
            //所属二级团队 自身所属lv2； leader 参与分佣(上二级)
            $sql = "select * from " . tablename("gpb_distribution_group") . " where find_in_set('{$uid}',lv2) and `weid`='{$this->weid}'";
            $team2 = pdo_fetchall($sql);
            if (!empty($team2[0])) {
                //存在团队
                $team = $team2[0];
                $all_lv2 = $team['leader_id'];
            }
        }
        if($this->config['distribution_lv']>=1) {
            //所属三级团队 自身所属lv1 leader参与分佣  (上一级)
            $sql = "select * from " . tablename("gpb_distribution_group") . " where find_in_set('{$uid}',lv1) and `weid`='{$this->weid}'";
            $team3 = pdo_fetchall($sql);
            if (!empty($team3[0])) {
                $team = $team3[0];
                $all_lv1 = $team['leader_id'];
            }
        }
		//规则计算完成  就算  具体每个等级的用户好多钱
		$goods_config = $info['config'];
		//获取订单价格
		$price = pdo_fetch("select oss_g_price from ".tablename('gpb_order_snapshot')." where oss_id = ".$order_code);
//		$price = $info['g_price'];//商品价格
		$price = $price['oss_g_price'];
		$money = 0;
		for($i=1;$i<=$config['distribution_lv'];$i++){
			switch($i){
				case '1':
					if($goods_config[$i-1]['distribution_type'] == 1){
						//百分比计算
						$pr = $price*$goods_config[$i-1]['price']/100*$num;
						$money = $pr;
//							$all_lv1_money += $pr;
					} else {
						$money = $goods_config[$i-1]['price']*$num;
					}
					$money = round($money,2);
					$all_lv1_money += $money;
				break;
				case '2':
					if($goods_config[$i-1]['distribution_type'] == 1){
						//百分比计算
						$pr = $price*$goods_config[$i-1]['price']/100*$num;
						$money = $pr;
					} else {
						$money = $goods_config[$i-1]['price']*$num;
					}
					$money = round($money,2);
					$all_lv2_money += $money;
				break;
				case '3':
					if($goods_config[$i-1]['distribution_type'] == 1){
						//百分比计算
						$pr = $price*$goods_config[$i-1]['price']/100*$num;
						$money = $pr;
					} else {
						$money = $goods_config[$i-1]['price']*$num;
					}
					$money = round($money,2);
					$all_lv3_money += $money;
				break;
			}
		}
     	if($all_lv1_money >= 0 && $all_lv1){
     		$arr[0] = array('level_uid'=>$all_lv1,'money'=>$all_lv1_money);
     	}
     	if($all_lv2_money >= 0 && $all_lv2){
     		$arr[1] = array('level_uid'=>$all_lv2,'money'=>$all_lv2_money);
     	}
     	if($all_lv3_money >= 0 && $all_lv3){
     		$arr[2] = array('level_uid'=>$all_lv3,'money'=>$all_lv3_money);
     	}
		return array('code'=>1,'data'=>serialize($arr));
	}
    /**
     * 推荐人关系确认
     * $uid int 被推荐人id
     * $pid int 推荐人id
     * $num int 购买次数
     * $order_money double 当前订单金额
     */
    public function commond_set_log($uid=0,$pid=0,$num=0,$order_money=0){
        if(empty($uid)){
            return $this->ReturnArray("参数错误");
        }
        if($this->config['distribution_commoned_state']!=1){
            //未开启推荐奖
            return $this->ReturnArray("未开启推荐奖",0);
        }
        $log_info = pdo_get("gpb_distrution_commond_log",['uid'=>$uid,'pid'=>$pid,'weid'=>$this->weid]);
        if(empty($log_info)){
            //为空 新增数据
            $log = [
                'uid'=>$uid,
                'pid'=>$pid,
                'num'=>0,
                'all_money'=>0,
            ];
            //设置总推荐人数
            $total_num = $this->config['distribution_commoned_value']['commoned_times'];
            //本轮第几次计算
            $used_log = pdo_get("gpb_distrution_commond_log",['pid'=>$pid,'weid'=>$this->weid],'*','',['now_times desc','id desc','commoned_times desc']);
            if($used_log['commoned_times']<$total_num){
                $log['commoned_times'] = $used_log['commoned_times']+1;
                $log['now_times'] = $used_log['now_times'];
            }else{
                $log['commoned_times'] = 1;
                if(!empty($used_log)){
                    $log['now_times'] = $used_log['now_times']+1;
                }else{
                    $log['now_times'] = 1;
                }

            }
            $res = pdo_insert("gpb_distrution_commond_log",$log);
        }else{
            //不为空 修改数据
            if($order_money<=0){
                return $this->ReturnArray("订单金额错误");
            }
            if($order_money<$this->config['distribution_commoned_value']['solo_money'] && $this->config['distribution_commoned_value']['solo_money']!=0){
                return $this->ReturnArray("不满足条件",0);
            }
            $sql = "update ".tablename("gpb_distrution_commond_log")." set `all_money` = `all_money` + {$order_money},`num` = `num`+1 where `id` = '{$log_info['id']}'";
            $res = pdo_query($sql);
        }
        //数据处理完成，进入流程是否有满足条件的发放奖金
        $this->commondmoney($pid);
        return $res?$this->ReturnArray("增加成功",0):$this->ReturnArray("增加失败");
    }
    /**
     * 推荐奖
     * $commoned_log array 推荐日志详情
     */
    public function commondmoney($pid=0){
        if($pid<1){
            return $this->ReturnArray("参数错误!");
        }
        $config = $this->config;
        if($config['distribution_commoned_state']!=1){
            //未开启推荐奖
            return $this->ReturnArray("未开启推荐奖",0);
        }
        //获取所有未完成组别
        $log_list = pdo_getall("gpb_distrution_commond_log",['pid'=>$pid,'weid'=>$this->weid,'is_over'=>0]);
        if(empty($log_list)){
            return $this->ReturnArray("无未完成组别",0);
        }
        //完成情况数组定义
        $finish_arr = [];
        foreach ($log_list as $k=>$v){
            if(
                $v['num']>=$config['distribution_commoned_value']['num'] && //交易笔数满足
                $v['all_money']>=$config['distribution_commoned_value']['all_money'] //交易总金额满足

            ){
                $finish_arr[$v['now_times']] += 1;//当轮总人数+1
            }
        }
        if(empty($finish_arr)){
            return $this->ReturnArray("无满足推荐",0);
        }
        //查询满足总人数的轮数
        $over = '';
        $all_num = 0;
        foreach ($finish_arr as $k=>$v){
            if($v>=$config['distribution_commoned_value']['commoned_times']){
                $over .= "'{$k}',";
                $all_num++;
            }
        }
        if(empty($over)){
            return $this->ReturnArray("无满足推荐",0);
        }
        $over = substr($over,0,strlen($over)-1);
        $sql = "update ".tablename("gpb_distrution_commond_log")." set `is_over`='1' where `pid`='{$pid}' and `weid`='{$this->weid}' and `now_times` in ({$over})";
        $res = pdo_query($sql);
        if($res){
            //修改用户数据、佣金
            for($i=0;$i<$all_num;$i++){
                $this->addmoney($pid,$this->config['distribution_commoned_money'],"完成推荐奖条件");
            }
        }
        return $res?$this->ReturnArray("修改成功",0):$this->ReturnArray("修改失败");
    }
    /**
     * 用户申请
     * $uid int 用户id
     * $comment text 用户提交申请理由
     */
    public function setuser($uid=0,$comment='',$code=''){
        if($uid<1){
            return $this->ReturnArray("参数错误");
        }
        $user = [
            'uid'=>$uid,
            'weid'=>$this->weid,
            'create_time'=>time(),
            'update_time'=>time(),
            'status'=>1,
            'up_comment'=>$comment,
        ];
        if($this->config['distribution_exa']==1){
            //开启手动审核
            $user['check_state'] = 0;
            $msg = "提交成功,请等待管理员审核";
        }else{
            //自动审核
            $user['check_state'] = 1;
            $msg = "提交成功，您已成为分销人员";
            //是否已经申请过
            $users = pdo_fetch("select uid from ".tablename("gpb_distribution_money")." where uid='{$uid}' and `weid`='{$this->weid}' and check_state<>-1 and status != -1");
            if(!empty($users)){
                return $this->ReturnArray('您已经申请过了！请勿重复提交');
            }
            //是否是他人下级
            $log = pdo_get("gpb_distribution_group_log",['weid'=>$this->weid,'uid'=>$uid,'status'=>1,'is_dis'=>0]);
            if(!empty($log)){
                pdo_update("gpb_distribution_group_log",['is_dis'=>1],['id'=>$log['id']]);
            }
            //建立团队
            //是否已有
            $team_info = pdo_get("gpb_distribution_group",['weid'=>$this->weid,'status'=>1,'leader_id'=>$uid]);
            if(empty($team_info)){
                pdo_insert("gpb_distribution_group",['weid'=>$this->weid,'leader_id'=>$uid,'create_time'=>time(),'update_time'=>time(),'status'=>1]);
            }
        }
        //是否已经申请过
        $users = pdo_fetch("select uid from ".tablename("gpb_distribution_money")." where uid='{$uid}' and `weid`='{$this->weid}' and check_state<>-1 and status != -1");
        if(!empty($users)){
            return $this->ReturnArray('您已经申请过了！请勿耐心等待审核');
        }
        $res = pdo_insert("gpb_distribution_money",$user);
        if(!empty($code)){
            $parent = pdo_get('gpb_distribution_money',array('weid'=>$this->weid,'code_num'=>$code));
            if(!empty($parent)){
                $this->bingteam($uid,$parent['uid']);
            }else{
                $this->bingteam($uid);
            }
        }else{
            $this->bingteam($uid);
        }

        return $res?$this->ReturnArray($msg,0):$this->ReturnArray("提交失败");
    }
    /**
     * 用户审核
     * $uid int 用户id
     * $id int 待审核id
     * $check_state 审核状态
     * $comment 审核留言
     */
    public function update_user($uid,$id,$check_state='',$comment=''){
        if($this->config['distribution_exa']!=1){
            //开启手动审核
            return $this->ReturnArray("未开启用户审核功能");
        }
        if($uid<1){
            return $this->ReturnArray("用户不存在");
        }
        //获取其他提交是否通过过
        $dis_user = pdo_fetch("select * from ".tablename("gpb_distribution_money")." where uid='{$uid}' and `weid`='{$this->weid}' and check_state=1");
        if(!empty($dis_user)){
            return $this->ReturnArray("该用户已经审核过了！");
        }
        //获取现在状态
        $now_user = pdo_get("gpb_distribution_money",['id'=>$id,'uid'=>$uid,'weid'=>$this->weid,'status'=>1]);
        if(empty($now_user)){
            return $this->ReturnArray("用户不存在或已删除");
        }
        if($now_user['check_state']!=0){
            return $this->ReturnArray("该用户已审核过！");
        }
        $user = [
            'check_state'=>$check_state,
            'comment'=>$comment,
        ];
        //是否是他人下级
        $log = pdo_get("gpb_distribution_group_log",['weid'=>$this->weid,'uid'=>$uid,'status'=>1,'is_dis'=>0]);
        if(!empty($log)){
            pdo_update("gpb_distribution_group_log",['is_dis'=>1],['id'=>$log['id']]);
        }
        //建立团队
        //是否已有
        $team_info = pdo_get("gpb_distribution_group",['weid'=>$this->weid,'status'=>1,'leader_id'=>$uid]);
        if(empty($team_info)){
            pdo_insert("gpb_distribution_group",['weid'=>$this->weid,'leader_id'=>$uid,'create_time'=>time(),'update_time'=>time(),'status'=>1]);
        }
        $res = pdo_update("gpb_distribution_money",$user,['id'=>$id,'uid'=>$uid,'weid'=>$this->weid,'status'=>1]);
        return $res?$this->ReturnArray("审核成功",0,$user):$this->ReturnArray("审核失败");
    }
    /**
     * 用户资金变动管理员操作
     * $uid int 用户id
     * $type int 1增加，2冻结,3解冻
     * $money double 变动金额
     * $comment text 变动原因
     */
    public function change_user_money($uid=0,$type=1,$money=0,$comment=''){
        $money = (double)$money;
        if($uid<1){
            return $this->ReturnArray("用户不存在");
        }
        if($money<=0){
            return $this->ReturnArray("变动资金必须大于0元");
        }
        if(empty($comment)){
            return $this->ReturnArray("请填写变动原因");
        }
        switch ($type){
            case 1:
                return $this->addmoney($uid,$money,"管理员操作,".$comment);
                break;
            case 2:
                return $this->frize_money($uid,$money,"管理员操作,".$comment);
                break;
            case 3:
                return $this->unfrize_money($uid,$money,"管理员操作,".$comment);
                break;
        }
    }
    /**
     * 获取所有分销用户
     * $pageSize int 单页显示个数
     * $pageIndex int 当前页数
     */
    public function getuserlist($pageIndex = 1,$where = "`status`<>'-1'"){
//        $sql = "select * from ".tablename("gpb_distribution_money")." where `status`='1'";
//        $user = pdo_fetchall($sql);
        if(empty($where)){
            $where = tablename("gpb_distribution_money").".`status`<>'-1' ";
        }
        $list = $this->getList("gpb_distribution_money",$where,$pageIndex,"id desc",tablename("gpb_member")." on ".tablename("gpb_distribution_money").".uid=".tablename("gpb_member").".m_id","*,".tablename("gpb_distribution_money").".create_time as ctime,".tablename("gpb_distribution_money").".status account_state");
        return $list;
    }
    /**
     * 获取未审核用户
     */
    public function getcheckuserlist($pageIndex = 1,$where = "`status`='1'"){
//        $sql = "select * from ".tablename("gpb_distribution_money")." where `status`='1'";
//        $user = pdo_fetchall($sql);
        $where = tablename("gpb_distribution_money").".`status`='1' and ".tablename("gpb_distribution_money").".`check_state`<>1";
        $list = $this->getList("gpb_distribution_money",$where,$pageIndex,"id desc",tablename("gpb_member")." on ".tablename("gpb_distribution_money").".uid=".tablename("gpb_member").".m_id","*,".tablename("gpb_distribution_money").".create_time as ctime");
        return $list;
    }
    /**
     * 获取用户信息
     * $uid int 用户id
     */
    public function getuserInfo($uid=0,$condition = '1'){
        if($uid<1){
            return $this->ReturnArray("用户不存在");
        }
//        $user = pdo_get("gpb_distribution_money",['uid'=>$uid,'weid'=>$this->weid,'status'=>1]);
        $sql = "select *,dm.create_time c_time from ".tablename("gpb_distribution_money")." dm left join ".tablename("gpb_member")." m on dm.uid=m.m_id left join ".tablename("gpb_distribution_group")." dg on dg.leader_id=dm.uid where dm.uid={$uid} and dm.weid={$this->weid} and dm.`status`='1' and {$condition}";
        $user = pdo_fetch($sql);
        if(is_base64($user['m_nickname'])){
            $user['m_nickname'] = base64_decode($user['m_nickname']);
        }
//        $user = $user[0];
//        echo "<pre/>";
//        exit(var_dump($user['lv1']));
        return !empty($user)?$this->ReturnArray('获取成功',0,$user):$this->ReturnArray("用户不存在");
    }
    /**
     * 获取用户信息
     * $uid int 用户money表id
     */
    public function getAdituserInfo($uid=0){
        if($uid<1){
            return $this->ReturnArray("用户不存在");
        }
//        $user = pdo_get("gpb_distribution_money",['uid'=>$uid,'weid'=>$this->weid,'status'=>1]);
        $sql = "select *,dm.create_time c_time from ".tablename("gpb_distribution_money")." dm left join ".tablename("gpb_member")." m on dm.uid=m.m_id left join ".tablename("gpb_distribution_group")." dg on dg.leader_id=dm.uid where dm.id={$uid} and dm.weid={$this->weid} and dm.`status`='1'";
        $user = pdo_fetchall($sql);
        $user = $user[0];
//        echo "<pre/>";
//        exit(var_dump($user['lv1']));
        return !empty($user)?$this->ReturnArray('获取成功',0,$user):$this->ReturnArray("用户不存在");
    }
    /**
     * 获取分页列表
     * $table string 表名
     * $where string 条件
     * $pageIndex int 当前页数
     * $order sring 排序
     * $join string 连表条件
     * $filed string 字段名,默认*
     * $pageSize int 每页条数，默认20
     */
    public function getList($table='',$where='',$pageIndex=1,$order='id desc',$join='',$filed='*',$pageSize=20,$debug=0){
//        exit($pageIndex);
        $contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;
        $count_sql = 'select count(*) from ' . tablename($table)." where weid=".$this->weid." and {$where} ";
        if(!empty($join)){
            $count_sql = "select count(*) from ".tablename($table)." left join {$join} where ".tablename($table).".`weid`='{$this->weid}' and {$where}";
        }
        $total= pdo_fetchcolumn($count_sql);
        $page = pagination($total,$pageIndex,$pageSize);
        //获取分页信息
        if(empty($join)){
            $sql = "select {$filed}  from ".tablename($table)." where weid=".$this->weid." and ".$where." order by {$order} ".$contion;
        }else{
            $sql = "select {$filed} from ".tablename($table)." left join {$join} where ".tablename($table).".`weid`='{$this->weid}' and {$where} order by {$order} {$contion}";
        }

//        var_dump($sql);exit();
        if($debug){
            echo "<pre/>";
            exit(var_dump($sql));
        }
        $info = pdo_fetchall($sql);
        $arr = ['total'=>$total,'list'=>$info,'page'=>$page];
        return $arr;
    }
    /**
     * 用户佣金列表
     * $uid int 用户id
     * $type int 类型 -1 默认 所有,1增加，2减少，3冻结，4体现,5解冻
     */
    public function getlog($uid=0,$page=1,$type=-1){
        if($type==-1){
            $where = "`uid`='{$uid}' and `status`=1";
        }else{
            $where = "`uid`='{$uid}' and `status`=1 and `type`='{$type}'";
        }
        $log = $this->getList("gpb_distribution_money_log",$where,$page,'create_time desc');
        return $log;
    }
    /**
     * 用户佣金列表
     * $uid int 用户id
     * $type int 类型 1 默认增加，2减少，3冻结，4体现,5解冻
     */
    public function getuserlog($uid=0,$page=1,$type=1){
        if($type==1){
            $where = "`uid`='{$uid}' and `status`=1 and (`type`='1' or `type`='5')";
        }else{
            $where = "`uid`='{$uid}' and `status`=1 and (`type`='2' or `type`='4' or `type`='5')";
        }
        $log = $this->getList("gpb_distribution_money_log",$where,$page,'create_time desc');
        if(!empty($log['list'])){
            foreach ($log['list'] as $k=>$v){
                $log['list'][$k]['date'] = date("Y-m-d",$v['create_time']);
            }
        }
        return $log;
    }
    /**
     * 用户团队
     * $uid int leaderid
     */
    public function getuserteam($uid = 0){
//        exit(var_dump($uid));
        $team = pdo_get("gpb_distribution_group",['leader_id'=>$uid,'weid'=>$this->weid]);
        if(!empty($team['lv1'])){
//            $team['lv1'] = substr($team['lv1'],1,strlen($team['lv1']));
            $team['lv1'] = trim($team['lv1'],',');
            $sql1 = "select * from ".tablename("gpb_member")." where `m_id` in ({$team['lv1']}) and `m_nickname` is not null ";
//            exit($sql1);
            $lv1 = pdo_fetchall($sql1);
            foreach ($lv1 as $k=>$v){
                $lv1[$k]['m_add_time'] = date("Y-m-d",$v['m_add_time']);
                $log = pdo_get("gpb_distribution_group_log",['weid'=>$this->weid,'uid'=>$v['m_id']]);
                $lv1[$k]['c_time'] = date("Y-m-d",$log['create_time']);
                $lv1[$k]['is_dis'] = $log['is_dis']==1?'是':'否';
                if($this->check_base64_out_json($v['m_nickname'])){
                	$lv1[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }
            }
        }else{
            $lv1 = [];
        }
        if(!empty($team['lv2'])) {
//            $team['lv2'] = substr($team['lv2'],1,strlen($team['lv2']));

            $team['lv2'] = trim($team['lv2'],',');
            $sql2 = "select * from " . tablename("gpb_member") . " where `m_id` in ({$team['lv2']}) and `m_nickname` is not null ";
            $lv2 = pdo_fetchall($sql2);
            foreach ($lv2 as $k=>$v){
                $lv2[$k]['m_add_time'] = date("Y-m-d",$v['m_add_time']);
                $log = pdo_get("gpb_distribution_group_log",['weid'=>$this->weid,'uid'=>$v['m_id']]);
                $lv2[$k]['c_time'] = date("Y-m-d",$log['create_time']);
                $lv2[$k]['is_dis'] = $log['is_dis']==1?'是':'否';
                if($this->check_base64_out_json($v['m_nickname'])){
                	$lv2[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }
            }
        }else{
            $lv2 = [];
        }
        if(!empty($team['lv3'])) {
//            $team['lv3'] = substr($team['lv3'],1,strlen($team['lv3']));
            $team['lv3'] = trim($team['lv3'],',');
            $sql3 = "select * from " . tablename("gpb_member") . " where `m_id` in ({$team['lv3']}) and `m_nickname` is not null";
            $lv3 = pdo_fetchall($sql3);
            foreach ($lv3 as $k=>$v){
                $lv3[$k]['m_add_time'] = date("Y-m-d",$v['m_add_time']);
                $log = pdo_get("gpb_distribution_group_log",['weid'=>$this->weid,'uid'=>$v['m_id']]);
                $lv3[$k]['c_time'] = date("Y-m-d",$log['create_time']);
                $lv3[$k]['is_dis'] = $log['is_dis']==1?'是':'否';
                if($this->check_base64_out_json($v['m_nickname'])){
                	$lv3[$k]['m_nickname'] = base64_decode($v['m_nickname']);
                }
            }
        }else{
            $lv3 = [];
        }
        $arr = ['1'=>$lv1,'2'=>$lv2,'3'=>$lv3];
        return $arr;
    }
    /**
     * 用户推荐记录
     * $uid int 用户id
     * $pageIndex int 当前页数
     */
    public function getcommon_log($uid=0,$pageIndex=1){
        $where = tablename("gpb_distrution_commond_log").".`status`='1' and ".tablename("gpb_distrution_commond_log").".`pid`='{$uid}'";
//        exit($uid);
        $log = $this->getList("gpb_distrution_commond_log",$where,$pageIndex,"id desc",tablename("gpb_member")." on ".tablename("gpb_distrution_commond_log").".uid=".tablename("gpb_member").".m_id","*,".tablename("gpb_distrution_commond_log").".create_time as ctime");
        return $log;
    }
    /**
     * 用户提现审核列表
     * $pageIndex int当前页数
     * $state int 状态
     */
    public function get_cash_list($pageIndex=1,$state = -1){
        $where = "cm.`status`='1' and cm.`weid`='{$this->weid}'";
        if($state!=-1){
            $where .= " and cm.`check_state`='{$state}'";
        }
        /*$list = $this->getList("gpb_distribution_cash_money",$where,$pageIndex,"id desc",tablename("gpb_member")." on ".tablename("gpb_distribution_cash_money").".uid=".tablename("gpb_member").".m_id",tablename("gpb_distribution_cash_money").".*,".tablename("gpb_distribution_cash_money").".create_time as ctime,".tablename("gpb_member").".m_nickname,".tablename("gpb_member").".m_photo");*/
        $total = pdo_fetchcolumn("select count(*) from ".tablename("gpb_distribution_cash_money")." as cm join ".tablename("gpb_member")." as m on cm.uid=m.m_id where {$where} ");
        $size = 20;
        $page = !empty($pageIndex)?$pageIndex:1;
        $limit = ($page-1)*$size;
        $limit = "{$limit},{$size}";
        $list = pdo_fetchall("select cm.*,m.m_nickname,cm.create_time as ctime from ".tablename("gpb_distribution_cash_money")." as cm join ".tablename("gpb_member")." as m on cm.uid=m.m_id where {$where} order by id desc limit {$limit}");
        $list = [
            'total'=>$total,
            'page'=>pagination($total,$pageIndex,$size),
            'list'=>$list,
        ];
        return $list;
    }
    /**
     * 获取当前用户下级分级
     * $uid int 用户标识
     */
    public function getlv($uid=0){
        $conf = $this->getconfig();
        $group = pdo_get("gpb_distribution_group",['leader_id'=>$uid]);
        $group['lv1'] = $conf['distribution_lv']>=1?trim($group['lv1'],','):0;
        $group['lv2'] = $conf['distribution_lv']>=2?trim($group['lv2'],','):0;
        $group['lv3'] = $conf['distribution_lv']==3?trim($group['lv3'],','):0;
        $lv1 = !empty($group['lv1'])?count(explode(',',$group['lv1'])):0;
        $lv2 = !empty($group['lv2'])?count(explode(',',$group['lv2'])):0;
        $lv3 = !empty($group['lv3'])?count(explode(',',$group['lv3'])):0;
        $arr = [];
        if(!empty($group['lv1'])){
            $lv1 = pdo_fetchcolumn('select count(*) from '.tablename('gpb_member').' where m_id in('.trim($group['lv1'],',').')  and m_nickname is not null');
        }
        if(!empty($group['lv2'])){
            $lv2 = pdo_fetchcolumn('select count(*) from '.tablename('gpb_member').' where m_id in('.trim($group['lv2'],',').')  and m_nickname is not null');
		}
        if(!empty($group['lv3'])){
            $lv3 = pdo_fetchcolumn('select count(*) from '.tablename('gpb_member').' where m_id in('.trim($group['lv3'],',').')  and m_nickname is not null');
		}
		switch($conf['distribution_lv']){
			case '1';
				$arr[] = ['level'=>1,'name'=>'一级','total'=>$lv1];
			break;
			case '2';
				$arr[] = ['level'=>1,'name'=>'一级','total'=>$lv1];
				$arr[] = ['level'=>2,'name'=>'二级','total'=>$lv2];
			break;
			case '3';
				$arr[] = ['level'=>1,'name'=>'一级','total'=>$lv1];
				$arr[] = ['level'=>2,'name'=>'二级','total'=>$lv2];
				$arr[] = ['level'=>3,'name'=>'三级','total'=>$lv3];
			break;
		}

        return $this->ReturnArray('获取成功',0,$arr);
    }
    /**
     * 用户获取自身提现记录
     */
    public function self_cashlog($uid=0,$pageIndex=1,$state = -2){
//        exit(var_dump($state));
        $where = "`uid`='{$uid}'";
        if($state!==-2 && $state!='-2'){
            $where .= " and `check_state`='{$state}'";
        }
//        exit($where);
        $order = "create_time desc";
        $table = "gpb_distribution_cash_money";
        $list = $this->getList($table,$where,$pageIndex,$order);
        $list = $list['list'];
//        echo "<pre/>";
//        exit(var_dump($list));
        if(!empty($list)){
            foreach ($list as $k=>$v){
                $list[$k]['create_time'] = date("Y-m-d H:i:s",$v['create_time']);
                $list[$k]['check_state'] = $v['check_state']==1?'已打款':($v['check_state']==0?'待审核':'已拒绝');
            }
        }

        return $this->ReturnArray('获取成功',0,$list);
    }
    /**
     * 获取用户下级分销订单数量
     */
    public function getchil_order_count($uid=0){
//        $sql = "SELECT count(*) FROM ".tablename("gpb_distribution_group_log")." AS dgl LEFT JOIN ".tablename("gpb_member")." AS m ON m.m_id=dgl.`uid` LEFT JOIN ".tablename("gpb_order")." AS o ON m.m_openid=o.openid WHERE dgl.`weid`='{$this->weid}'AND  dgl.`status`=1 AND  dgl.uid='{$uid}' and o.go_add_time>dgl.create_time";
////        exit($sql);
//        $count = pdo_fetchcolumn($sql);
        $table='gpb_distribution_group_log';
        //用户信息
        $uids = "";
        $user = pdo_get('gpb_distribution_group',['weid'=>$this->weid,'status'=>1,'leader_id'=>$uid]);
        $conf = $this->getconfig();
        $lv1 = $conf['distribution_lv']>=1?(!empty($user['lv1'])?trim($user['lv1'],','):''):'';
        $lv1_arr = !empty($lv1)?explode(",",$lv1):[];
        $uids .= !empty($lv1)?$lv1:'';
        $lv2 = $conf['distribution_lv']>=2?(!empty($user['lv2'])?trim($user['lv2'],','):''):'';
        $lv2_arr = !empty($lv2)?explode(",",$lv2):[];
        $uids .= !empty($lv2)?','.$lv2:'';
        $lv3 = $conf['distribution_lv']==3?(!empty($user['lv3'])?trim($user['lv3'],','):''):'';
        $lv3_arr = !empty($lv3)?explode(",",$lv3):[];
        $uids .= !empty($lv3)?','.$lv3:'';
        if(empty($uids)){
            return $this->ReturnArray('获取成功',0,['order'=>0]);
        }
        $where= tablename("gpb_distribution_group_log").'.`status`=1 and '."o.go_add_time>".tablename("gpb_distribution_group_log").".create_time and ".tablename("gpb_distribution_group_log").".uid in({$uids}) and o.go_status<=100 and o.type=1";
        $order=tablename("gpb_distribution_group_log").'.`id` desc';
        $join= tablename("gpb_member")." m on m.m_id=".tablename("gpb_distribution_group_log").".`uid` join ".tablename("gpb_order")." o on m.m_openid=o.openid ";
        $filed='*';
        $count_sql = "select count(*) from ".tablename($table)." left join {$join} where ".tablename($table).".`weid`='{$this->weid}' and {$where}";
//        exit($count_sql);
        $count = pdo_fetchcolumn($count_sql);
//        exit($count);
        return $this->ReturnArray('获取成功',0,['order'=>$count]);
    }
    /**
     * 获取用户下级分销订单
     * $uid int 用户id
     * $page int 当前页数
     * $state int 状态 默认-2为所有状态
     */
    public function getchil_order($uid=0,$page=1,$state = -2){
        $table='gpb_distribution_group_log';
        $conf = $this->getconfig();
        //用户信息
        $uids = "";
        $user = pdo_get('gpb_distribution_group',['weid'=>$this->weid,'status'=>1,'leader_id'=>$uid]);
        $lv1 = $conf['distribution_lv']>=1?(!empty($user['lv1'])?trim($user['lv1'],','):''):'';
        $lv1_arr = !empty($lv1)?explode(",",$lv1):[];
        $uids .= !empty($lv1)?$lv1:'';
        $lv2 = $conf['distribution_lv']>=2?(!empty($user['lv2'])?trim($user['lv2'],','):''):'';
        $lv2_arr = !empty($lv2)?explode(",",$lv2):[];
        $uids .= !empty($lv2)?','.$lv2:'';
        $lv3 = $conf['distribution_lv']==3?(!empty($user['lv3'])?trim($user['lv3'],','):''):'';
        $lv3_arr = !empty($lv3)?explode(",",$lv3):[];
        $uids .= !empty($lv3)?','.$lv3:'';

        $where= tablename("gpb_distribution_group_log").'.`status`=1 and '."o.go_add_time>".tablename("gpb_distribution_group_log").".create_time and ".tablename("gpb_distribution_group_log").".uid in({$uids}) and o.go_status<=100 and o.type=1";
        if($state!=-2){
            switch($state){
                case 1:
                    $where .= " and o.go_status<20";
                    break;
                case 2:
                    $where .= " and o.go_status between 20 and 100";
                    break;
                default :
                    $where .= " and o.go_status='{$state}'";
                    break;
            }
        }

        $order="o.go_add_time desc";
        $join= tablename("gpb_member")." m on m.m_id=".tablename("gpb_distribution_group_log").".`uid` join ".tablename("gpb_order")." o on m.m_openid=o.openid ";
        $filed=' * ';
        $list = $this->getList($table,$where,$page,$order,$join,$filed);
        $list = $list['list'];
//		echo "<pre/>";
//		print_r($list);
//		exit;
        //获取商品信息
        foreach ($list as $k=>$v){
        	$goods = pdo_getall("gpb_order_snapshot",['oss_go_code'=>$v['go_code']]);
            if(is_base64($v['m_nickname'])){
                $list[$k]['m_nickname'] = base64_decode($v['m_nickname']);
            }
			$list[$k]['dis_type'] = $this->config['distribution_type'];
        	$list[$k]['go_add_time'] = date("Y-m-d H:i:s",$v['go_add_time']);

        	$arr = $this->usercost($v['go_code'],2);
			$money = 0;
			if($goods){
				foreach($goods as &$vs){
					if(empty($vs['oss_commiosn'])){
						//这个是保证以前的数据不出错
						if(in_array($v['uid'],$lv1_arr)){
			        		$vs['parsent_money'] = $arr[$v['pid']] ? round($arr[$v['pid']],2) : 0 ;
			        		$money += $vs['parsent_money'];$list[$k]['lv'] = '1级';
			        	}
			        	if(in_array($v['uid'],$lv2_arr)){
			        		$vs['parsent_money'] = $arr[$v['pid']] ? round($arr[$v['pid']],2) : 0 ;
							$money += $vs['parsent_money'];$list[$k]['lv'] = '2级';
			        	}
			        	if(in_array($v['uid'],$lv3_arr)){
			        		$vs['parsent_money'] = $arr[$v['pid']] ? round($arr[$v['pid']],2) : 0 ;
							$money += $vs['parsent_money'];$list[$k]['lv'] = '3级';
			        	}
					}else{
						//单品佣金
						$commiosn = unserialize($vs['oss_commiosn']);
						if(in_array($v['uid'],$lv1_arr)){
			        		$vs['parsent_money'] = $commiosn[0]['money'] ? round($commiosn[0]['money'],2) : 0 ;
			        		$money += $vs['parsent_money'];
							$list[$k]['lv'] = '1级';
			        	}
			        	if(in_array($v['uid'],$lv2_arr)){
			        		$vs['parsent_money'] = $commiosn[1]['money'] ? round($commiosn[1]['money'],2) : 0 ;
							$money += $vs['parsent_money'];
							$list[$k]['lv'] = '2级';
			        	}
			        	if(in_array($v['uid'],$lv3_arr)){
			        		$vs['parsent_money'] = $commiosn[2]['money'] ? round($commiosn[2]['money'],2) : 0 ;
							$money += $vs['parsent_money'];
							$list[$k]['lv'] = '3级';
			        	}
					}
					$vs['oss_g_icon'] = tomedia($vs['oss_g_icon']);
				}
			}
        	$list[$k]['goods_list'] = $goods;
        	$list[$k]['parsent_money'] = $money;
//			print_r($arr);
//			continue;


//          $goods = pdo_getall("gpb_order_snapshot",['oss_go_code'=>$v['go_code']]);
//          foreach ($goods as $kk=>$vv){
//              $goods[$kk]['oss_g_icon'] = tomedia($vv['oss_g_icon']);
//          }
//          if(is_base64($v['m_nickname'])){
//              $list[$k]['m_nickname'] = base64_decode($v['m_nickname']);
//          }
//          $list[$k]['goods_list'] = $goods;
//          $list[$k]['go_add_time'] = date("Y-m-d H:i:s",$v['go_add_time']);
//          $list[$k]['dis_type'] = $this->config['distribution_type'];
//          if(in_array($v['uid'],$lv1_arr)){
//              $list[$k]['lv'] = "1级";
//              //佣金
//              switch ($this->config['distribution_type']){
//                  case 1:
//                      $parsent = $this->config['distribution_lv1_parsent'];
//                      $list[$k]['parsent_money'] = ($v['go_all_price']-$v['go_fdc_price'])*$parsent/100;
//                      $list[$k]['dis_parsent'] = $parsent;
//                      break;
//                  case 2:
//                      $list[$k]['parsent_money'] = $this->config['distribution_lv1_fixed'];
//                      $list[$k]['dis_parsent'] = $this->config['distribution_lv1_fixed'];
//                      break;
//              }
//          }
//          if(in_array($v['uid'],$lv2_arr)){
//              $list[$k]['lv'] = "2级";
//              //佣金
//              switch ($this->config['distribution_type']){
//                  case 1:
//                      $parsent = $this->config['distribution_lv2_parsent'];
//                      $list[$k]['parsent_money'] = ($v['go_all_price']-$v['go_fdc_price'])*$parsent/100;
//                      $list[$k]['dis_parsent'] = $parsent;
//                      break;
//                  case 2:
//                      $list[$k]['parsent_money'] = $this->config['distribution_lv2_fixed'];
//                      $list[$k]['dis_parsent'] = $this->config['distribution_lv2_fixed'];
//                      break;
//              }
//          }
//          if(in_array($v['uid'],$lv3_arr)){
//              $list[$k]['lv'] = "3级";
//              //佣金
//              switch ($this->config['distribution_type']){
//                  case 1:
//                      $parsent = $this->config['distribution_lv3_parsent'];
//                      $list[$k]['parsent_money'] = ($v['go_all_price']-$v['go_fdc_price'])*$parsent/100;
//                      $list[$k]['dis_parsent'] = $parsent;
//                      break;
//                  case 2:
//                      $list[$k]['parsent_money'] = $this->config['distribution_lv3_fixed'];
//                      $list[$k]['dis_parsent'] = $this->config['distribution_lv3_fixed'];
//                      break;
//              }
//          }
        }
//		echo '<pre>';
//		print_r($list);
//		exit;
        return $this->ReturnArray("获取列表成功",0,$list);
//        echo "<pre/>";
//        exit(var_dump($list));
    }
    /**
     * 审核人数
     * $type int  审核状态,-3默认取所有人,-2已冻结,-1审核未通过,0未审核,1已通过
     */
    public function get_dis_num($type = -3){
        if($type==-3){
            $sql = "select count(*) from ".tablename("gpb_distribution_money")." where `status`='1' and `weid`='{$this->weid}'";
        }elseif($type==-2){
            $sql = "select count(*) from ".tablename("gpb_distribution_money")." where `status`='-2' and `weid`='{$this->weid}'";
        }else{
            $sql = "select count(*) from ".tablename("gpb_distribution_money")." where `status`='1' and `weid`='{$this->weid}' and `check_state`='{$type}'";
        }
        $info  = pdo_fetchcolumn($sql);
        return $info;
    }
    //获取分佣比例/金额
    public function getdis_commission(){
        $config = $this->config;
        $arr = [];
        switch($config['distribution_type']){
            case 1:
                //百分比分佣
                $arr = [
                    'lv1'=>$config['distribution_lv1_parsent'],
                    'lv2'=>$config['distribution_lv2_parsent'],
                    'lv3'=>$config['distribution_lv3_parsent'],
                    'type'=>1,
                ];
                break;
            case 2:
                //固定分佣
                $arr = [
                    'lv1'=>$config['distribution_lv1_fixed'],
                    'lv2'=>$config['distribution_lv2_fixed'],
                    'lv3'=>$config['distribution_lv3_fixed'],
                    'type'=>2,
                ];
                break;
        }
        return $this->ReturnArray("获取成功",0,$arr);
    }
    /**
     * 获取用户推荐详情
     * $uid  int 用标识
     */
    public function getuser_commoned($uid=0){
        $total_num = pdo_fetchcolumn("select count(*) from ".tablename("gpb_distrution_commond_log")." where pid='{$uid}'");
        $total_turn = pdo_fetchcolumn("select count(*) from ".tablename("gpb_distrution_commond_log")." where pid='{$uid}' and is_over=1 group by now_times");
        $total_money = pdo_fetchcolumn("select count(*) from ".tablename("gpb_distrution_commond_log")." where pid='{$uid}' and is_over = 1");
        $total_money = intval($total_money);
        $total_money = $this->config['distribution_commoned_money']*$total_money;
        $comoned_config = $this->getkeyvalue("distribution_commoned_value");
        $comment = "一轮为有效推荐{$comoned_config['commoned_times']}人，有效推荐条件为：1交易笔数大于等于{$comoned_config['num']}笔，2单笔订单金额大于等于{$comoned_config['solo_money']}元，3订单总金额大于等于{$comoned_config['all_money']}";
        $arr = [
            'total_num'=>intval($total_num),
            'total_turn'=>intval($total_turn),
            'total_money'=>$total_money,
            'comment'=>$comment,
        ];
        return $this->ReturnArray("获取成功",0,$arr);
    }
    /**
     * 用户状态设置
     * $uid int 用户id
     * $status int 设置状态，默认-1 删除,1正常,-2冻结
     */
    public function set_user_status($uid=0,$status=-1){
        if($uid<1 || empty($uid)){
            return $this->ReturnArray("非法参数");
        }
        $res = pdo_update("gpb_distribution_money",['status'=>$status],['uid'=>$uid,'weid'=>$this->weid]);
        return $res?$this->ReturnArray("修改成功",0):$this->ReturnArray("修改失败");
    }
    /**
     * 配置解析
     */
    public function decode_config(){

    }
    /**
     * 返回信息
     * $code int 0 成功 1失败
     * $msg string 返回信息
     * $data array 返回信息数据
     * retru $resutl array 返回数组
     */
    private function ReturnArray($msg='',$code=1,$data=[]){
        $result = ['code'=>$code,'msg'=>$msg,'data'=>$data];
        return $result;
    }
    /**
     * 获取推广码
     */
    public function make_coupon_card() {
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[rand(0,25)]
            .strtoupper(dechex(date('m')))
            .date('d').substr(time(),-5)
            .substr(microtime(),2,5)
            .sprintf('%02d',rand(0,99));
        for(
            $a = md5( $rand, true ),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
            $d = '',
            $f = 0;
            $f < 8;
            $g = ord( $a[ $f ] ),
            $d .= $s[ ( $g ^ ord( $a[ $f + 8 ] ) ) - $g & 0x1F ],
            $f++
        );
        return  $d;
    }
    /**
     * 修改新增获取申请页面信息
     * @param $weid int 模块id
     *
     */
    public function putpage($data=[]){
        if(empty($data)){
            //获取信息
            $return = [
                'distribution_put_pic'=>$this->getkeyvalue("distribution_put_pic"),
                'distribution_put_btn'=>$this->getkeyvalue("distribution_put_btn"),
                'distribution_put_comment'=>$this->getkeyvalue("distribution_put_comment"),
            ];
        }else{
            //修改
            foreach ($data as $k=>$v){
                $res = $this->setconfig($k,$v);
            }
            $return = $res?$this->ReturnArray('修改成功',0):$this->ReturnArray('修改失败');
        }
        return $return;
    }
    /*
     * 优化微擎底层的is_base64的判断
     * 确保字符串被base64解密后可被json加密
     * string $str 被检测的字符串
     */
    protected function check_base64_out_json($str){
        if(!is_string($str)){
            return false;
        }
        $str_base64_decode = base64_decode($str);
        $str_base64_decode_json_encode = json_encode($str_base64_decode);
        $error_code = json_last_error();
        if($error_code > 0 ){
            return false;
        }
        return $str == base64_encode(base64_decode($str));
    }
    /**
	 * 退款  扣除分销佣金
	 * @param $id 订单快照表的主键id
	 * return arr
	 */
	public function deduct_a_commission($id=0){
		if(empty($id)){
			return array('code'=>2,'msg'=>'主键错误');exit;
		}
//		pdo_get("gpb_order_snapshot");
		$info = pdo_fetch("select oss_g_name,oss_buy_name,oss_commiosn from ".tablename('gpb_order_snapshot')." where oss_id = ".$id);
		if(empty($info)){
			return array('code'=>2,'msg'=>'订单不存在');exit;
		}
		if(unserialize($info['oss_commiosn']) != unll && !empty($info['oss_commiosn'])){
			//有分销佣金  依次扣
			$data = unserialize($info['oss_commiosn']);
			$username = $info['oss_buy_name'];
			if($this->check_base64_out_json($info['oss_buy_name'])){
				$username = base64_decode($info['oss_buy_name']);
			}
			if($data){
				//开启事务
				foreach($data as $k=>$v){
					$user = pdo_get('gpb_distribution_money',array('uid'=>$v['level_uid']),array('money'));
					$res = pdo_update('gpb_distribution_money',array('money -='=>$v['money']),array('uid'=>$v['level_uid']));
					if(empty($res)){
						//没有扣除
						$msg = '用户'.'"'.$username.'"退款所购买的商品'.'"'.$info['oss_g_name'].'"'.',扣除佣金'.$v['money'].".但执行失败，没有扣除，请手动扣除";
						$change = $user['money'];
					}else{
						$msg = '用户'.'"'.$username.'"退款所购买的商品'.'"'.$info['oss_g_name'].'"'.',扣除佣金'.$v['money'];
						$change = $user['money'] - $v['money'];
					}
					//记录日志
					$this->moneychangelog($v['level_uid'],2,$v['money'],$msg,$change);
				}
			}else{
				return array('code'=>2,'msg'=>'分销订单不存在');exit;
			}
		}else{
			return array('code'=>2,'msg'=>'分销订单不存在');exit;
		}
	}
}