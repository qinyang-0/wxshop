<?php
/*
 * 秒杀入口设置
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
        //秒杀入口设置
        if($_GPC['submit'] == '提交'){
            //提交数据
//            var_dump($_POST);exit;
            unset($_POST['submit']);
            pdo_begin();
            foreach ($_POST as $k =>$v){
                $sql = "update ".tablename('gpb_config')." set `value` = '".$v."',time=".time()." where id =".$k;
                $res = pdo_query($sql);
            }
            pdo_commit();
            if(!empty($res)){
                $this->message_info("修改配置成功",$this->createWebUrl('cover',array('op'=>'index')), 'success');
            }else{
                $this->message_info("修改配置失败");
            }
        }else{
            //秒杀入口关键词
            $seckill_cover_key = pdo_get('gpb_config',array('key'=>'seckill_cover_key','weid'=>$weid));
            if(empty($seckill_cover_key) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('秒杀入口关键词','','14',".time().",".$weid.",1,'seckill_cover_key');");
            }
            //秒杀入口封面标题
            $seckill_cover_title = pdo_get('gpb_config',array('key'=>'seckill_cover_title','weid'=>$weid));
            if(empty($seckill_cover_title) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('秒杀入口封面标题','','14',".time().",".$weid.",1,'seckill_cover_title');");
            }
            //秒杀入口封面图
            $seckill_cover_img = pdo_get('gpb_config',array('key'=>'seckill_cover_img','weid'=>$weid));
            if(empty($seckill_cover_img) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('秒杀入口封面图','','14',".time().",".$weid.",1,'seckill_cover_img');");
            }
            //秒杀入口封面描述
            $seckill_cover_des = pdo_get('gpb_config',array('key'=>'seckill_cover_des','weid'=>$weid));
            if(empty($seckill_cover_des) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('秒杀入口封面描述','','14',".time().",".$weid.",1,'seckill_cover_des');");
            }
            //关键词状态
            $seckill_cover_key_state = pdo_get('gpb_config',array('key'=>'seckill_cover_key_state','weid'=>$weid));
            if(empty($seckill_cover_key_state) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('关键词状态','2','14',".time().",".$weid.",1,'seckill_cover_key_state');");

            }
            //秒杀超时自动取消订单
            $seckill_over_time_close = pdo_get('gpb_config',array('key'=>'seckill_over_time_close','weid'=>$weid));
            if(empty($seckill_over_time_close) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('秒杀超时自动取消订单','1','14',".time().",".$weid.",1,'seckill_over_time_close');");
            }
            //秒杀列表页小图标
            $seckill_goods_list_icon = pdo_get('gpb_config',array('key'=>'seckill_goods_list_icon','weid'=>$weid));
            if(empty($seckill_goods_list_icon) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('秒杀列表页小图标','/addons/group_buy/public/bg/seckill_goods_list_icon.png','14',".time().",".$weid.",1,'seckill_goods_list_icon');");
            }
            //秒杀详情页价格显示背景色
            $seckill_goods_info_price_bg = pdo_get('gpb_config',array('key'=>'seckill_goods_info_price_bg','weid'=>$weid));
            if(empty($seckill_goods_info_price_bg) ){
                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('秒杀详情页价格显示背景色','#fde529','14',".time().",".$weid.",1,'seckill_goods_info_price_bg');");
            }
            $seckill_cover_key = pdo_get('gpb_config',array('key'=>'seckill_cover_key','weid'=>$weid));
            $seckill_cover_title = pdo_get('gpb_config',array('key'=>'seckill_cover_title','weid'=>$weid));
            $seckill_cover_img = pdo_get('gpb_config',array('key'=>'seckill_cover_img','weid'=>$weid));
            $seckill_cover_des = pdo_get('gpb_config',array('key'=>'seckill_cover_des','weid'=>$weid));
            $seckill_cover_key_state = pdo_get('gpb_config',array('key'=>'seckill_cover_key_state','weid'=>$weid));
            $seckill_over_time_close = pdo_get('gpb_config',array('key'=>'seckill_over_time_close','weid'=>$weid));
            $seckill_goods_list_icon = pdo_get('gpb_config',array('key'=>'seckill_goods_list_icon','weid'=>$weid));
            $seckill_goods_info_price_bg = pdo_get('gpb_config',array('key'=>'seckill_goods_info_price_bg','weid'=>$weid));
        }
        break;
//    case 'xxx':
//        //专题列表
//        global $_W;
//        global $_GPC;
//        $rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => '整点秒杀入口设置'));
//
//        if (!empty($rule)) {
//            $keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
//            $cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
//        }
//
//        $url = mobileUrl('seckill', NULL, true);
//        $qrcode = m('qrcode')->createQrcode($url);
//
//        if ($_W['ispost']) {
//            $data = is_array($_GPC['cover']) ? $_GPC['cover'] : array();
//
//            if (empty($data['keyword'])) {
//                $this->message_info('请输入关键词!');
//            }
//
//            $keyword = m('common')->keyExist($data['keyword']);
//
//            if (!empty($keyword)) {
//                if ($keyword['name'] != '整点秒杀入口设置') {
//                    $this->message_info('关键字已存在!');
//                }
//            }
//
//            if (!empty($rule)) {
//                pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
//                pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
//                pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
//            }
//
//            $rule_data = array('uniacid' => $_W['uniacid'], 'name' => '整点秒杀入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
//            pdo_insert('rule', $rule_data);
//            $rid = pdo_insertid();
//            $keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
//            pdo_insert('rule_keyword', $keyword_data);
//            $cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => $this->modulename, 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => save_media($data['thumb']), 'url' => mobileUrl('seckill'));
//            pdo_insert('cover_reply', $cover_data);
//            plog('seckill.cover.edit', '修改整点秒杀入口设置');
//            show_json(1);
//        }
//        break;

}
include $this -> template('web/' . $do . '/' . $op);
?>