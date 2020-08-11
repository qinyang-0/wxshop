<?php defined('IN_IA') or exit('Access Denied');?><div class="am-form-group am-form-success">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品规格 </label>
	<div class="am-u-sm-9 am-u-end">
		<label class="am-radio-inline">
			<input type="radio" name="spec_type" value="0" data-am-ucheck="" class="am-ucheck-radio am-field-valid" <?php echo empty($info['g_has_option'])||$info['g_has_option']=='0'?'checked':''; ?>><span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>
			单规格
		</label>
		<label class="am-radio-inline" style="">
			<input type="radio" name="spec_type" value="1" data-am-ucheck="" class="am-ucheck-radio am-field-valid" <?php echo $info['g_has_option']=='1'?'checked':''; ?>><span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>
			<span class="am-link-muted">多规格</span>
		</label>
	</div>
</div>
<div class="am-form-group am-form-success" style="<?php echo $info['g_has_option']!=1?'display: block;':'display: none;'; ?>">
	<label class="am-u-sm-3 am-u-lg-2 am-form-label">重量（kg） </label>
	<div class="am-u-sm-9 am-u-end">
		<input type='text' name='g_only_weight' value="<?php echo empty($info['g_only_weight'])?'0.00':$info['g_only_weight'];?>" class='tpl-form-input checkNum' placeholder=""/>
		<span class="color-9">单规格时的单件商品重量，用于快递计算运费</span>
	</div>
</div>

<!-- 商品多规格 -->

<div id="many-app" class="goods-spec-many am-form-group" style="<?php echo $info['g_has_option']==='1'?'display: block;':'display: none;'; ?>">

	<!--<div class="spec-attr">-->
		<!--<div class="spec-group-item" data-index="0" data-group-id="10000">-->
			<!--<div class="spec-group-name">-->
				<!--<span>参数<input type="hidden" value="参数" name="spec_name[]"></span>-->
				<!--<i class="spec-group-delete iconfont icon-shanchu1" title="点击删除" onclick="deletes(10000)"></i>-->
			<!--</div>-->
			<!--<div class="spec-list am-cf">-->
				<!--<div class="spec-item am-fl" data-item-index="0">-->
					<!--<span>1<input type="hidden" value="1" name="spec_name_参数[]"></span>-->
				<!--</div>-->
				<!--<div class="spec-item-add am-cf am-fl">-->
					<!--<input type="text" class="ipt-specItem am-fl am-field-valid">-->
					<!--<button type="button" class="btn-addSpecItem am-btn am-fl" data-id="10000" data-name="参数" onclick="additem(this)">添加</button>-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->
	<!--</div>-->

	<div class="goods-spec-box am-u-sm-9 am-u-sm-push-2 am-u-end">
		<div class="spec-attr">
			<?php  if(!empty($spec)) { ?>
			<?php  if(is_array($spec)) { foreach($spec as $k => $v) { ?>
				<div class="spec-group-item" data-index="<?php  echo (1000+$k);?>" data-group-id="<?php  echo (1000+$k);?>">
					<div class="spec-group-name">
						<span><?php  echo $v['title'];?><input type="hidden" value="<?php  echo $v['title'];?>" name="spec_name[]"></span>
						<i class="spec-group-delete iconfont icon-shanchu1" title="点击删除" onclick="deletes(<?php  echo (1000+$k);?>)"></i>
					</div>
					<div class="spec-list am-cf">
					<?php  if(is_array($spec_item)) { foreach($spec_item as $kk => $vv) { ?>
					<?php  if(in_array($vv['gsi_id'],$v['content'])) { ?>
						<div class="spec-item am-fl" data-item-index="<?php  echo $kk;?>">
							<span><?php  echo $vv['gsi_title'];?><input type="hidden" value="<?php  echo $vv['gsi_title'];?>" name="spec_name_<?php  echo $v['title'];?>[]"></span>
						</div>
					<?php  } ?>
					<?php  } } ?>
						<div class="spec-item-add am-cf am-fl">
							<input type="text" class="ipt-specItem am-fl am-field-valid">
							<button type="button" class="btn-addSpecItem am-btn am-fl" data-id="<?php  echo (1000+$k);?>" data-name="<?php  echo $v['title'];?>" onclick="additem(this)">添加</button>
						</div>
					</div>
				</div>
			<?php  } } ?>
			<?php  } ?>

		</div>
		<div class="spec-group-button label"><button type="button" class="am-btn">添加规格</button></div>
		<div class="spec-group-add" style="display: none;">
			<div class="spec-group-add-item am-form-group"><label class="am-form-label form-require">规格名 </label> <input type="text" placeholder="请输入规格名称" class="input-specName tpl-form-input"></div>
			<div class="spec-group-add-item am-form-group"><label class="am-form-label form-require">规格值 </label> <input type="text" placeholder="请输入规格值" class="input-specValue tpl-form-input"></div>
			<div class="spec-group-add-item am-margin-top"><button type="button" class="am-btn am-btn-xs am-btn-secondary">
				确定</button>
				<button type="button" class="am-btn am-btn-xs am-btn-default">取消
				</button></div>
		</div>
		<div class="goods-sku am-scrollable-horizontal" style="display: block;">
			<!-- 分割线 -->
			<div class="goods-spec-line am-margin-top-lg am-margin-bottom-lg"></div>
			<div class="spec-batch am-form-inline">
				<div class="am-form-group">
					<label class="am-form-label">批量设置</label>
				</div>
				<div class="am-form-group am-form-success">
					<input type="text" data-type="goods_no" placeholder="规格商品编码" class="am-field-valid batch-spec-sn">
				</div>
				<div class="am-form-group am-form-success">
					<input type="number" data-type="goods_price" placeholder="销售价" pattern="^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$" class="am-field-valid batch-spec-price">
				</div>
				<div class="am-form-group am-form-success">
					<input type="number" data-type="line_price" placeholder="划线价" pattern="^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$" class="am-field-valid batch-spec-line-price">
				</div>
				<div class="am-form-group am-form-success">
					<input type="number" data-type="stock_num" placeholder="库存数量" pattern="^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$" class="am-field-valid batch-spec-stock">
				</div>
				<div class="am-form-group am-form-success">
					<input type="number" data-type="goods_weight" placeholder="重量" pattern="^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$" class="am-field-valid batch-spec-weight">
				</div>
				<div class="am-form-group">
					<button type="button" class="btn-specBatchBtn am-btn am-btn-sm am-btn-secondary
								 am-radius">确定
					</button>
				</div>
			</div>
			<table class="spec-sku-tabel am-table am-table-bordered am-table-centered
					 am-margin-bottom-xs am-text-nowrap">
				<tbody>
				<?php  if(!empty($spec)) { ?>
				<tr>
				<?php  if(is_array(array_reverse($spec))) { foreach(array_reverse($spec) as $k => $v) { ?>
				<th><?php  echo $v['title'];?></th>
				<?php  } } ?>
					<th>规格商品编码</th>
					<th>销售价</th>
					<th>划线价</th>
					<th>库存</th>
					<th>重量(kg)</th>
				</tr>
				<?php  echo $str;?>
				<script>
                    $(function () {
                        //刷新出表格
                        specifications();
                        return false;
                    })
				</script>
				<?php  } ?>
				<!--<tr>-->
					<!--<th>颜色</th>-->
					<!--<th>规格商品编码</th>-->
					<!--<th>销售价</th>-->
					<!--<th>划线价</th>-->
					<!--<th>库存</th>-->
					<!--<th>重量(kg)</th>-->
				<!--</tr>-->

				<!--<tr data-index="0" data-sku-id="10006">-->
					<!--<td class="td-spec-value am-text-middle" rowspan="1">-->
						<!--红色-->
						<!--<input type="hidden" name="spec[]" value="红色" class="ipt-goods-no am-field-valid">-->
					<!--</td>-->
					<!--<td>-->
						<!--<input type="text" name="spec_sn[]" value="" class="ipt-goods-no am-field-valid">-->
					<!--</td>-->
					<!--<td>-->
						<!--<input type="number" name="spec_price[]" value="" class="am-field-valid ipt-w80" >-->
					<!--</td>-->
					<!--<td>-->
						<!--<input type="number" name="spec_line_price[]" value="" class="am-field-valid ipt-w80">-->
					<!--</td>-->
					<!--<td>-->
						<!--<input type="number" name="spec_stock[]" value="" class="am-field-valid ipt-w80 spec_stock"  >-->
					<!--</td>-->
					<!--<td>-->
						<!--<input type="number" name="spec_weight[]" value="" class="am-field-valid ipt-w80" >-->
					<!--</td>-->
				<!--</tr>-->
				</tbody>
			</table>

		</div>
	</div>
</div>
<input type="hidden" name="spec_titles" value="<?php  echo $spec_titles;?>" >