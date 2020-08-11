<?php 
$http = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'];
$data = array (
                0 => array (
                        'id' => '1',
                        'weid' => '0',
                        'content' =>
                            serialize(array (
                                    'data' =>
                                        array (
                                            0 =>
                                                array (
                                                    'id' => 'm1548983827233',
                                                    'name' => 'head',
                                                    'params' =>
                                                        array (
                                                            'head_module' => '3',
                                                            'content' => '',
                                                            'showAddress' => '0',
                                                            'rightTpye' => '1',
                                                            'incolor' => '#eeeeee',
                                                            'border_color' => '#eeeeee',
                                                            'bgcolor' => '#ffffff',
                                                            'text' => '搜索商品',
                                                            'text_color' => '#cccccc',
                                                            'border_radius' => '12',
                                                            'search_width' => '76',
                                                        ),
                                                ),
                                            1 =>
                                                array (
                                                    'id' => 'm1548983995047',
                                                    'name' => 'slide',
                                                    'params' =>
                                                        array (
                                                            'ischange' => '0',
                                                            'changetime' => '3',
                                                            'changelast' => '500',
                                                            'pointcolor' => '#dddddd',
                                                            'actcolor' => '#22c397',
                                                            'showpoint' => '0',
                                                            'height' => '150',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/personal/supplier',
                                                                            'url_name' => '申请供应商页',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/y89ThvIIA6tc2HSSHY5JKvavCsJ8eV.png',
                                                                        ),
                                                                    1 =>
                                                                        array (
                                                                            'id' => 'g1548984006208',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/group/groupApply',
                                                                            'url_name' => '申请团长页',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/g6jLASziZnIII6nwNw1nI08i6daaIN.png',
                                                                        ),
                                                                    2 =>
                                                                        array (
                                                                            'id' => 'g1555306830375',
                                                                            'type' => 'url',
                                                                            'url' => '',
                                                                            'url_name' => '',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/kdIon18nF117DdgQDyYZdqU1UI8D1Y.png',
                                                                        ),
                                                                ),
                                                            'radius' => '10',
                                                            'margin_top' => '5',
                                                            'margin_boottom' => '5',
                                                            'margin_left' => '5',
                                                            'margin_right' => '5',
                                                            'point_type' => '2',
                                                        ),
                                                ),
                                            2 =>
                                                array (
                                                    'id' => 'm1548983841984',
                                                    'name' => 'buyTitle',
                                                    'params' =>
                                                        array (
                                                            'module' => '3',
                                                            'color' => '#ffffff',
                                                            'bgcolor' => '#ff4848',
                                                            'timeColor' => '#ffffff',
                                                            'timeBgcolor' => '#505050',
                                                            'limitTitle' => '正在抢购',
                                                            'limitTitleDown' => '每日更新',
                                                            'nextTitle' => '下期预告',
                                                            'nextTitleDown' => '限时开抢',
                                                            'nocolor' => '#333',
                                                            'nobgcolor' => '#eee',
                                                            'pic' => $http.'/addons/group_buy/public/diyimages/index-tab-left-active.png',
                                                            'nopic' => $http.'/addons/group_buy/public/diyimages/index-tab-left-disabled.png',
                                                        ),
                                                ),
                                            3 =>
                                                array (
                                                    'id' => 'm1548983843177',
                                                    'name' => 'cate',
                                                    'params' =>
                                                        array (
                                                            'border_color' => '#000000',
                                                            'color' => '#000',
                                                            'mrcolor' => '#b0b0b0',
                                                            'bgcolor' => '#ff4848',
                                                        ),
                                                ),
                                            4 =>
                                                array (
                                                    'id' => 'm1548984145632',
                                                    'name' => 'goods',
                                                    'params' =>
                                                        array (
                                                            'goods_title_module' => '0',
                                                            'goods_module' => '2',
                                                            'is_class' => '0',
                                                            'num' => '10',
                                                            'is_hot' => '0',
                                                            'is_new' => '1',
                                                            'margin' => '4',
                                                        ),
                                                ),
                                            5 =>
                                                array (
                                                    'id' => 'm1548836775341',
                                                    'name' => 'bars',
                                                    'params' =>
                                                        array (
                                                            'radius' => '0',
                                                            'padding' => '5',
                                                            'bgcolor' => '#ffffff',
                                                            'fontcolor' => '#000',
                                                            'actcolor' => '#dd4f43',
                                                            'num' => '4',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'title' => '首页',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/YXCycWx3HB7wuz3C7c8IZ0xxxzX95w.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/I36l1Jm8529V6vvnSV65YhY1Smy69h.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/index',
                                                                            'url_name' => '首页',
                                                                        ),
                                                                    1 =>
                                                                        array (
                                                                            'id' => '00000004',
                                                                            'title' => '分类',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/AEvTQbe0hthcEaZBBB0HTJbDBj8h7C.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/zZcZcD08wZccwtB0cac0VB7t7TZc7B.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/classify',
                                                                            'url_name' => '产品分类列表',
                                                                        ),
                                                                    2 =>
                                                                        array (
                                                                            'id' => '00000002',
                                                                            'title' => '购物车',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/ZJX3jtCnc3VONHT3jyWd7Vnt32VtbV.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/All52tonUZ6J4dO2TCCBgsYGOLON61.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/cart',
                                                                            'url_name' => '购物车',
                                                                        ),
                                                                    3 =>
                                                                        array (
                                                                            'id' => '00000003',
                                                                            'title' => '我的',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/OyuF58qu8oVGZ3Zfx1oX5f8c5xWW4U.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/gZmmdWt3WPvAJ9RbVfwhzaQBggTmdP.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/personal/personal',
                                                                            'url_name' => '个人中心',
                                                                        ),
                                                                    4 =>
                                                                        array (
                                                                            'id' => '00000005',
                                                                            'title' => '导航名称',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'type' => 'url',
                                                                            'url' => '',
                                                                        ),
                                                                ),
                                                            'content' => '',
                                                        ),
                                                ),
                                        ),
                                    'basic' =>
                                        array (
                                            'id' => '0000000',
                                            'name' => '',
                                            'title' => '团购演示风格1',
                                            'sharetitle' => '',
                                            'shareimg' => '',
                                            'isbar' => '0',
                                            'topbg' => '#ffffff',
                                            'topcolor' => '#000000',
                                            'allbg' => '#ffffff',
                                        ),
                                )
                            ),
                        'createtime' => '1548836757',
                        'name' => NULL,
                        'tempid' => '1',
                        'status' => '1',
                        'system' => '2',
                    ),
                1 =>
                    array (
                        'id' => '2',
                        'weid' => '0',
                        'content' =>
                            serialize(array (
                                    'data' =>
                                        array (
                                            0 =>
                                                array (
                                                    'id' => 'm1548816385107',
                                                    'name' => 'slide',
                                                    'params' =>
                                                        array (
                                                            'ischange' => '0',
                                                            'changetime' => '3',
                                                            'changelast' => '500',
                                                            'pointcolor' => '#dddddd',
                                                            'actcolor' => '#22c397',
                                                            'showpoint' => '0',
                                                            'height' => '150',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/group/groupApply',
                                                                            'url_name' => '申请团长页',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/zGTO48664tgooR46tsHShmYTE48Trg.jpg',
                                                                        ),
                                                                    1 =>
                                                                        array (
                                                                            'id' => 'g1548816397444',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/personal/supplier',
                                                                            'url_name' => '申请供应商页',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/QFfpl126JMBlNlAL6FLP7SekkL2PMS.jpg',
                                                                        ),
                                                                ),
                                                            'radius' => '0',
                                                            'margin' => '4',
                                                            'margin_top' => '0',
                                                            'margin_boottom' => '0',
                                                            'margin_left' => '0',
                                                            'margin_right' => '0',
                                                        ),
                                                ),
                                            1 =>
                                                array (
                                                    'id' => 'm1548469872895',
                                                    'name' => 'head',
                                                    'params' =>
                                                        array (
                                                            'type' => '1',
                                                            'head_module' => '1',
                                                            'margin' => '5',
                                                            'radius' => '10',
                                                        ),
                                                ),
                                            2 =>
                                                array (
                                                    'id' => 'm1548913537421',
                                                    'name' => 'coupon',
                                                    'params' =>
                                                        array (
                                                            'padding' => '0',
                                                            'type' => '1',
                                                            'istext' => '0',
                                                            'fontsize' => '14',
                                                            'fontcolor' => '#333',
                                                            'bgcolor' => '#ffffff',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/t8Ic5L1T99cIEiItZ3UwDlneGC8Ino.png',
                                                                            'url' => '/pages/template/coupon',
                                                                            'title' => '',
                                                                            'type' => 'url',
                                                                        ),
                                                                ),
                                                        ),
                                                ),
                                            3 =>
                                                array (
                                                    'id' => 'm1548897284424',
                                                    'name' => 'buyTitle',
                                                    'params' =>
                                                        array (
                                                            'module' => '2',
                                                            'color' => '#ffffff',
                                                            'bgcolor' => '#000000',
                                                            'timeColor' => '#ffffff',
                                                            'timeBgcolor' => '#ff0000',
                                                            'limitTitle' => '限时抢购',
                                                        ),
                                                ),
                                            4 =>
                                                array (
                                                    'id' => 'm1548469535713',
                                                    'name' => 'goods',
                                                    'params' =>
                                                        array (
                                                            'type' => '2',
                                                            'is_class' => '0',
                                                            'num' => '10',
                                                            'goods_module' => '3',
                                                            'content' => '',
                                                            'goods_title_module' => '0',
                                                            'is_new' => '0',
                                                            'is_hot' => '1',
                                                        ),
                                                ),
                                            5 =>
                                                array (
                                                    'id' => 'm1548656059308',
                                                    'name' => 'space',
                                                    'params' =>
                                                        array (
                                                            'height' => '11',
                                                            'bgcolor' => '#f3f4f5',
                                                            'content' => '',
                                                        ),
                                                ),
                                            6 =>
                                                array (
                                                    'id' => 'm1548654541438',
                                                    'name' => 'bars',
                                                    'params' =>
                                                        array (
                                                            'radius' => '0',
                                                            'padding' => '0',
                                                            'bgcolor' => '#ffffff',
                                                            'fontcolor' => '#000',
                                                            'actcolor' => '#f1646b',
                                                            'num' => '4',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'title' => '首页',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/dm16wMz81LFtct8TcC54F1cZcfTRWM.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/CPVpAyVPAfUoZSNpAOaaeVYNoPPnMa.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/index',
                                                                            'url_name' => '首页',
                                                                        ),
                                                                    1 =>
                                                                        array (
                                                                            'id' => '00000002',
                                                                            'title' => '分类',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/PBeZG4zP0lG34BA0B6GYP0G9YbLyp9.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/cKqTkKievkt4e3eN2UlkV4e4k2QKiq.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/classify',
                                                                            'url_name' => '产品分类列表',
                                                                        ),
                                                                    2 =>
                                                                        array (
                                                                            'id' => '00000003',
                                                                            'title' => '购物车',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/KOCmmVbQzoCTO4oYbDBYe4DsJEQcmD.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/Mqa61tk6jGZ6zZ3K67kjjZQ4J54K6g.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/cart',
                                                                            'url_name' => '购物车',
                                                                        ),
                                                                    3 =>
                                                                        array (
                                                                            'id' => '00000004',
                                                                            'title' => '我的',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/Dw8260M5E7Swqs64EMS896ss653w4Z.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/XngrYHNK7KKNZ5aHoon9EdZZhr93R5.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/personal/personal',
                                                                            'url_name' => '个人中心',
                                                                        ),
                                                                    4 =>
                                                                        array (
                                                                            'id' => '00000005',
                                                                            'title' => '导航名称',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'type' => 'url',
                                                                            'url' => '',
                                                                        ),
                                                                ),
                                                        ),
                                                ),
                                        ),
                                    'basic' =>
                                        array (
                                            'id' => '0000000',
                                            'name' => '',
                                            'title' => '首页',
                                            'sharetitle' => '',
                                            'shareimg' => '',
                                            'isbar' => '0',
                                            'topbg' => '#fc4443',
                                            'topcolor' => '#ffffff',
                                            'allbg' => '#ffffff',
                                        ),
                                )
                            ),
                        'createtime' => '1548294695',
                        'name' => NULL,
                        'tempid' => '2',
                        'status' => '1',
                        'system' => '2',
                    ),
                2 =>
                    array (
                        'id' => '3',
                        'weid' => '0',
                        'content' =>
                            serialize(array (
                                    'data' =>
                                        array (
                                            0 =>
                                                array (
                                                    'id' => 'm1548983827233',
                                                    'name' => 'head',
                                                    'params' =>
                                                        array (
                                                            'head_module' => '2',
                                                            'content' => '',
                                                            'showAddress' => '0',
                                                            'rightTpye' => '1',
                                                            'incolor' => '#eeeeee',
                                                            'border_color' => '#eeeeee',
                                                            'bgcolor' => '#ffffff',
                                                            'text' => '搜索商品',
                                                            'text_color' => '#cccccc',
                                                            'border_radius' => '12',
                                                            'search_width' => '72',
                                                        ),
                                                ),
                                            1 =>
                                                array (
                                                    'id' => 'm1548983843177',
                                                    'name' => 'cate',
                                                    'params' =>
                                                        array (
                                                            'border_color' => '#000000',
                                                            'color' => '#ff',
                                                            'mrcolor' => '#b0b0b0',
                                                            'bgcolor' => '#ffec33',
                                                        ),
                                                ),
                                            2 =>
                                                array (
                                                    'id' => 'm1548983995047',
                                                    'name' => 'slide',
                                                    'params' =>
                                                        array (
                                                            'ischange' => '0',
                                                            'changetime' => '3',
                                                            'changelast' => '500',
                                                            'pointcolor' => '#dddddd',
                                                            'actcolor' => '#ffffff',
                                                            'showpoint' => '1',
                                                            'height' => '150',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/coupon',
                                                                            'url_name' => '优惠券列表',
                                                                            'img' =>  $http.'/addons/group_buy/public/diyimages/kdIon18nF117DdgQDyYZdqU1UI8D1Y.png',
                                                                        ),
                                                                    1 =>
                                                                        array (
                                                                            'id' => 'g1548984006208',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/personal/supplier',
                                                                            'url_name' => '申请供应商页',
                                                                            'img' =>  $http.'/addons/group_buy/public/diyimages/y89ThvIIA6tc2HSSHY5JKvavCsJ8eV.png',
                                                                        ),
                                                                    2 =>
                                                                        array (
                                                                            'id' => 'g1554693075613',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/group/groupApply',
                                                                            'url_name' => '申请团长页',
                                                                            'img' =>  $http.'/addons/group_buy/public/diyimages/g6jLASziZnIII6nwNw1nI08i6daaIN.png',
                                                                        ),
                                                                ),
                                                            'radius' => '10',
                                                            'margin_top' => '5',
                                                            'margin_boottom' => '5',
                                                            'margin_left' => '5',
                                                            'margin_right' => '5',
                                                            'point_type' => '2',
                                                            'point_align' => '3',
                                                        ),
                                                ),
                                            3 =>
                                                array (
                                                    'id' => 'm1555300800045',
                                                    'name' => 'image',
                                                    'params' =>
                                                        array (
                                                            'padding' => '1',
                                                            'type' => '1',
                                                            'istext' => '0',
                                                            'fontsize' => '14',
                                                            'fontcolor' => '#333',
                                                            'bgcolor' => '#ffffff',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/iZWQ6dXAd1rqQQPD31dAx2n261kwZ7.png',
                                                                            'url' => '',
                                                                            'title' => '',
                                                                            'type' => 'url',
                                                                        ),
                                                                ),
                                                        ),
                                                ),
                                            4 =>
                                                array (
                                                    'id' => 'm1548983841984',
                                                    'name' => 'buyTitle',
                                                    'params' =>
                                                        array (
                                                            'module' => '1',
                                                            'color' => '#f',
                                                            'bgcolor' => '#ffec33',
                                                            'timeColor' => '#ffffff',
                                                            'timeBgcolor' => '#505050',
                                                            'limitTitle' => '正在抢购',
                                                            'limitTitleDown' => '每日更新',
                                                            'nextTitle' => '下期预告',
                                                            'nextTitleDown' => '限时开抢',
                                                            'nocolor' => '#333',
                                                            'nobgcolor' => '#eee',
                                                            'pic' => $http.'/addons/group_buy/public/diyimages/f1YPhXplYyxsoNiNa8EnS3ZYEaXa5P.png',
                                                            'nopic' => $http.'/addons/group_buy/public/diyimages/Dhlm5HFF7rF07lDoZU45zHsd0oH4OM.png',
                                                        ),
                                                ),
                                            5 =>
                                                array (
                                                    'id' => 'm1548984145632',
                                                    'name' => 'goods',
                                                    'params' =>
                                                        array (
                                                            'goods_title_module' => '0',
                                                            'goods_module' => '2',
                                                            'is_class' => '0',
                                                            'num' => '10',
                                                            'is_hot' => '1',
                                                            'is_new' => '0',
                                                            'margin' => '0',
                                                        ),
                                                ),
                                            6 =>
                                                array (
                                                    'id' => 'm1548836775341',
                                                    'name' => 'bars',
                                                    'params' =>
                                                        array (
                                                            'radius' => '0',
                                                            'padding' => '5',
                                                            'bgcolor' => '#ffffff',
                                                            'fontcolor' => '#9f9f9f',
                                                            'actcolor' => '#000',
                                                            'num' => '3',
                                                            'data' =>
                                                                array (
                                                                    0 =>
                                                                        array (
                                                                            'id' => '00000001',
                                                                            'title' => '首页',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/T2k4X2E2rnO9oK92I1e6R9i099D4o2.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/BKRlXqq7f7xa6l78QrLS6gK2g2LDdT.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/index',
                                                                            'url_name' => '首页',
                                                                        ),
                                                                    1 =>
                                                                        array (
                                                                            'id' => '00000002',
                                                                            'title' => '购物车',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/V44oge8NSeqJO3gkWNeWQy4OYLn45Y.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/hc3G3TpNZPn3pNPggGiJg6ZcXxgcGX.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/cart',
                                                                            'url_name' => '购物车',
                                                                        ),
                                                                    2 =>
                                                                        array (
                                                                            'id' => '00000003',
                                                                            'title' => '我的',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/TX8tu28bP8oZPxOjZ8FNo88P228u2o.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/UR4t42e855812OdunnPI1r40v2PuaZ.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/personal/personal',
                                                                            'url_name' => '个人中心',
                                                                        ),
                                                                    3 =>
                                                                        array (
                                                                            'id' => '00000004',
                                                                            'title' => '导航名称',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'type' => 'url',
                                                                            'url' => '/pages/template/classify',
                                                                            'url_name' => '产品分类列表',
                                                                        ),
                                                                    4 =>
                                                                        array (
                                                                            'id' => '00000005',
                                                                            'title' => '导航名称',
                                                                            'img' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'actimg' => $http.'/addons/group_buy/public/diyimages/no.png',
                                                                            'type' => 'url',
                                                                            'url' => '',
                                                                        ),
                                                                ),
                                                            'content' => '',
                                                        ),
                                                ),
                                        ),
                                    'basic' =>
                                        array (
                                            'id' => '0000000',
                                            'name' => '',
                                            'title' => '团购演示风格2',
                                            'sharetitle' => '',
                                            'shareimg' => '',
                                            'isbar' => '0',
                                            'topbg' => '#ffffff',
                                            'topcolor' => '#000000',
                                            'allbg' => '#ffffff',
                                        ),
                                )
                            ),
                        'createtime' => '1548985346',
                        'name' => NULL,
                        'tempid' => '3',
                        'status' => '1',
                        'system' => '2',
                    ),
                    4=>array(
				'id' => '4',
                'weid' => '0',
                'content'=>serialize(array (
					  'data' => 
					  array (
					    0 => 
					    array (
					      'id' => 'm1548983827233',
					      'name' => 'head',
					      'params' => 
					      array (
					        'head_module' => '3',
					        'content' => '',
					        'showAddress' => '0',
					        'rightTpye' => '1',
					        'incolor' => '#eeeeee',
					        'border_color' => '#eeeeee',
					        'bgcolor' => '#ffffff',
					        'text' => '搜索商品',
					        'text_color' => '#cccccc',
					        'border_radius' => '12',
					        'search_width' => '76',
					      ),
					    ),
					    1 => 
					    array (
					      'id' => 'm1548983995047',
					      'name' => 'slide',
					      'params' => 
					      array (
					        'ischange' => '0',
					        'changetime' => '3',
					        'changelast' => '500',
					        'pointcolor' => '#dddddd',
					        'actcolor' => '#22c397',
					        'showpoint' => '0',
					        'height' => '150',
					        'data' => 
					        array (
					          0 => 
					          array (
					            'id' => '00000001',
					            'type' => 'url',
					            'url' => '/pages/personal/supplier',
					            'url_name' => '申请供应商页',
					            'img' => $http.'/addons/group_buy/public/diy/banner3.png',
					            
					          ),
					          1 => 
					          array (
					            'id' => 'g1548984006208',
					            'type' => 'url',
					            'url' => '/pages/group/groupApply',
					            'url_name' => '申请团长页',
					            'img' => $http.'/addons/group_buy/public/diy/banner1.png',
					          ),
					          2 => 
					          array (
					            'id' => 'g1555306830375',
					            'type' => 'url',
					            'url' => '',
					            'url_name' => '',
					            'img' => $http.'/addons/group_buy/public/diy/banner2.png',
					          ),
					        ),
					        'radius' => '10',
					        'margin_top' => '5',
					        'margin_boottom' => '5',
					        'margin_left' => '5',
					        'margin_right' => '5',
					        'point_type' => '2',
					      ),
					    ),
					    2 => 
					    array (
					      'id' => 'm1560562097556',
					      'name' => 'nav',
					      'params' => 
					      array (
					        'num' => '5',
					        'radius' => '0',
					        'padding' => '0',
					        'bgcolor' => '#ffffff',
					        'fontcolor' => '#666666',
					        'data' => 
					        array (
					          0 => 
					          array (
					            'id' => '00000001',
					            'title' => '严选鲜果',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_top_1.png',
					            'url_name' => '产品分类列表',
					          ),
					          1 => 
					          array (
					            'id' => '00000002',
					            'title' => '营养蔬菜',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_top_2.png',
					            'url_name' => '产品分类列表',
					          ),
					          2 => 
					          array (
					            'id' => '00000003',
					            'title' => '禽蛋肉类',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_top_3.png',
					            'url_name' => '产品分类列表',
					          ),
					          3 => 
					          array (
					            'id' => '00000004',
					            'title' => '水产海鲜',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_top_4.png',
					            'url_name' => '产品分类列表',
					          ),
					          4 => 
					          array (
					            'id' => '00000005',
					            'title' => '粮油调味',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_top_5.png',
					            'url_name' => '产品分类列表',
					          ),
					        ),
					      ),
					    ),
					    3 => 
					    array (
					      'id' => 'm1560562491300',
					      'name' => 'nav',
					      'params' => 
					      array (
					        'num' => '5',
					        'radius' => '0',
					        'padding' => '0',
					        'bgcolor' => '#ffffff',
					        'fontcolor' => '#666666',
					        'data' => 
					        array (
					          0 => 
					          array (
					            'id' => '00000001',
					            'title' => '家庭副食',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_bottom_1.png',
					            'url_name' => '产品分类列表',
					          ),
					          1 => 
					          array (
					            'id' => '00000002',
					            'title' => '休闲零食',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_bottom_2.png',
					            'url_name' => '产品分类列表',
					          ),
					          2 => 
					          array (
					            'id' => '00000003',
					            'title' => '酒饮冲调',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_bottom_3.png',
					            'url_name' => '产品分类列表',
					          ),
					          3 => 
					          array (
					            'id' => '00000004',
					            'title' => '个护家清',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_bottom_4.png',
					            'url_name' => '产品分类列表',
					          ),
					          4 => 
					          array (
					            'id' => '00000005',
					            'title' => '更多',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'img' => $http.'/addons/group_buy/public/diy/nav_bottom_5.png',
					            'url_name' => '产品分类列表',
					          ),
					        ),
					      ),
					    ),
					    4 => 
					    array (
					      'id' => 'm1560563188265',
					      'name' => 'image',
					      'params' => 
					      array (
					        'padding' => '1',
					        'type' => '2',
					        'istext' => '0',
					        'fontsize' => '14',
					        'fontcolor' => '#333',
					        'bgcolor' => '#ffffff',
					        'data' => 
					        array (
					          0 => 
					          array (
					            'id' => '00000001',
					            'img' => $http.'/addons/group_buy/public/diy/j1.png',
					            'url' => '/pages/integralMall/index/index',
					            'title' => '',
					            'type' => 'url',
					            'url_name' => '积分商城页',
					          ),
					          1 => 
					          array (
					            'id' => 'm01560563191609',
					            'type' => 'url',
					            'url' => '/pages/checkIn/index',
					            'title' => '',
					            'img' => $http.'/addons/group_buy/public/diy/j2.png',
					            'url_name' => '积分签到',
					          ),
					        ),
					      ),
					    ),
					    5 => 
					    array (
					      'id' => 'm1548983841984',
					      'name' => 'buyTitle',
					      'params' => 
					      array (
					        'module' => '3',
					        'color' => '#ffffff',
					        'bgcolor' => '#ff4848',
					        'timeColor' => '#ffffff',
					        'timeBgcolor' => '#505050',
					        'limitTitle' => '正在抢购',
					        'limitTitleDown' => '每日更新',
					        'nextTitle' => '下期预告',
					        'nextTitleDown' => '限时开抢',
					        'nocolor' => '#333',
					        'nobgcolor' => '#eee',
					        'pic' => $http.'/addons/group_buy/public/diy/y1.png',
					        'nopic' => $http.'/addons/group_buy/public/diy/y2.png',
					      ),
					    ),
					    6 => 
					    array (
					      'id' => 'm1548983843177',
					      'name' => 'cate',
					      'params' => 
					      array (
					        'border_color' => '#000000',
					        'color' => '#000',
					        'mrcolor' => '#b0b0b0',
					        'bgcolor' => '#ff4848',
					      ),
					    ),
					    7 => 
					    array (
					      'id' => 'm1548984145632',
					      'name' => 'goods',
					      'params' => 
					      array (
					        'goods_title_module' => '0',
					        'goods_module' => '5',
					        'is_class' => '0',
					        'num' => '10',
					        'is_hot' => '0',
					        'is_new' => '1',
					        'margin' => '4',
					        'radius' => '18',
					      ),
					    ),
					    8 => 
					    array (
					      'id' => 'm1548836775341',
					      'name' => 'bars',
					      'params' => 
					      array (
					        'radius' => '0',
					        'padding' => '5',
					        'bgcolor' => '#ffffff',
					        'fontcolor' => '#000',
					        'actcolor' => '#dd4f43',
					        'num' => '4',
					        'data' => 
					        array (
					          0 => 
					          array (
					            'id' => '00000001',
					            'title' => '首页',
					            'img' => $http.'/addons/group_buy/public/diy/nav_main_2.png',
					            'actimg' => $http.'/addons/group_buy/public/diy/nav_main_1.png',
					            'type' => 'url',
					            'url' => '/pages/template/index',
					            'url_name' => '首页',
					          ),
					          1 => 
					          array (
					            'id' => '00000004',
					            'title' => '分类',
					            'img' => $http.'/addons/group_buy/public/diy/nav_class_2.png',
					            'actimg' => $http.'/addons/group_buy/public/diy/nav_class_1.png',
					            'type' => 'url',
					            'url' => '/pages/template/classify',
					            'url_name' => '产品分类列表',
					          ),
					          2 => 
					          array (
					            'id' => '00000002',
					            'title' => '购物车',
					            'img' => $http.'/addons/group_buy/public/diy/nav_g_2.png',
					            'actimg' => $http.'/addons/group_buy/public/diy/nav_g_1.png',
					            'type' => 'url',
					            'url' => '/pages/template/cart',
					            'url_name' => '购物车',
					          ),
					          3 => 
					          array (
					            'id' => '00000003',
					            'title' => '我的',
					            'img' => $http.'/addons/group_buy/public/diy/nav_member_2.png',
					            'actimg' => $http.'/addons/group_buy/public/diy/nav_member_1.png',
					            'type' => 'url',
					            'url' => '/pages/personal/personal',
					            'url_name' => '个人中心',
					          ),
					          4 => 
					          array (
					            'id' => '00000005',
					            'title' => '导航名称',
					            'img' => $http.'/addons/group_buy/public/diy/nav_member_2.png',
					            'actimg' => $http.'/addons/group_buy/public/diy/nav_member_1.png',
					            'type' => 'url',
					            'url' => '',
					          ),
					        ),
					        'content' => '',
					      ),
					    ),
					  ),
					  'basic' => 
					  array (
					    'id' => '0000000',
					    'name' => '',
					    'title' => '麦芒社区团购模板',
					    'sharetitle' => '',
					    'shareimg' => '',
					    'isbar' => '0',
					    'topbg' => '#ffffff',
					    'topcolor' => '#000000',
					    'allbg' => '#ffffff',
					  ),
					)),
				 'createtime' => '1548985346',
                'name' => NULL,
                'tempid' => '4',
                'status' => '1',
                'system' => '2',
				),
            );
echo base64_encode(json_encode($data));
exit;
?>