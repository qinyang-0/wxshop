<?php/** * 会员管理相关 */global $_W, $_GPC;$do = $_GPC['do'];$op = $_GPC['op'];$in = $_GPC['in'];$id = $_GPC['id'];//主键idempty($op) ? $op = 'index' : $op ;$weid = $this->weid;  //控制模块switch($op){	case 'index':		$index=isset($_GPC['page'])?$_GPC['page']:1;        $pageIndex = $index;        $pageSize = 100;        $where = " ";        //逻辑：昵称是模糊查询        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {            $where .= " and ( m_nickname like '%".trim($_GPC['title'])."%' or m_nickname like '%".base64_encode(trim($_GPC['title']))."%' ";            //逻辑：编号是确定查询 和昵称是 或者关系            if(  isset($_GPC['num']) and !empty($_GPC['num']) ) {                $where .= " or m_id = ".trim($_GPC['num'])." )";            } else{                $where .= " )";            }        } elseif( isset($_GPC['num']) and !empty($_GPC['num']) ) {            $where .= " and m_id = ".trim($_GPC['num']);        }		$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;		$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->member)." where weid=".$weid." and m_status = 1 and m_nickname is not null ".$where);        $page = pagination($total,$pageIndex,$pageSize);        //获取分页信息        $sql = 'select * from '.tablename($this->member)." where weid=".$weid." and m_status = 1  ".$where." and m_nickname is not null  order by m_id desc ".$contion;        $info = pdo_fetchall($sql);        if(is_array($info)){            foreach ($info as $k=>$v){                if($this->check_base64_out_json( $v['m_nickname'] )){                    $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );                }            }        }		//余额  会员卡  积分		//判断数据库是否存在		$card = pdo_tableexists("gpb_member_card");		if($info && $card){			foreach($info as $k=>$v){				if($v['level']){					$card = pdo_get("gpb_member_card",array('id'=>$v['level']));					$info[$k]['card'] = $card['title'];				}			}		}	break;	case 'add':		if($_GPC['submit'] == '提交'){			//提交数据            //var_dump($_GPC);exit();			$phone = $_GPC['phone'];			$name = $_GPC['name'];			$info = $_GPC['info'];            if(empty($name) ){                $this->message_info('请填写姓名');exit;            }            if(!preg_match("/^1[3456789]\d{9}$/", $phone)){                $this->message_info('请填写正确的手机号');exit;            }			if($this->fileexit()){				//开启事务				pdo_begin();				$ids = $_GPC['ids'];				$sql = "select leader_id from " . tablename("gpb_distribution_group") . " where find_in_set('{$id}',lv1) and `weid`='{$this->weid}'";				$group = pdo_fetch($sql);				//判断上级是否修改了的				if($group['leader_id'] != $ids){					//改变分销上级//					1.看看自己在那个的1级 2级 3级//					2.依次改变关系//					3.改变原来的关系//					找到自己的三个等级的关系					$dis = ['0'=>'lv1','1'=>'lv2','2'=>'lv3'];//三个等级					foreach($dis as $kv){						$sql = "select id,".$kv." from ".tablename("gpb_distribution_group") . " where find_in_set('{$id}',".$kv.") and `weid`='{$this->weid}'";						$group = pdo_fetch($sql);						if($group[$kv]){							$arr = explode(',',trim($group[$kv],','));							$str = '';							foreach($arr as $k=>$v){								if($v != $id && !empty($v)){									$str .= ",".$v;									}							}							//修改 上级							$res = pdo_update("gpb_distribution_group",array($kv=>$str),array('id'=>$group['id']));							if(empty($res)){								pdo_rollback();//失败回滚								$this->message_info('修改上级失败，请重新在试!!');							}						}					}					//原有数据修改完成  该修改新分销商的数据了					//直接给上级新增					$distribu = pdo_get("gpb_distribution_group",array('leader_id'=>$ids));					if($distribu){						$str = $distribu['lv1'].",".$id;						$res = pdo_update("gpb_distribution_group",array('lv1'=>$str),array('id'=>$distribu['id']));					}					//找到上2级					$dis = ['0'=>'lv2','1'=>'lv3'];					foreach($dis as $kv){						$sql = "select id,leader_id,".$kv." from " . tablename("gpb_distribution_group") . " where find_in_set('{$ids}',".$kv.") and `weid`='{$this->weid}'";						$group = pdo_fetch($sql);						if($group[$kv] && $ids != $group['leader_id']){							$str = $group[$kv].",".$id;							$res = pdo_update("gpb_distribution_group",array($kv=>$str),array('id'=>$group['id']));							if(empty($res)){								pdo_rollback();//失败回滚								$this->message_info('修改上级失败，请重新在试!!');							}						}					}					pdo_commit();//事务提交				}			}			$data = [				'm_phone'=>$phone,				'm_name'=>$name,				'm_comment'=>$info,                'weid'=>$weid,			];			if($id){				$res = pdo_update($this->member,$data,['m_id'=>$id]);			}else{				$res = pdo_insert($this->member,$data);			}//			if(empty($res)){//              $this->message_info('操作失败');//			}else{                $this->message_info('操作成功', $this->createWebUrl('member'), 'success');//			}		}else{			if($id){				$info = pdo_get($this->member,['m_id'=>$id,'weid'=>$weid]);                if(is_array($info)){                    if($this->check_base64_out_json( $info['m_nickname'] )){                        $info['m_nickname'] = base64_decode( $info['m_nickname'] );                    }                }				//获取上级分销商				if($this->fileexit()){					//安装了分销插件					$sql = "select leader_id from " . tablename("gpb_distribution_group") . " where find_in_set('{$id}',lv1) and `weid`='{$this->weid}'";					$group = pdo_fetch($sql);					if(!empty($group['leader_id'])){						//找到上级的id了						$groups = pdo_get('gpb_member',array('m_id'=>$group['leader_id']),array('m_nickname','m_photo','m_id'));						if(is_array($info)){		                    if($this->check_base64_out_json( $groups['m_nickname'] )){		                        $groups['m_nickname'] = base64_decode( $groups['m_nickname'] );		                    }		                }					}				}			}		}	break;	case 'save':	break;	case 'del':		if($id){			$res = pdo_update($this->member,['m_status'=>-1],['m_id'=>$id,'weid'=>$weid]);			if($res){				echo json_encode(['status'=>0,'msg'=>'删除成功']);exit;			}else{				echo json_encode(['status'=>1,'msg'=>'删除失败']);exit;			}		}else{			echo json_encode(['status'=>1,'msg'=>'非法进入']);exit;		}	break;    case 'setHead':        if($id){            $res = pdo_update($this->member,array('m_is_head'=>2),array('m_id'=>$id,'weid'=>$weid));            if(empty($res)){                echo json_encode(['status'=>1,'msg'=>'设置失败']);exit;            }            $member = pdo_get($this->member,array('m_id'=>$id));            $res = pdo_update($this->vg,array('vg_status'=>1),array('openid'=>$member['m_openid'],'weid'=>$weid));            if(empty($res)){               $res = pdo_insert($this->vg,array('openid'=>$member['m_openid'],'weid'=>$weid,'vg_status'=>1));               echo json_encode(['status'=>2,'msg'=>'设置团长成功，请点编辑完善团长小区信息','id'=>$id]);exit;            }            echo json_encode(['status'=>0,'msg'=>'设置成功']);exit;        }else{            echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;        }        break;    case 'cancelHead':        if($id){            pdo_begin();            $res = pdo_update($this->member,['m_is_head'=>-1],['m_id'=>$id,'weid'=>$weid]);            $openid = pdo_fetch("select m_openid from".tablename($this->member)." where weid=".$weid." and m_id =".$id);            if($res){                $old_vg = pdo_get($this->vg,array('openid'=>$openid['m_openid'],'weid'=>$weid));                if(!empty($old_vg)){                    $res_vg = pdo_update($this->vg,array('vg_status'=>-1),array('weid'=>$weid,'vg_id'=>$old_vg['vg_id']));//                  $res_rg = pdo_update($this->rg,array('rg_status'=>-1),array('weid'=>$weid,'rg_id'=>$old_vg['vg_rg_id']));//                  if(empty($res_vg) ){//                      pdo_rollback();//						echo '<pre>';//						pdo_debug();//						var_dump($res_vg);exit;//                      echo json_encode(['status'=>1,'msg'=>'取消失败']);exit;//                  }                }                pdo_update($this->member,array('m_head_openid'=>''),array('m_head_openid'=>$openid['m_openid'],'weid'=>$weid));                pdo_update($this->ah,array('ah_status'=>-1),array('ah_result'=>-2,'openid'=>$openid['m_openid'],'ah_status'=>1));                pdo_commit();                echo json_encode(['status'=>0,'msg'=>'取消成功']);exit;            }else{                echo json_encode(['status'=>1,'msg'=>'取消失败']);exit;            }        }else{            echo json_encode(['status'=>1,'msg'=>'非法操作']);exit;        }        break;    case 'config':        //会员设置        if($_GPC['submit'] == '提交'){            //提交数据            unset($_POST['submit']);            pdo_begin();            foreach ($_POST as $k =>$v){                $sql = "update ".tablename($this->config)." set value = '".$v."',time=".time()." where id =".$k;                $res = pdo_query($sql);            }            pdo_commit();            if(!empty($res)){                $this->message_info("修改配置成功",$this->createWebUrl('member',array('op'=>'config')), 'success');            }else{                $this->message_info("修改配置失败");            }        }else{            //详情页活动及价格背景图设置            $goods_info_action_price_bg = pdo_get($this->config,array('key'=>'goods_info_action_price_bg','weid'=>$weid));            if(empty($goods_info_action_price_bg) ){                pdo_query("INSERT  INTO ".tablename('gpb_config')." (`name`,`value`,`type`,`time`,`weid`,`status`,`key`) VALUES ('详情页活动及价格背景','','16',".time().",".$weid.",1,'goods_info_action_price_bg');");            }            $info = pdo_getall($this->config,array('status'=>1,'type'=>10,'weid'=>$weid),array(),"key");        }        break;	case 'recharge':		if(empty($id)){			echo json_encode(['code'=>1,'msg'=>'参数错误']);exit;		}		if(empty($_GPC['inters']) && $_GPC['inters'] != 0){			echo json_encode(['code'=>1,'msg'=>'请输入数目']);exit;		}		if($_GPC['inters'] < 0){			echo json_encode(['code'=>1,'msg'=>'数目不能为0']);exit;		}		$data = [];		$_GPC['types'];		$member = pdo_get("gpb_member",array('m_id'=>$id));		if($_GPC['types'] == 1){			//充值积分			switch($_GPC['change']){				case '1':$data['integral +='] = $_GPC['inters'];				break;				case '2':				if($member['integral']-$_GPC['inters'] < 0){					echo json_encode(['code'=>1,'msg'=>'减少积分大于当前用户积分']);exit;				}				$data['integral -='] = $_GPC['inters'];				break;				case '3':				if($_GPC['inters'] < 0){					echo json_encode(['code'=>1,'msg'=>'最终数目请大于0']);exit;				}				$data['integral'] = $_GPC['inters'];				break;			}		}else if($_GPC['types'] == 2){			//充值余额			switch($_GPC['change']){				case '1':$data['m_money_balance +='] = $_GPC['inters'];				break;				case '2':				if($member['m_money_balance']-$_GPC['inters'] < 0){					echo json_encode(['code'=>1,'msg'=>'减少余额大于当前用户余额']);exit;				}				$data['m_money_balance -='] = $_GPC['inters'];				break;				case '3':				if($_GPC['inters'] < 0){					echo json_encode(['code'=>1,'msg'=>'最终数目请大于0']);exit;				}				$data['m_money_balance'] = $_GPC['inters'];				break;			}		}		$res = pdo_update("gpb_member",$data,array('m_id'=>$id));		if($res){			//记录日志   参数不一样  日志不一样			$str ='';			if($_GPC['types'] == 1){				switch($_GPC['change']){					case '1':$str .= "后台为用户新增积分".$_GPC['inters'];					break;					case '2':$str .= "后台为用户减少积分".$_GPC['inters'];					break;					case '3':$str .= "后台为用户改变最终积分".$_GPC['inters'];					break;				}				$arr = [					'gol_uid'=>$id,					'gol_add_time'=>time(),					'gol_comment'=>$str,					'gol_des'=>$_GPC['remarks'],					'gol_u_name'=>'后台管理员',					'type'=>2,					'intage'=>$_GPC['inters'],				];				pdo_insert("gpb_order_log",$arr);			}else{				switch($_GPC['change']){					case '1':$str .= "后台为用户新增余额".$_GPC['inters'];					break;					case '2':$str .= "后台为用户减少余额".$_GPC['inters'];					break;					case '3':$str .= "后台为用户改变最终余额".$_GPC['inters'];					break;				}				$st = $_GPC['change'] == 2 ? '2' : 1;				$member = pdo_get("gpb_member",array('m_id'=>$id));				$arr = [					'uid'=>$id,					'openid'=>$member['m_openid'],					'info'=>$str,					'type'=>1,'status'=>1,'create_time'=>time(),					'weid'=>$this->weid,					'money'=>$_GPC['inters'],'l_type'=>1,'st'=>$st,'remarks'=>$_GPC['remarks'],'pay_f'=>2				];				pdo_insert("gpb_recharge_log",$arr);			}			echo json_encode(['code'=>0,'msg'=>'操作成功']);exit;		}else{			echo json_encode(['code'=>1,'msg'=>'未修改任何数据']);exit;		}	break;	case "recharge_template":		//获取用户信息		$member = pdo_get("gpb_member",array('m_id'=>$id));        if(is_array($member)){            if($this->check_base64_out_json( $member['m_nickname'] )){                $member['m_nickname'] = base64_decode( $member['m_nickname'] );            }        }	break;	case 'recharge_record':		$_GPC['do'] = 'finance';		$type = $_GPC['type'];		if($type){			//积分			$index=isset($_GPC['page'])?$_GPC['page']:1;	        $pageIndex = $index;	        $pageSize = 30;	        $where = " ";	        //逻辑：昵称是模糊查询	        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {	            $where .= " and ( (m.m_nickname like '%".trim($_GPC['title'])."%' or m_nickname like '%".base64_encode(trim($_GPC['title']))."%')";	            //逻辑：编号是确定查询 和昵称是 或者关系	            if(  isset($_GPC['num']) and !empty($_GPC['num']) ) {	                $where .= " or m.m_id = ".trim($_GPC['num'])." )";	            } else{	                $where .= " )";	            }	        } elseif( isset($_GPC['num']) and !empty($_GPC['num']) ) {	            $where .= " and m.m_id = ".trim($_GPC['num']);	        }			$pay = $_GPC['pay'];			if($pay ==2 ){				$where .= " and l.gol_u_name = '后台管理员'";			}else if($pay == 1){				$where .= " and l.gol_u_name != '后台管理员'";			}			$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;			$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->member)." m join ".tablename("gpb_order_log")." l on m.m_id = l.gol_uid where m.weid=".$weid." and m.m_status = 1 and l.type = 2 and m.m_nickname is not null ".$where);	        $page = pagination($total,$pageIndex,$pageSize);	        //获取分页信息	        $sql = 'select m.m_nickname,m.m_phone,m.m_photo,l.* from '.tablename($this->member)." m join ".tablename("gpb_order_log")." l on m.m_id = l.gol_uid where m.weid=".$weid." and m.m_status = 1  ".$where." and l.type = 2 and m.m_nickname is not null  order by l.gol_add_time desc ".$contion;	        $info = pdo_fetchall($sql);			$data = [];			if($info){				foreach($info as $k=>$v){					$data[$k]['m_photo'] = $v['m_photo'];					$data[$k]['m_nickname'] = $this->check_base64_out_json($v['m_nickname'])?base64_decode($v['m_nickname']):$v['m_nickname'];					$data[$k]['m_phone'] = $v['m_phone'];					$data[$k]['c_time'] = $v['gol_add_time'];					$data[$k]['pay_f'] = $v['gol_u_name'];					$data[$k]['remarks'] = $v['gol_comment'];					$data[$k]['money'] = $v['intage'];				}			}			$info = $data;		}else{			//余额			$index=isset($_GPC['page'])?$_GPC['page']:1;	        $pageIndex = $index;	        $pageSize = 30;	        $where = " ";	        //逻辑：昵称是模糊查询	        if(isset($_GPC['title']) && !empty($_GPC['title']) ) {	            $where .= " and ( (m.m_nickname like '%".trim($_GPC['title'])."%' or m.m_nickname like '%".base64_encode(trim($_GPC['title']))."%')";	            //逻辑：编号是确定查询 和昵称是 或者关系	            if(  isset($_GPC['num']) and !empty($_GPC['num']) ) {	                $where .= " or m.m_id = ".trim($_GPC['num'])." )";	            } else{	                $where .= " )";	            }	        } elseif( isset($_GPC['num']) and !empty($_GPC['num']) ) {	            $where .= " and m.m_id = ".trim($_GPC['num']);	        }			$pay = $_GPC['pay'];			if(!empty($pay)){				$where .= " and l.pay_f = ".$pay;			}			$contion = 'limit '.($pageIndex-1) * $pageSize .','. $pageSize;			$total= pdo_fetchcolumn('select count(*) from ' . tablename($this->member)." m join ".tablename("gpb_recharge_log")." l on m.m_openid = l.openid where m.weid=".$weid." and m.m_status = 1 and l.l_type = 1 and m.m_nickname is not null ".$where);	        $page = pagination($total,$pageIndex,$pageSize);	        //获取分页信息	        $sql = 'select m.*,l.create_time as c_time,l.money,l.st,l.remarks,l.pay_f,l.info from '.tablename($this->member)." m join ".tablename("gpb_recharge_log")." l on m.m_openid = l.openid where m.weid=".$weid." and m.m_status = 1  ".$where." and l.l_type = 1 and m.m_nickname is not null  order by l.create_time desc ".$contion;	        /*echo $sql;	        die;*/	        $info = pdo_fetchall($sql);            if(is_array($info)){                foreach ($info as $k=>$v){                    if($this->check_base64_out_json( $v['m_nickname'] )){                        $info[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );                    }                }            }		}	break;	case 'group_info':		//分销商		$where = "";		if($_GPC['title']){			$where .= " and ( m.m_nickname like '%".$_GPC['title']."%' or m.m_nickname like '%".base64_encode($_GPC['title'])."%')";		}		$ids = $_GPC['ids'];		$index=isset($_GPC['page'])?$_GPC['page']:1;        $pageIndex = $index;        $pageSize = 5;		$contion = ' limit '.($pageIndex-1) * $pageSize .','. $pageSize;		$total= pdo_fetchcolumn("select count(*) from ".tablename('gpb_member')." m left join ".tablename('gpb_distribution_money')." g on m.m_id = g.uid where g.check_state = 1 and g.status != -1 and m.weid = ".$this->weid.$where);		$page = pagination($total,$pageIndex,$pageSize);		$arr = pdo_fetchall("select m_id,m_nickname,m_photo from ".tablename('gpb_member')." m left join ".tablename('gpb_distribution_money')." g on m.m_id = g.uid where g.check_state = 1 and g.status != -1 and m.weid = ".$this->weid.$where.$contion);		if($arr){			foreach($arr as $k=>$v){				if($this->check_base64_out_json( $v['m_nickname'] )){					$arr[$k]['m_nickname'] = base64_decode( $v['m_nickname'] );				}			}		}	break;}include $this -> template('web/' . $do . '/' . $op);?>