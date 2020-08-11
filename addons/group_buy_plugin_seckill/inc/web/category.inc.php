<?php
/*
 * 分类管理
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
        //专题列表
        global $_W;
        global $_GPC;
        if (!empty($_GPC['catname']) || !empty($_GPC['catname_new'])) {
//            ca('seckill.category.edit');

            if (is_array($_GPC['catname'])) {
                foreach ($_GPC['catname'] as $id => $catname) {
                    $catname = trim($catname);

                    if (empty($catname)) {
                        continue;
                    }

                    pdo_update('gpb_shop_seckill_category', array('name' => $catname), array('id' => $id));
                }
            }

            if (is_array($_GPC['catname_new'])) {
                foreach ($_GPC['catname_new'] as $id => $catname) {
                    $catname = trim($catname);

                    if (empty($catname)) {
                        continue;
                    }

                    pdo_insert('gpb_shop_seckill_category', array('name' => $catname, 'uniacid' => $_W['uniacid']));
                    $insert_id = pdo_insertid();
                }
            }
//            $this->message_info('保存成功', $this->createWebUrl('category',array('op'=>'index')), 'success');exit;
        }
        $list = pdo_fetchall('SELECT * FROM ' . tablename('gpb_shop_seckill_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'  ORDER BY id DESC'));
        break;
    case 'delete':
        //删除
        $id = intval($_GPC['id']);
        $item = pdo_fetch('SELECT id,name FROM ' . tablename('gpb_shop_seckill_category') . (' WHERE id = \'' . $id . '\'  AND uniacid=') . $_W['uniacid'] . '');
        if (empty($item)) {
            echo json_encode(array('status'=>1,'msg'=>'抱歉，分类不存在或是已经被删除！','data'=>array()));exit;
        }
        pdo_delete('gpb_shop_seckill_category', array('id' => $id));
        echo json_encode(array('status'=>0,'msg'=>'删除成功','data'=>array()));exit;
        break;

}
include $this -> template('web/' . $do . '/' . $op);
?>