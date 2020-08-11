<?php
//    pdo_get("gpb_goods",array('g_id'=>1));
    //查询绑定的团队表
    $distribution_group = pdo_getall('gpb_distribution_group',array('id >'=>0));
    if(is_array($distribution_group)){
        foreach ($distribution_group as $k =>$v){
            $id = $v['leader_id'];
            $v1 = explode(",",$v['lv1']);
            $v2 = explode(",",$v['lv2']);
            $v3 = explode(",",$v['lv3']);
            if(is_array($v1)){
                foreach ($v1 as $k1=>$v1_v){
                    if($v1_v == $id){
                        unset($v1[$k1]);
                    }
                }
            }
            if(is_array($v2)){
                foreach ($v2 as $k2=>$v2_v){
                    if($v2_v == $id){
                        unset($v2[$k2]);
                    }
                    if(is_array($v1)){
                        if(in_array($v2_v,$v1)){
                            unset($v2[$k2]);
                            continue;
                        }
                    }
                }
            }
            if(is_array($v3)){
                foreach ($v3 as $k3 =>$v3_v){
                    if($v3_v == $id){
                        unset($v3[$k3]);
                        continue;
                    }
                    if(is_array($v1)){
                        if(in_array($v3_v,$v1)){
                            unset($v3[$k3]);
                            continue;
                        }
                    }
                    if(is_array($v2)){
                        if(in_array($v3_v,$v2)){
                            unset($v3[$k3]);
                            continue;
                        }
                    }
                }
            }
            pdo_update('gpb_distribution_group',array('lv1'=>implode(',',$v1),'lv2'=>implode(',',$v2),'lv3'=>implode(',',$v3)),array('id'=>$v['id']));
            unset($v1);
            unset($v2);
            unset($v3);
        }
    }
if(!pdo_fieldexists('gpb_distribution_money', 'qr_code')) {
    pdo_query("ALTER TABLE ".tablename('gpb_distribution_money')." ADD COLUMN `qr_code` TEXT NULL COMMENT '二维码';");
}
if(!pdo_fieldexists('gpb_distribution_money', 'code_num')) {
    pdo_query("ALTER TABLE ".tablename('gpb_distribution_money')." ADD COLUMN `code_num` CHAR(10) NOT NULL COMMENT '推广码';");
}
//2019-6-26
pdo_query("DROP TABLE IF EXISTS ".tablename('gpb_distribution_menu').";");
if(!pdo_tableexists('gpb_distribution_menu')) {
    pdo_query("CREATE TABLE ".tablename('gpb_distribution_menu')." (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分销菜单',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `title` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '菜单名称',
  `long_title` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '长标题',
  `url` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '跳转链接',
  `deep` int(2) NOT NULL DEFAULT '1' COMMENT '深度',
  `top_do` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '上级操作名',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `icon` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '菜单图标',
  `create_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `update_time` varchar(11) COLLATE utf8_bin NOT NULL DEFAULT '00000000000',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
}
pdo_query(" truncate table ".tablename('gpb_distribution_menu'));
pdo_run("insert  into ".tablename('gpb_distribution_menu')." (`id`,`pid`,`title`,`long_title`,`url`,`deep`,`top_do`,`sort`,`icon`,`create_time`,`update_time`,`status`) values (1,0,'分销配置','','config',1,'',15,'icon-setting','00000000000','00000000000',1),(2,0,'分销中心','','User',1,'',10,'icon-user','00000000000','00000000000',1),(3,1,'基本设置','分销设置','config_state',2,'config',0,'','00000000000','00000000000',1),(4,1,'佣金设置','分销设置','config_money',2,'config',0,'','00000000000','00000000000',1),(5,0,'首页','系统首页','home',1,NULL,0,'icon-home','00000000000','00000000000',-1),(6,1,'审核设置','分销设置','config_exa',2,'config',0,'','00000000000','00000000000',1),(7,1,'推荐奖设置','分销设置','config_commoned',2,'config',0,NULL,'00000000000','00000000000',1),(8,2,'提现审核','分销设置','config_exa_list',2,'User',10,'','00000000000','00000000000',1),(9,2,'团队列表','','UserList',2,'User',0,'','00000000000','00000000000',1),(10,2,'审核列表','','exalist',2,'User',0,'','00000000000','00000000000',1),(11,1,'提现设置','','config_cash',2,'config',100,'','00000000000','00000000000',1),(12,0,'专题管理','专题管理','index',1,'index',0,NULL,'00000000000','00000000000',2),(13,0,'会场管理','会场管理','room',1,'room',0,NULL,'00000000000','00000000000',2),(14,0,'商品管理','商品管理','goods',1,'goods',0,NULL,'00000000000','00000000000',2),(15,0,'分类管理','分类管理','category',1,'category',0,NULL,'00000000000','00000000000',2),(16,0,'广告管理','幻灯片管理','adv',1,'adv',0,NULL,'00000000000','00000000000',2),(17,0,'设置','设置','calendar',1,'calendar',0,NULL,'00000000000','00000000000',2),(18,17,'任务设置','任务设置','calendar',2,'calendar',0,NULL,'00000000000','00000000000',2),(19,17,'入口设置','入口设置','cover',2,'cover',0,NULL,'00000000000','00000000000',2),(20,1,'申请页配置','分销设置','config_put',2,'config',0,'','00000000000','00000000000',1);");
