<?php
/**
 * 订阅消息
 * User: orichi
 * Date: 2020/2/26
 * Time: 14:26
 */
include_once '../addons/group_buy/SubMsg.php';
include_once '../addons/group_buy/SubWechat.php';
global $_W, $_GPC;
$do = $_GPC['do'];
$op = $_GPC['op'];
empty($op) ? $op = 'index' : $op ;
$weid = $this->weid;  //控制模块
$_GPC['do'] = 'config';
switch($op){
    case 'index':
        $info = pdo_fetchall("select * from ".tablename("scmm_newtmpl")." where weid={$weid} and `module`='group_buy' and `status`=1");
        if(!empty($info)){
            $tmp = [];
            foreach ($info as $k=>$v){
                $tmp[$v['name']] = $v;
            }
            $info = $tmp;
        }
        $conf = pdo_fetchall("select `value`,`key` from ".tablename("gpb_config")." where weid={$weid} and `status`=1 and (`key`='wechat_secert' or `key`='wechat_appid' or `key`='refund_msg_openid')");
        if(!empty($conf)){
            $tmp = [];
            foreach ($conf as $k=>$v){
                $tmp[$v['key']] = $v['value'];
            }
            $conf = $tmp;
        }
        break;
    case 'change_use':
        //修改启用状态
        $name = $_GPC['name'];
        if(empty($name)){
            echo josn_encode(['status'=>1,'msg'=>'参数错误']);
            die;
        }
        //是否存在数据
        $info = pdo_get("scmm_newtmpl",['weid'=>$weid,'status'=>1,'module'=>'group_buy','name'=>$name]);
        if(empty($info)){
            echo josn_encode(['status'=>1,'msg'=>'模板不存在或已删除']);
            die;
        }
        $is_use = intval($info['is_use']);
        $is_use = -$is_use;
        $res = pdo_update("scmm_newtmpl",['is_use'=>$is_use],['weid'=>$weid,'status'=>1,'module'=>'group_buy','name'=>$name]);
        echo $res===false?json_encode(['status'=>1,'msg'=>'保存失败，请重试']):json_encode(['status'=>0,'msg'=>'修改成功']);
        die;
        break;
    case 'onebtnadd':
        //一键添加
        $SubMsg = new \SubMsg();
        $return = $SubMsg->onebtnadd();
        if($return['type']===false){
            $return['status'] = 1;
            echo json_encode($return);
            die;
        }else{
            $return['status'] = 0;
            echo json_encode($return);
            die;
        }
        break;
    case 'cleartemp':
        //一键清空模板库
        $SubMsg = new \SubMsg();
        $return = $SubMsg->cleartemp();
        if($return['type']===false){
            $return['status'] = 1;
            echo json_encode($return);
            die;
        }else{
            $return['status'] = 0;
            echo json_encode($return);
            die;
        }
        break;
    case 'changetmp':
        $SubMsg = new \SubMsg();
        $return = $SubMsg->changetmp();
        break;

    case 'addwechat':
        //一键获取公众号消息
        $subwechat = new \SubWechat();
        $return = $subwechat->addall();
        echo json_encode($return);
        die;
        break;
    case 'savewechat':
        //保存公众号信息
        $wechat_appid = !empty($_GPC['wechat_appid'])?trim($_GPC['wechat_appid']):'';
        $wechat_secert = !empty($_GPC['wechat_secert'])?trim($_GPC['wechat_secert']):'';
        $refund_msg_openid = !empty($_GPC['refund_msg_openid'])?trim($_GPC['refund_msg_openid']):'';
        if(!empty($wechat_appid)){
            $has = pdo_fetch("select * from ".tablename("gpb_config")." where `key`='wechat_appid' and weid={$weid} and `status`=1");
            if(!empty($has)){
                //更新
                $res = pdo_update("gpb_config",['value'=>$wechat_appid,'time'=>time()],['key'=>'wechat_appid','weid'=>$weid,'status'=>1]);
            }else{
                //修改
                $data = [
                    'name'=>'公众号appid',
                    'value'=>$wechat_appid,
                    'type'=>18,
                    'time'=>time(),
                    'weid'=>$weid,
                    'status'=>1,
                    'key'=>'wechat_appid'
                ];
                $res = pdo_insert('gpb_config',$data);
            }
        }
        if(!empty($wechat_secert)){
            $has = pdo_fetch("select * from ".tablename("gpb_config")." where `key`='wechat_secert' and weid={$weid} and `status`=1");
            if(!empty($has)){
                //更新
                $res = pdo_update("gpb_config",['value'=>$wechat_secert,'time'=>time()],['key'=>'wechat_secert','weid'=>$weid,'status'=>1]);
            }else{
                //修改
                $data = [
                    'name'=>'公众号secert',
                    'value'=>$wechat_secert,
                    'type'=>18,
                    'time'=>time(),
                    'weid'=>$weid,
                    'status'=>1,
                    'key'=>'wechat_secert'
                ];
                $res = pdo_insert('gpb_config',$data);
            }
        }
        if(!empty($refund_msg_openid)){
            $has = pdo_fetch("select * from ".tablename("gpb_config")." where `key`='refund_msg_openid' and weid={$weid} and `status`=1");
            if(!empty($has)){
                //更新
                $res = pdo_update("gpb_config",['value'=>$refund_msg_openid,'time'=>time()],['key'=>'refund_msg_openid','weid'=>$weid,'status'=>1]);
            }else{
                //修改
                $data = [
                    'name'=>'接收退款信息管理员',
                    'value'=>$refund_msg_openid,
                    'type'=>18,
                    'time'=>time(),
                    'weid'=>$weid,
                    'status'=>1,
                    'key'=>'refund_msg_openid'
                ];
                $res = pdo_insert('gpb_config',$data);
            }
        }
        echo $res===false?json_encode(['status'=>0,'msg'=>'保存失败，请重试']):json_encode(['status'=>0,'msg'=>'保存成功']);
        die;
        break;

}
include $this -> template('web/' . $do . '/' . $op);