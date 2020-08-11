<?php
/**
 * 公众号模板消息类
 * User: orichi
 * Date: 2020/2/29
 * Time: 14:17
 */
//ini_set('display_errors',1);
//error_reporting(E_ALL);
class SubWechat
{
    private $weid;/*模块标识*/
    private $modulename;/*模块名称*/
    private $token; //公众号token
    private $appid;//公众号appid
    private $secret;//公众号secret
    private $type = 2;//公众号标识


    /*一键添加的模板内容*/
    private $add_tmp = [
        [
            'tid'=>'OPENTM416836000',
            'sceneDesc'=>'支付成功给团长通知',
            'name'=>'tmp_leader',
        ],
        [
            'tid'=>'OPENTM414592347',
            'sceneDesc'=>'发货给团长通知',
            'name'=>'tmp_deviler',
        ],
        [
            'tid'=>'OPENTM417758450',
            'sceneDesc'=>'退款给管理员通知',
            'name'=>'tmp_refund',
        ],
        [
            'tid'=>'OPENTM414021489',
            'sceneDesc'=>'团长申请给管理员通知',
            'name'=>'tmp_headmsg',
        ],
        [
            'tid'=>'OPENTM405485000',
            'sceneDesc'=>'提现申请给管理员通知',
            'name'=>'tmp_cashmsg',
        ],
        [
            'tid'=>'OPENTM413077513',
            'sceneDesc'=>'付款成功给管理员通知',
            'name'=>'tmp_paymsg',
        ],
    ];
    public function __construct()
    {
        global $_W,$_GPC;
        $this->weid = $_W['uniacid'];
        $this->modulename = $_W['current_module']['name'];

        $this->appid = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='wechat_appid' and weid={$this->weid} and `status`=1");
        $this->secret = pdo_fetchcolumn("select `value` from ".tablename("gpb_config")." where `key`='wechat_secert' and weid={$this->weid} and `status`=1");

        if(!pdo_tableexists("scmm_newtmpl")){
            //不存在 创建表
            pdo_run("
                  CREATE TABLE ".tablename("scmm_newtmpl")." (
                  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新订阅消息',
                  `name` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '获取值所需名称',
                  `sceneDesc` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '标题',
                  `type` int(2) NOT NULL DEFAULT '1' COMMENT '类型,1小程序，2公众号，3公众号模板消息',
                  `module` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '所属模块',
                  `weid` int(11) NOT NULL COMMENT '所属平台id',
                  `tid` int(11) NOT NULL COMMENT '微信对应模板tid',
                  `tmpid` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '模板id',
                  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容详情',
                  `params` text COLLATE utf8_bin NOT NULL COMMENT '参数序列化',
                  `is_use` int(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
                  `status` int(1) NOT NULL DEFAULT '1',
                  `ctime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
                  `utime` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;"
            );
        }

    }

    //一键添加
    public function addall(){
        global $_W,$_GPC;
        $category = $this->getindustry();
        if(is_array($category)){
            //是数组未添加分类
            return $category;
        }
        //第二步循环添加并记录添加失败信息
        $err_list = [];
        $data = [];
        $in_arr = [];
        foreach ($this->add_tmp as $k=>$v){
            $res = $this->addtmp($v['tid']);
            if(intval($res['errcode'])!==0){
                //添加失败记录错误信息
                $err_list[$v['tid']] = $res['errmsg'];
            }else{
                //成功添加生成数据库数据
                $data[$res['template_id']] = $v;
                $data[$res['template_id']]['tmpid'] = $res['template_id'];
                $in_arr[] = $res['template_id'];
            }
        }
        //第三步获取列表 并组合数据插入数据库
        $list = $this->gettmplist();
        if(empty($list['template_list'])){
            //获取失败，返回错误信息
            return $list;
        }
        //获取成功开始处理数据
        $list = $list['template_list'];
        foreach ($list as $k=>$v){
            if(in_array($v['template_id'],$in_arr)){
                $tmpid = $v['template_id'];
                $params = $this->getcontentinfo($v['content']);
                //在添加的中组合数据
                $data[$tmpid]['content'] = $v['content'];
                $data[$tmpid]['params'] = serialize($params);
                $data[$tmpid]['is_use'] = 1;
                $data[$tmpid]['type'] = 2;
                $data[$tmpid]['module'] = $this->modulename;
                $data[$tmpid]['weid'] = $this->weid;
                $data[$tmpid]['utime'] = time();
                //检查是否已有
                $has = pdo_get("scmm_newtmpl",['tid'=>$v['tid'],'status'=>1,'name'=>$data[$tmpid]['name'],'weid'=>$this->weid,'module'=>$this->modulename,'type'=>2]);
                if($has){
                    //已有修改
                    pdo_update("scmm_newtmpl",$data[$tmpid],['id'=>$has['id']]);
                }else{
                    //没有新增
                    $data[$tmpid]['ctime'] = time();
                    $data[$tmpid]['status'] = 1;
                    pdo_insert("scmm_newtmpl",$data[$tmpid]);
                }
            }
        }
        return ['status'=>0,'errmsg'=>'获取完成','err'=>count($err_list),'errlist'=>$err_list];
    }
    /**
     * 发送消息
     * @param $name string 模板库名称
     * @param $openid string 接收用户openid
     * @param $data array 接收消息详情
     * @param $url string 跳转地址
     * @param $page string 跳转小程序页面
     */
    public function sendmsg($name,$openid,$data,$url='',$page=''){
        global $_W,$_GPC;
        //处理参数 避免多加空格
        $name = trim($name);
        $openid = trim($openid);
        $page = trim($page);
        //第一步 获取对应模板tmpid 并检查是否启用模板发送
        $is_use = pdo_fetchcolumn("select is_use from ".tablename("scmm_newtmpl")." where `name`='{$name}' and weid={$this->weid} and `module`='{$this->modulename}' and `status`=1");
        if(intval($is_use)!==1){
            //未启用或没添加模板直接返回
            return false;
        }

        $token = $this->gettoken();
        if($token===false){
            //发送日志写入
            $f = fopen(IA_ROOT."/addons/group_buy/new_wechattmp.txt",'a+');
            $write = "发送时间:".date("Y-m-d H:i:s",time())."\n模板名:{$name}\n接收人:{$openid}\n,token错误无法发送\r\n ";
            fwrite($f,$write);
            fclose($f);
            return false;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
        $send = [
            'touser'=>$openid,
            'template_id'=>$this->gettmpid($name),
            'data'=>$this->gettmpdata($name,$data),
        ];
        if(!empty($url)){
            //存在页面跳转
            $send['url'] = $url;
        }
        if(!empty($page)){
            //存在小程序跳转
            $send['miniprogram'] = [
                'appid'=>$_W['account']['key'],
                'pagepath'=>$page
            ];
        }
        $send_info = serialize($send);
        $json = json_encode($send,JSON_UNESCAPED_UNICODE  );
        $header = [
            "Content-Type: application/json",
            "Accept: application/json",
            "Content-Length: ".strlen($json),
        ];
        $result = $this->getcurl($url,$json,$header);
        $result = json_decode($result,true);
        //写入发送日志
        $f = fopen(IA_ROOT."/addons/group_buy/new_wechattmp.txt",'a+');
        $write = serialize($result);
        $write = "发送时间:".date("Y-m-d H:i:s",time())."\n模板名:{$name}\n接收人:{$openid}\n内容详情:{$send_info}\n发送返回:{$write}\r\n ";
        fwrite($f,$write);
        fclose($f);
        return true;
    }

    /**
     * 发送统一消息(用于小程序内发送模板消息openid不同时)
     * @param $name string 模板库名称
     * @param $openid string 接收用户openid
     * @param $data array 接收消息详情
     * @param $url string 跳转地址
     * @param $page string 跳转小程序页面
     */
    public function sendunimsg($name,$openid,$data,$urls='',$page=''){
        global $_GPC, $_W;
        if ( empty($_W['account']['access_time']) || time() > $_W['account']['access_time']) {
            //获取access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $_W['account']['key'] . "&secret=" . $_W['account']['secret'];
            $list = $this->getcurl($url);
            $list = json_decode($list, true);
//			echo '<pre>';
//			print_r($list);exit;
            $_W['account']['access_tokne'] = $list['access_token'];

            $_W['account']['access_time'] = time() + 7150;
            $token =  $_W['account']['access_tokne'];
        } else {
            $token =  $_W['account']['access_tokne'];
        }
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token={$token}";

        $send = [
            'touser'=>$openid,
            'mp_template_msg'=>[
                'appid'=>$this->appid,
                'template_id'=>$this->gettmpid($name),
                'data'=>$this->gettmpdata($name,$data),
            ]
        ];
        if(!empty($urls)){
            //存在页面跳转
            $send['mp_template_msg']['url'] = $urls;
        }
        if(!empty($page)){
            //存在小程序跳转
            $send['mp_template_msg']['miniprogram'] = [
                'appid'=>$_W['account']['key'],
                'pagepath'=>$page
            ];
        }
        $send_info = serialize($send);
        $json = json_encode($send,JSON_UNESCAPED_UNICODE  );
        $header = [
            "Content-Type: application/json",
            "Accept: application/json",
            "Content-Length: ".strlen($json),
        ];
        $result = $this->getcurl($url,$json,$header);
        $result = json_decode($result,true);
        //写入发送日志
        $f = fopen(IA_ROOT."/addons/group_buy/new_wechattmp.txt",'a+');
        $write = serialize($result);
        $write = "发送时间:".date("Y-m-d H:i:s",time())."\n模板名:{$name}\n接收人:{$openid}\n内容详情:{$send_info}\n发送返回:{$write}\r\n ";
        fwrite($f,$write);
        fclose($f);
        return true;
    }

    //获取公众号模板列表
    private function gettmplist(){
        $token = $this->gettoken();
        if($token===false){
            return ['status'=>1,'errmsg'=>'获取公众号token失败，请检查appid及secret是否正确'];
        }
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={$token}";
        $res = $this->getcurl($url);
        $res = json_decode($res,true);
        return $res;
    }

    //添加模板到模板库
    private function addtmp($tid){
        $token = $this->gettoken();
        if($token===false){
            return ['status'=>1,'errmsg'=>'获取公众号token失败，请检查appid及secret是否正确'];
        }
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={$token}";
        $data = ['template_id_short'=>$tid];
        $json = json_encode($data);
        $header = [
            "Content-Type: application/json",
            "Accept: application/json",
            "Content-Length: ".strlen($json),
        ];
        $res = $this->getcurl($url,$json,$header);
        $res = json_decode($res,true);
        return $res;
    }

    //获取已添加分类
    private function getindustry(){
        global $_W,$_GPC;
        $token = $this->gettoken();
        if($token===false){
            return ['status'=>1,'errmsg'=>'获取公众号token失败，请检查appid及secret是否正确'];
        }
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token={$token}";
        $res = $this->getcurl($url);
        $res = json_decode($res,true);
        if(!empty($res)){
            $first = 0;
            $second = 0;
            foreach ($res as $k=>$v){
                if($v['first_class']=='IT科技'){
                    $first++;
                }
                if($v['second_class']=='互联网|电子商务'){
                    $second++;
                }
            }
            if($first===0 || $second===0){
                //有未添加的分类
                return ['status'=>1,'errmsg'=>'分类未添加，请检查公众号分类设置','err'=>1,'errlist'=>[$res,$url,$token]];
            }
        }else{
            return true;
        }
    }

    //获取公众号token
    private function gettoken(){
        global $_W,$_GPC;
        $token = cache_load($this->appid.'_token');
        $time = time();
        if(empty($token) || empty($token['access_token']) || ($time - $token['time']>7100) ){
            $token_url = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'?'https://':'http://';
            $token_url.= $_SERVER['HTTP_HOST'];
            $token = $this->getcurl($token_url."/api/accesstoken.php?type=1&appid={$this->appid}&secret={$this->secret}");
            $token = json_decode($token,true);
            if(empty($token['accesstoken'])){
                //未获取到微擎公众号token 则请求获取
                $res = $this->getcurl("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->secret}");
                $res = json_decode($res,true);
                if(empty($res['access_token'])){
                    $this->token = '';
                    return false;
                }else{
                    $token = $res['access_token'];
                    $res['time'] = time();
                    cache_write($this->appid.'_token',$res);
                }

            }else{
                $token = $token['accesstoken'];
            }
        }else{
            if(is_array($token)){
                $token = $token['access_token'];
            }
        }
        $this->token = $token;
        return $this->token;
    }

    //根据名称获取模板id
    private function gettmpid($name){
        $tempid = pdo_fetchcolumn("select tmpid from ".tablename("scmm_newtmpl")." where `name`='{$name}' and weid={$this->weid} and `module`='{$this->modulename}' and `status`=1 and is_use=1");
        return $tempid;
    }


    /**
     * 生成消息内容数组
     * @param $name string 模板name
     * @param $data array 模板内容 一维数组或二维数组，一维数组时固定颜色 ，二维数组时 value color分别代表值和颜色
     */
    private function gettmpdata($name,$data){
        //第一步获取参数
        $param = pdo_fetchcolumn("select params from ".tablename("scmm_newtmpl")." where `name`='{$name}' and weid={$this->weid} and `module`='{$this->modulename}' and `status`=1 and is_use=1");
        $param = unserialize($param);
        if(empty($param)){
            return true;
        }
        $tmp = [];
        foreach ($param as $k=>$v){
            if(is_array($data[$k])){
                $tmp[$v] = [
                    'value'=>$data[$k]['value'],
                    'color'=>!empty($data[$k]['color'])?$data[$k]['color']:'#173177'
                ];
            }else{
                $tmp[$v] = [
                    'value'=>$data[$k],
                    'color'=>'#173177'
                ];
            }

        }
        return $tmp;
    }


    protected function getcurl($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    //提取{{}}内容
    private function getcontentinfo($cent){
        $arr = [];
        preg_match_all("/(?<={{)[^}}]+/", $cent, $arr);
        $tmp = [];
        foreach ($arr[0] as $k=>$v){
            $arr1 = [];
            $arr1 = explode(".",$v);
            $tmp[] = $arr1[0];
        }
        return $tmp;
    }

}