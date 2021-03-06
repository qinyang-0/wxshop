<?php

$menu=array(
	"0"=>array(
		'name'=>'促销转化',
		"info"=>array(
			'0'=>array(
				'name'=>'优惠券',
				'title'=>'营销必备，券动客心',
				'url'=>"./index.php?c=site&a=entry&op=market&do=plsugins&m=group_buy&in=coupon",
				'icon'=>'/addons/group_buy/public/plug/coupon.png',
				'is_show'=>'1',
			),
			'1'=>array(
				'eng_name'=>'group_buy_plugin_seckill',
				'name'=>'整点秒杀',
				'title'=>'设置商品限时整点秒杀',
				'url'=>"./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_seckill&version_id=0",
				'icon'=>'/addons/group_buy/public/plug/spike.png',
				'is_show'=>'2',
			),
			'2'=>array(
				'eng_name'=>'group_buy_plugin_fraction',
				'name'=>'积分商城',
				'title'=>'设置商品限时整点秒杀',
				'url'=>"./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_fraction&version_id=0",
				'icon'=>'/addons/group_buy/public/plug/inter_shop.png',
				'is_show'=>'2',
			),
			'3'=>array(
				'name'=>'积分签到',
				'title'=>'天天签到积分获利',
				'url'=>"./index.php?c=site&a=entry&op=sign&do=plsugins&m=group_buy",
				'icon'=>'/addons/group_buy/public/plug/intar_sign.png',
				'is_show'=>'1',
			),
			'4'=>array(
				'name'=>'满减折扣',
				'title'=>'消费多少直接省钱',
				'url'=>"./index.php?c=site&a=entry&do=plsugins&m=group_buy&op=reduction&in=reduction",
				'icon'=>'/addons/group_buy/public/plug/reduction.png',
				'is_show'=>'1',
			),
			'5'=>array(
				'eng_name'=>'group_buy_plugin_bargain',
				'name'=>'砍价',
				'title'=>'邀请好友砍价后低价购买 引流+裂变吸粉',
				'url'=>"./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_bargain&version_id=0",
				'icon'=>'/addons/group_buy/public/plug/beragin.jpg',
				'is_show'=>'2',
			),
			'6'=>array(
				'eng_name'=>'group_buy_plugin_team',
				'name'=>'拼团',
				'title'=>'引导客户邀请朋友一起拼团购买',
				'url'=>"./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_team&version_id=0",
				'icon'=>'/addons/group_buy/public/plug/team.png',
				'is_show'=>'2',
			),
		),
	),
	"1"=>array(
		'name'=>'客户营销',
		"info"=>array(
			'0'=>array(
				'name'=>'会员卡',
				'title'=>'通过购买会员卡的方式成为会员',
				'url'=>"./index.php?c=site&a=entry&op=card&do=plsugins&m=group_buy",
				'icon'=>'/addons/group_buy/public/plug/member_group.png',
				'is_show'=>'1',
			),
			'1'=>array(
				'name'=>'消费会员',
				'title'=>'通过消费额度成为会员',
				'url'=>"",
				'icon'=>'/addons/group_buy/public/plug/con_member.png',
				'is_show'=>'2',
			),
			'2'=>array(
				'name'=>'余额充值',
				'title'=>'通过充值储值余额购物',
				'url'=>"./index.php?c=site&a=entry&op=recharge&in=index&do=plsugins&m=group_buy",
				'icon'=>'/addons/group_buy/public/plug/card.png',
				'is_show'=>'1',
			),
			'3'=>array(
				'name'=>'充值返利',
				'title'=>'通过充值获得余额返利',
				'url'=>"./index.php?c=site&a=entry&op=markrting&do=plsugins&m=group_buy",
				'icon'=>'/addons/group_buy/public/plug/markrting.png',
				'is_show'=>'1',
			),
			'4'=>array(
				'name'=>'团长配送',
				'title'=>'团长送货到家',
				'url'=>'./index.php?c=site&a=entry&op=delivery&do=plsugins&m=group_buy',
				'icon'=>'/addons/group_buy/public/plug/ps.png',
				'is_show'=>'1',
			),
			'5'=>array(
				'name'=>'积分抵扣',
				'title'=>'积分当钱用',
				'url'=>'./index.php?c=site&a=entry&op=deduction&do=plsugins&m=group_buy',
				'icon'=>'/addons/group_buy/public/plug/deduction.jpg',
				'is_show'=>'1',
			),
		),
	),
	"2"=>array(
		'name'=>'引流裂变',
		"info"=>array(
			'0'=>array(
				'eng_name'=>'group_buy_plugin_distribution',
				'name'=>'分销商城',
				'title'=>'三级分销，爆炸式推广',
				'url'=>"./index.php?c=home&a=welcome&do=ext&m=group_buy_plugin_distribution&version_id=0",
				'icon'=>'/addons/group_buy/public/plug/distribution.png',
				'is_show'=>'2',
			),
			'1'=>array(
				'name'=>'团长推荐',
				'title'=>'团长推荐团长，实力扩展',
				'url'=>"./index.php?c=site&a=entry&op=extension&do=plsugins&m=group_buy",
				'icon'=>'/addons/group_buy/public/plug/commander.png',
				'is_show'=>'1',
			),
		),
	),
    "3"=>array(
        'name'=>'运营辅助',
        "info"=>array(
            '0'=>array(
                'name'=>'虚拟用户',
                'title'=>'虚拟购买的时候显示的用户',
                'url'=>"./index.php?c=site&a=entry&op=fic_user&do=plsugins&m=group_buy",
                'icon'=>'/addons/group_buy/public/plug/fic_user.png',
                'is_show'=>'1',
            ),
        ),
    ),
);
echo json_encode($menu);
?>