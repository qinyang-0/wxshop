<?php
/**
 * 订阅消息类
 * User: orichi
 * Date: 2020/2/25
 * Time: 10:48
 */

class SubMsg
{
    private $weid;/*模块标识*/
    private $modulename;/*模块名称*/

    /*一键添加的模板内容*/
    private $add_tmp = [
        [
            'tid'=>'1253',//服装/鞋/箱包
            'kidList'=>[1,4,5,2,7],// 订单编号 支付金额 订单状态 支付时间 备注
            'sceneDesc'=>'支付成功通知',
            'name'=>'pay_suc',
        ],
        [
            'tid'=>'7508',//服装/鞋/箱包
            'kidList'=>[3,4,5,1,2],// 姓名 手机号 状态 时间 门店
            'sceneDesc'=>'申请团长通知',
            'name'=>'team_leader',
        ],
        [
            'tid'=>'1470',//服装/鞋/箱包 //模板申请中
            'kidList'=>[6,2,1,7,5],// 姓名 金额 状态 手续费 说明
            'sceneDesc'=>'提现申请通知',
            'name'=>'cash_money',
        ],
        [
            'tid'=>'1435',//服装/鞋/箱包
            'kidList'=>[4,3,2,5,6],// 单号 时间 金额 商品 状态
            'sceneDesc'=>'退款申请通知',
            'name'=>'refund_msg',
        ],
        [
            'tid'=>'855',//服装/鞋/箱包
            'kidList'=>[1,2,16,10,8],// 订单号 商品名 数量 金额 备注
            'sceneDesc'=>'发货通知',
            'name'=>'deliver_msg',
        ],
        [
            'tid'=>'4531',//服装/鞋/箱包
            'kidList'=>[5,2,4],// 温馨提示 充值金额 充值时间
            'sceneDesc'=>'充值成功通知',
            'name'=>'recharge_msg',
        ],
        [
            'tid'=>'2380',//服装/鞋/箱包 //申请中
            'kidList'=>[7,1,2,8,6],// 会员类型 开通日期 有效期至 会员卡号 温馨提示
            'sceneDesc'=>'会员卡开通成功通知',
            'name'=>'vip_msg',
        ],
        [
            'tid'=>'6794',//线下商超
            'kidList'=>[1,2,3,4,5],// 商品名 砍价进度 神域时间 砍价金额 提示
            'sceneDesc'=>'砍价进度通知',
            'name'=>'bargain_msg',
        ],
        [
            'tid'=>'980',//服装/鞋/箱包
            'kidList'=>[3,1,5,7,6],// 订单号 商品名 拼团成员 拼团价 温馨提示
            'sceneDesc'=>'拼团成功通知',
            'name'=>'pteam_suc',
        ],
        [
            'tid'=>'1953',//服装/鞋/箱包
            'kidList'=>[8,1,5,4],// 订单号，拼团商品，失败原因，退款金额
            'sceneDesc'=>'拼团失败通知',
            'name'=>'pteam_fail',
        ],
    ];

    public function __construct()
    {
        global $_W,$_GPC;
        $this->weid = $_W['uniacid'];
        $this->modulename = $_W['current_module']['name'];

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
    //一键添加消息
    public function onebtnadd(){
        //第一步获取分类
        $category = $this->getcategory();
        if(intval($category['errcode'])!==0){
            return ['type'=>false,'msg'=>'获取分类失败','data'=>$category];
        }
        $category = $category['data'];
        $has = [];
        $must = [670,307];//必须分类 670-线下商超，307-服装
        foreach ($category as $k=>$v){
            if(in_array($v['id'],$must)){
                $has[] = $v['id'];
            }
        }
        if(count($has)<2){
            $dif = array_diff($must,$has);
            $dif = current($dif);
            return ['type'=>false,'msg'=>"分类未选择{$dif},请添加分类"];
        }
        $list = $this->add_tmp;
        $err = 0;
        $err_list = [];
        $header = [
            "Content-Type: application/json",
            "Accept: application/json",
        ];
        foreach ($list as $k=>$v){
            if(!empty($v['tid'])){
                //避免token过期 每次请求之前获取token
                $token = $this->Token();
                $url = "https://api.weixin.qq.com/wxaapi/newtmpl/addtemplate?access_token={$token}";
                $name = $v['name'];
                unset($v['name']);
                $json = json_encode($v);
                $header[2] ="Content-Length: ".strlen($json);
                $res = $this->getcurl($url,$json,$header);
                $res = json_decode($res,true);
                if(intval($res['errcode'])!==0){
                    //错误记录执行完成后处理
                    $err++;
                    $err_list[$v['sceneDesc']] = [
                        'errmsg'=>$res['errmsg'],
                        'openmsg'=>$this->getadderr(intval($res['errcode']))
                    ];
                }else{
                    //组合数据加入数据库

                    //先判断是否已有数据
                    $has = pdo_get("scmm_newtmpl",['tid'=>$v['tid'],'status'=>1,'name'=>$name,'weid'=>$this->weid,'module'=>$this->modulename,'type'=>1]);
                    if($has){
                        //已存在，修改
                        $update = [
                            'tmpid'=>$res['priTmplId'],
                            'is_use'=>1,
                            'utime'=>time(),
                        ];
                        pdo_update("scmm_newtmpl",$update,['id'=>$has['id']]);
                    }else{
                        //不存在，新增
                        $insert = [
                            'name'=>$name,
                            'sceneDesc'=>$v['sceneDesc'],
                            'type'=>1,
                            'module'=>$this->modulename,
                            'weid'=>$this->weid,
                            'tid'=>$v['tid'],
                            'tmpid'=>$res['priTmplId'],
                            'content'=>'',
                            'params'=>'',
                            'is_use'=>1,
                            'status'=>1,
                            'ctime'=>time(),
                            'utime'=>time(),
                        ];
                        pdo_insert("scmm_newtmpl",$insert);
                    }

                }
            }
        }
        //处理完成后获取对应模板内容
        $this->changetmp();
        return ['type'=>true,'msg'=>'添加模板完成','errlist'=>$err_list,'err'=>$err];
    }

    public function changetmp(){
        $list = $this->gettmplist();
        if($list['type']===true){
            $list = $list['data'];
            foreach ($list as $k=>$v){
                $param = $this->getcontentinfo($v['content']);
                $param = serialize($param);
                pdo_update("scmm_newtmpl",['content'=>$v['content'],'params'=>$param],['weid'=>$this->weid,'module'=>$this->modulename,'status'=>1,'tmpid'=>$k]);
            }
        }
        return true;
    }

    //发送消息
    public function sendmsg($name,$openid,$data,$page=''){
        //先检查是否启用模板
        $is_use = pdo_fetchcolumn("select is_use from ".tablename("scmm_newtmpl")." where `name`='{$name}' and weid={$this->weid} and `module`='{$this->modulename}' and `status`=1");
        if(intval($is_use)!==1){
            //未启用或没添加模板直接返回
            return false;
        }
        $token = $this->Token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token={$token}";
        $send = [
            'touser'=>$openid,
            'template_id'=>$this->gettmpid($name),
            'data'=>$this->gettmpdata($name,$data),
        ];
        if(!empty($page)){
            $send['page'] = $page;
        }
        $send_info = serialize($send);
            //转换post为json类型
        $send = json_encode($send,JSON_UNESCAPED_UNICODE);
        //JSON头部信息
        $header = [
            "Content-Type: application/json",
            "Accept: application/json",
            "Content-Length: ".strlen($send)
        ];
        //开始发送
        $result = $this->getcurl($url,$send,$header);
        $result = json_decode($result,true);
        //发送日志写入
        $f = fopen(IA_ROOT."/addons/group_buy/new_tmp.txt",'a+');
        $write = serialize($result);
        $write = "发送时间:".date("Y-m-d H:i:s",time())."\n模板名:{$name}\n接收人:{$openid}\n内容详情:{$send_info}\n发送返回:{$write}\r\n ";
        fwrite($f,$write);
        fclose($f);
        return true;
    }

    //获取所有模板消息
    public function getalltmp(){
        $list = pdo_fetchall("select `name`,tmpid from ".tablename("scmm_newtmpl")." where weid={$this->weid} and `module`='{$this->modulename}' and `status`=1 and is_use=1 and `type`=1");
        $tmp = [];
        foreach ($list as $k=>$v){
            $tmp[$v['name']] = $v['tmpid'];
        }
        return $tmp;
    }

    //根据名称获取模板id
    private function gettmpid($name){
        $tempid = pdo_fetchcolumn("select tmpid from ".tablename("scmm_newtmpl")." where `name`='{$name}' and weid={$this->weid} and `module`='{$this->modulename}' and `status`=1 and is_use=1");
        return $tempid;
    }
    //生成模板数据
    private function gettmpdata($name,$data){
        //第一步获取参数
        $param = pdo_fetchcolumn("select params from ".tablename("scmm_newtmpl")." where `name`='{$name}' and weid={$this->weid} and `module`='{$this->modulename}' and `status`=1 and is_use=1");
        $param = unserialize($param);
        $tmp = [];
        foreach ($param as $k=>$v){
            $tmp[$v] = [
                'value'=>$data[$k]
            ];
        }
        return $tmp;
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

    //一键清空模板库
    public function cleartemp(){
        //第一步获取当前模板库已有模板
        $tmplist = $this->gettmplist();
        if($tmplist['type']===false){
            return $tmplist;
        }
        $tmplist = $tmplist['data'];
        $err = [];
        $num = 0;
        foreach ($tmplist as $k=>$v){
            $result = $this->deltmp($k);
            if(intval($result['errcode'])!==0){
                $err[] = [
                    'tmp'=>$k,
                    'msg'=>$result['errmsg'],
                ];
                $num++;
            }
        }
        pdo_update("scmm_newtmpl",['tmpid'=>'','is_use'=>-1],['weid'=>$this->weid,'module'=>$this->modulename,'status'=>1]);
        return ['type'=>true,'msg'=>'清除成功','err'=>$num,'errlist'=>$err];
    }
    //删除已有模板
    private function deltmp($tmpid){
        $token = $this->TOken();
        $url = "https://api.weixin.qq.com/wxaapi/newtmpl/deltemplate?access_token={$token}";
        $post = ["priTmplId"=>$tmpid];
        $post = json_encode($post);
        $header = [
            "Content-Type: application/json",
            "Accept: application/json",
            "Content-Length: ".strlen($post)
        ];
        $res = $this->getcurl($url,$post,$header);
        $res = json_decode($res,true);
        return $res;
    }

    //获取已有模板
    private function gettmplist(){
        $token = $this->Token();
        $url = "https://api.weixin.qq.com/wxaapi/newtmpl/gettemplate?access_token={$token}";
        $res = $this->getcurl($url);
        $res = json_decode($res,true);
        if(intval($res['errcode'])===0){
            $list = [];
            foreach ($res['data'] as $k=>$v){
                $list[$v['priTmplId']] = $v;
            }
            return ['type'=>true,'data'=>$list];
        }else{
            return ['type'=>false,'msg'=>$res['errmsg']];
        }

    }

    //获取已添加分类
    private function getcategory(){
        $token = $this->Token();
        $url = "https://api.weixin.qq.com/wxaapi/newtmpl/getcategory?access_token={$token}";
        $info = $this->getcurl($url);
        $info = json_decode($info,true);
        return $info;
    }
    //获取添加模板错误代码返回信息
    private function getadderr($code){
        $msg = '';
        switch ($code){
            case 200014:
            $msg='模版 tid 参数错误';
            break;
            case 200020:
            $msg='关键词列表 kidList 参数错误';
            break;
            case 200021:
            $msg='场景描述 sceneDesc 参数错误';
            break;
            case 200011:
            $msg='此账号已被封禁，无法操作';
            break;
            case 200013:
            $msg='此模版已被封禁，无法选用';
            break;
            case 200012:
            $msg='个人模版数已达上限，上限25个';
            break;
            default:
            $msg = '未知错误';
            break;
        }
        return $msg;
    }
    //获取tonken
   private function Token()
    {
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

            return $_W['account']['access_tokne'];

        } else {

            return $_W['account']['access_tokne'];

        }

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

}
