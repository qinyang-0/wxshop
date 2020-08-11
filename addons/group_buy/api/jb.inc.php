<?php
$array = array(
//	'gpb_action',
//	'gpb_action_goods',
//	'gpb_action_village',
//	'gpb_activity_plugin_virtual_buy_list',
//	'gpb_activity_plugin_virtual_users',
//	'gpb_application_header',
//	'gpb_area',
//	'gpb_article',
//	'gpb_article_class',
//	'gpb_auto',
//	'gpb_back_money',
//	'gpb_banner',
//	'gpb_bargain_action',
//	'gpb_bargaion_goods',
//	'gpb_bargaion_record',
//	'gpb_cart',
//	'gpb_config',
//	'gpb_consumption_info',
//	'gpb_distribution_cash_money',
//	'gpb_distribution_group',
//	'gpb_distribution_group_log',
//	'gpb_distribution_list',
//	'gpb_distribution_list_order',
//	'gpb_distribution_log',
//	'gpb_distribution_menu',
//	'gpb_distribution_money',
//	'gpb_distribution_money_log',
//	'gpb_distribution_route',
//	'gpb_distrution_commond_log',
//	'gpb_diy_page',
//	'gpb_diy_temp',
//	'gpb_express',
//	'gpb_express_shipping',
//	'gpb_get_cash',
	'gpb_goods',
	'gpb_goods_cate',
	'gpb_goods_option',
	'gpb_goods_spec',
	'gpb_goods_spec_item',
	'gpb_goods_stock',
	'gpb_goods_stock_logs',
	'gpb_goods_to_category',
//	'gpb_head_commond_log',
//	'gpb_head_group',
//	'gpb_head_group_log',
//	'gpb_head_history',
//	'gpb_head_money',
//	'gpb_head_money_log',
//	'gpb_head_route',
//	'gpb_level',
//	'gpb_mail',
//	'gpb_member',
//	'gpb_member_card',
//	'gpb_member_card_order',
//	'gpb_member_card_time',
//	'gpb_member_integral_check',
//	'gpb_menu',
//	'gpb_menu_list',
//	'gpb_order',
//	'gpb_order_log',
//	'gpb_order_snapshot',
//	'gpb_order_stream',
//	'gpb_package_goods',
//	'gpb_package_goods_option',
//	'gpb_plug',
//	'gpb_receiving_address',
//	'gpb_recharge',
//	'gpb_recharge_info',
//	'gpb_recharge_list',
//	'gpb_recharge_log',
//	'gpb_region',
//	'gpb_send_ticket_set',
//	'gpb_shop_seckill_adv',
//	'gpb_shop_seckill_category',
//	'gpb_shop_seckill_task',
//	'gpb_shop_seckill_task_goods',
//	'gpb_shop_seckill_task_room',
//	'gpb_shop_seckill_task_time',
//	'gpb_spec_item',
//	'gpb_supplier',
//	'gpb_supplier_manger',
//	'gpb_sure_order',
//	'gpb_team_cancel_goods',
//	'gpb_ticket',
//	'gpb_user_ticket',
//	'gpb_village',
//	'gpb_user_distribution_log',
);
load()->func('db');
$str = '';
foreach($array as $k=>$v){
	$all = pdo_getall($v);
	if($all){
		$str .= "insert into `ims_".$v."` ("; 
		$scahema = db_table_schema(pdo(), $v);
		if($scahema['fields']){
			$i=0;
			foreach($scahema['fields'] as $kk=>$vv){
				if($i != 0){
					$str .= "`".$vv['name']."`,";
				}
				$i++;
			}
			$str = trim($str,',');
			$str .= ") values ";
		}
		foreach($all as $kk=>$vv){
			$i=0;
			$str .= " (";
			foreach($vv as $kkk=>$vvv){
				if($i != 0){
					if($kkk == 'weid'){
						$str .= "'3',";
					}else{
						$str .= "'".$vvv."',";
					}
				}
				$i++;
			}
			$str = trim($str,',');
			$str .= "),";
		}
		$str = trim($str,',');
		$str .= "\n";
	}
}
$mp = fopen('../addons/2.txt','w');
fwrite($mp, $str);
fclose($mp);
exit('1');
?>