<?php defined('IN_IA') or exit('Access Denied');?><script>
	//会员折扣  显示是 统一 还是 详细设置 
	$("input[name='goods_discount']").change(function(res){
		var nu = $(this).val();
		if(nu == 2){
			$("#goods_discount_detailed").hide();
			$("#goods_discount_unified").show();
		}else if(nu == 3){
			$("#goods_discount_detailed").show();
			$("#goods_discount_unified").hide();
		}else{
			$("#goods_discount_detailed").hide();
			$("#goods_discount_unified").hide();
		}
	})
    $('#btn').click(function(){
        var cid = $.trim($("select[name='cid[]']").val());
        console.log(cid)
        var name = $.trim($("input[name='name']").val());
        var old_price = parseFloat($.trim($("input[name='old_price']").val()));
        var price = parseFloat($.trim($("input[name='price']").val()));
        if(price>0){
            price = price.toFixed(2);
            price = parseFloat(price);
        }

        var sale_num = $.trim($("input[name='old_price']").val());
        var save = $.trim($("input[name='save']").val());
        var show = $.trim($("input[name='show']").val());
        var goods_num = $.trim($("input[name='goods_num']").val());

        if(name == '' || name == undefined){
            layer.msg("请输入商品名称");
           return false;
        }
        if(cid == '' || cid == undefined){
            layer.msg("请选择商品分类");
            return false;
        }
        if( isNaN(old_price) || old_price == '' || old_price == undefined){
            layer.msg("请输入商品原价");
            return false;
        }
        if(isNaN(price) || price == '' || price == undefined || price <=0){
            layer.msg("请选择商品售价");
            return false;
        }
        // if(sale_num == '' || sale_num == undefined){
        //     layer.msg("请输入虚拟销售数量");
        //     return false;
        // }
        if(save == '' || save == undefined){
            layer.msg("请输入库存数量");
            return false;
        }
        if(save == '' || save == undefined){
            layer.msg("请输入库存数量");
            return false;
        }
        if(show == '' || show == undefined){
            layer.msg("请选择是否显示");
            return false;
        }
    });
	//选择提货时间，传入给input提交
    $(document).on("change",".arrival_time",function () {
		var val = $(this).val();
		if(val == "" || val == undefined){
		    $(".arrival_time_diy_box").show();
            $(".arrival_time_diy_value").focus();
		}else{
            $(".arrival_time_diy_box").hide();
            $("input[name=g_arrival_time]").val(val);
		}
    });
    //当输入自定义到货时间后
	$(document).on("input propertychange",".arrival_time_diy_value",function () {
		var val =  $(this).val();
        $("input[name=g_arrival_time]").val(val);
    })
	//当选择商品限时抢购时
	$(document).on("change","input[name=limit_time_sale]",function () {
		var val = $(this).val();
		var data_class =$(this).attr("data-class");

		if(val == 1 ){
			$("."+data_class).show();
		}else{
            $("."+data_class).hide();
		}
    })

    //团长专享
    $(document).on("change",".g_is_head_enjoy",function () {
        var val = $(this).val();

        if(val == "-1" || val == -1){

            $(".head_enjoy_diy_box").removeAttr("disabled"); //解除禁用
        }else{

            $(".head_enjoy_diy_box").attr("disabled", "disabled");


        }
    });
</script>

<script>

    /*2020-04-01 周龙添加佣金计算初始化*/
    /*<?php  if(!empty($info)) { ?>*/
    $("#g_commission").val($("#g_commission").val().replace(/[^0-9]/g,''));//只能输入数字
    $("#g_commission").val( $("#g_commission").val().replace(/^(\-)*(\d+)\.(\d\d)/,'$1$2')); //只能输入两个小数
    var price = parseFloat($("#price").val());
    var g_commission = parseFloat($("#g_commission").val()/100);
    var res =0;

    res = price*g_commission;
    $('#g_commission_num').html(res.toFixed(2))
    /*<?php  } ?>*/

	var member_discount = '<?php  echo $member_discounts;?>';//会员价格
	member_discount =  $.parseJSON(member_discount);
	var dis_configs = '<?php  echo $dis_configs;?>';//分销佣金
	if(dis_configs != '' ){
		dis_configs = $.parseJSON(dis_configs);
	}
	//规格相关js
    var id =10000;
    var index = 0;
    var ins = <?php echo (isset($spec_item) && count($spec_item)>0)?count($spec_item)+1:0;?>;
    var isa = 0;
    var ios = 0;
    var old_spec = [];
    var old_spec_item = [];
    $(function() {
        // 切换单/多规格
        $('input:radio[name="spec_type"]').change(function(e) {
            var goodsSpecMany = $('.goods-spec-many'),
				goodsSpecSingle = $('.goods-spec-single');
            if(e.currentTarget.value === '1') {
            	$('#goods_discount_info').show();	
                goodsSpecMany.show() && goodsSpecSingle.hide();
            } else {
            	$('#goods_discount_info').hide();
            	$('#goods_discount_detailed').hide();
                goodsSpecMany.hide() && goodsSpecSingle.show();
            }
        });

        //点击添加规格
        $('.spec-group-button').click(function() {
            $('.spec-group-add').show();
            $(this).hide();
        })
        //点击取消
        $('.spec-group-add .am-btn-default').click(function() {
            $('.spec-group-add').hide();
            $('.spec-group-button').show();
        })
        //点击确认添加规格
        $('.spec-group-add .am-btn-secondary').click(function() {
            var name = $('.input-specName').val();
            var specvalue = $('.input-specValue').val();
            if(name == '' || specvalue == ''){
                layer.msg('请填写规则名或规则值');
                return false;
            }
            //都有数据  才进行下一步
            var str = '';
            str += '<div class="spec-group-item" data-index="'+index+'" data-group-id="'+id+'">';
            str += '<div class="spec-group-name">';
            str += '<span>'+name+'<input type="hidden" value="'+name+'" name="spec_name[]"></span>';
            str += '<i class="spec-group-delete iconfont icon-shanchu1" title="点击删除" onclick="deletes('+id+')"></i>';
            str += '</div>';
            str += '<div class="spec-list am-cf">';
            str += '<div class="spec-item am-fl" data-item-index="'+ins+'">';
            str += '<span>'+specvalue+'<input type="hidden" value="'+specvalue+'" name="spec_name_'+name+'[]"></span>';
				//str += '<i class="spec-item-delete iconfont icon-shanchu1" title="点击删除" onclick="deleteitem('+ins+')"></i>';
            str += '</div>';
            str += '<div class="spec-item-add am-cf am-fl">';
            str += '<input type="text" class="ipt-specItem am-fl am-field-valid">';
            str += '<button type="button" class="btn-addSpecItem am-btn am-fl" data-id="'+id+'" data-name="'+name+'" onclick="additem(this)">添加</button>';
            str += '</div></div></div>';
            index += 1;
            ins ++;
            $('.spec-attr').append(str);
            //清空input
            $('.input-specName').val('');
            $('.input-specValue').val('');
            //显示隐藏
            $('.spec-group-add').hide();
            $('.spec-group-button').show();
            //参数增加
            id++;
            var tmp_specvalue = [{'item_id':ins,'spec_value':specvalue}];
            if(old_spec.length==0||old_spec==''||old_spec==undefined){
                old_spec[0] = {'group_id':id,'group_name':name,'spec_items':tmp_specvalue}
            }else{

            }
            i=0;
            $('.spec-group-item').each(function () {

                var tmp_specvalue = [{'item_id':ins,'spec_value':specvalue}];
            });
            specifications();
            //修改下面表格的数据
        })
    });
    //增加每个规格项的数据
    function additem(obj){
        var ids = $(obj).data('id');
        var name = $(obj).attr('data-name');
        var item = $(".spec-group-item[data-group-id="+ids+"] .ipt-specItem").val();
        if(item == '' ){
            layer.msg('规格值不能为空');
            return false;
        }
        str = '';
        str += '<div class="spec-item am-fl" data-item-index="'+ins+'">';
        str += '<span>'+item+'<input type="hidden" value="'+item+'" name="spec_name_'+name+'[]"</span>';
        str += '<i class="spec-item-delete iconfont icon-shanchu1" title="点击删除" onclick="deleteitem('+ins+')"></i>';
        str += '</div>';
        $(".spec-group-item[data-group-id="+ids+"] .spec-list .spec-item").last().after(str);
        //清空input的数据
        $('.ipt-specItem').val('');
        ins ++;
        //重构表格数据
        specifications(1);
    }
    //刷新规格项目表数据
    function specifications(goods_discounts = 0){
        var str = '';
        var discount = distribution = '';
        str += '<div class="goods-spec-line am-margin-top-lg am-margin-bottom-lg"></div>';
        str += '<div class="spec-batch am-form-inline">';
        //批量操作未完成  todo ..
        str += '	<div class="am-form-group">';
        str += '		<label class="am-form-label">批量设置</label>';
        str += '	</div>';
        str += '	<div class="am-form-group am-form-success">';
        str += '		<input type="text" data-type="goods_no" placeholder="规格商品编码" class="am-field-valid batch-spec-sn">';
        str += '	</div>';
        str += '	<div class="am-form-group am-form-success">';
        str += '		<input type="text" data-type="goods_price" placeholder="销售价"  class="am-field-valid batch-spec-price">';
        str += '	</div>';
        str += '	<div class="am-form-group am-form-success">';
        str += '		<input type="text" data-type="line_price" placeholder="划线价" class="am-field-valid batch-spec-line-price">';
        str += '	</div>';
        str += '	<div class="am-form-group am-form-success">';
        str += '		<input type="number" data-type="stock_num" placeholder="库存数量" pattern="^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$" class="am-field-valid batch-spec-stock">';
        str += '	</div>';
        str += '	<div class="am-form-group am-form-success">';
        str += '		<input type="number" data-type="goods_weight" placeholder="重量" pattern="^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$" class="am-field-valid batch-spec-weight">';
        str += '	</div>';
        str += '	<div class="am-form-group">';
        str += '		<button type="button" class="btn-specBatchBtn am-btn am-btn-sm am-btn-secondary am-radius">确定';
        str += '    </button>';
        str += '	</div>';
        str += '</div>';
        str += '<table class="spec-sku-tabel am-table am-table-bordered am-table-centered am-margin-bottom-xs am-text-nowrap">';
        str += '	<tbody>';
        str += '		<tr>';
        if(member_discount.length > 0){
        	 //会员价折扣表格信息
	        discount += '<div class="goods-spec-line am-margin-top-lg am-margin-bottom-lg"></div>';
	        discount += '<div class="spec-batchs am-form-inline">';
	        discount += '	<div class="am-form-group">';
	        discount += '		<label class="am-form-label">批量设置</label>';
	        discount += '	</div>';
	        for(var is = 0;is<member_discount.length;is++){
	        	discount += '	<div class="am-form-group am-form-success">';
		        discount += '		<input type="text" data-type="goods_discount_price" placeholder="'+member_discount[is]['title']+'会员价(元)" data-id="'+member_discount[is]['id']+'"  class="am-field-valid batch-spec-price">';
		        discount += '	</div>';
	        }
	        discount += '	<div class="am-form-group">';
	        discount += '		<button type="button" class="btn-specBatchBtns am-btn am-btn-sm am-btn-secondary am-radius">确定';
	        discount += '    </button>';
	        discount += '	</div>';
	        discount += '</div>';
	        discount += '<table class="spec-sku-tabel am-table am-table-bordered am-table-centered am-margin-bottom-xs am-text-nowrap">';
	        discount += '	<tbody>';
	        discount += '		<tr>';
        }
        if(dis_configs.length > 0){
        	distribution += '<div class="goods-spec-line am-margin-top-lg am-margin-bottom-lg"></div>';
	        distribution += '<div class="spec-batchs am-form-inline btn_distribution">';
	        distribution += '	<div class="am-form-group">';
	        distribution += '		<label class="am-form-label">批量设置</label>';
	        distribution += '	</div>';
        	for(var is = 0;is<dis_configs.length;is++){
        		distribution += '	<div class="am-form-group am-form-success">';
		        distribution += '		<input type="text" placeholder="'+dis_configs[is]['name']+'" data-id="'+dis_configs[is]['level']+'"  class="am-field-valid batch-spec-price">';
		        distribution += '	</div>';
        	}
        	distribution += '	<div class="am-form-group">';
	        distribution += '		<button type="button" class="btn-distribution am-btn am-btn-sm am-btn-secondary am-radius">确定';
	        distribution += '    </button>';
	        distribution += '	</div>';
	        distribution += '</div>';
	        distribution += '<table class="spec-sku-tabel am-table am-table-bordered am-table-centered am-margin-bottom-xs am-text-nowrap">';
	        distribution += '	<tbody>';
	        distribution += '		<tr>';
        }
        
        var arr = [];
        var numns = 0;
        var name = [];
        $('.spec-attr .spec-group-item').each(function(){
            var indexs = $(this).data('index');
            arr[numns] = [];
            $(".spec-group-item[data-index="+indexs+"] .spec-group-name span").each(function(){
                var name_list = $(this).text();
                //遍历所有的每个下面的数据
                name[numns] = name_list;
                var list = 0;
                $(".spec-group-item[data-index="+indexs+"] .spec-list .spec-item").each(function(){
                    var ins = $(this).data('item-index');
                    var nams = $(".spec-item[data-item-index='"+ins+"'] span").text();
                    if(nams != '' && nams != undefined){
                        arr[numns][list] = nams;
                    }
                    list++;
                })
            })
            numns ++;
        });
        //获取原来的数据
        var arrs = [];
        for(var i = 0;i<name.length;i++){
            arrs[name.length-i-1] = name[i];
        }
        for(var i = 0;i<arrs.length;i++){
            str += '<th>'+arrs[i]+'</th>';
            discount += '<th>'+arrs[i]+'</th>';
            distribution += '<th>'+arrs[i]+'</th>';
        }
        str += '<th>规格商品编码</th>';
        str += '<th>销售价</th>';
        str += '<th>划线价</th>';
        str += '<th>库存</th>';
        str += '<th>重量(kg)</th>';
        str += '</tr>';
        if(member_discount.length > 0){
        	for(var is = 0;is<member_discount.length;is++){
        		discount += '<th>'+member_discount[is]['title']+'(元)</th>';
        	}
        	discount += '</tr>';
        }
        if(dis_configs.length > 0){
        	for(var is = 0;is<dis_configs.length;is++){
        		distribution += '<th>'+dis_configs[is]['name']+'</th>';
        	}
        	distribution += '</tr>';
        }
        
        
        var res = combine(arr);
        var spec_sn_arr_new = [];
        var spec_price_arr_new = [];
        var spec_stock_arr_new = [];
        var spec_weight_arr_new = [];
        var spec_line_price_arr_new = [];
        var key = [];
        for(var i in res ){
            key[i] = res[i].join("+")
		}
        console.log(key);
		for(var i in key){
            spec_sn_arr_new[i] = $("input[name='spec_sn[]'][data-spec-id='"+key[i]+"']").val();
            spec_price_arr_new[i] = $("input[name='spec_price[]'][data-spec-id='"+key[i]+"']").val();
            spec_stock_arr_new[i] = $("input[name='spec_stock[]'][data-spec-id='"+key[i]+"']").val();
            spec_weight_arr_new[i] = $("input[name='spec_weight[]'][data-spec-id='"+key[i]+"']").val();
            spec_line_price_arr_new[i] = $("input[name='spec_line_price[]'][data-spec-id='"+key[i]+"']").val();
		}
        //合并单元格
        var row = [];
        var rowspan = res.length;
        for(var n=arr.length-1; n>-1; n--) {
            row[n] = parseInt(rowspan/arr[n].length);
            rowspan = row[n];
        }
        row.reverse();
        var len = res[0].length;

        for (var i=0; i<res.length; i++) {
            var tmp = tmps = "";
            var str_td = discount_td = con_sign = "";
            for(var j=0; j<len; j++) {
                if(i%row[j]==0 && row[j]>1) {
                    tmp += "<td class='td-spec-value am-text-middle' rowspan='"+ row[j] +"'>"+res[i][j]+"<input type='hidden' name='spec[]' value='"+res[i][j]+"' class='ipt-goods-no am-field-valid'></td>";
                    tmps += "<td class='td-spec-value am-text-middle' rowspan='"+ row[j] +"'>"+res[i][j]+"<input type='hidden' name='discount_spec[]' value='"+res[i][j]+"' class='ipt-goods-no am-field-valid'></td>";
                }else if(row[j]==1){
                    tmp += "<td>"+res[i][j]+"<input type='hidden' name='spec[]' data-test='' value='"+res[i][j]+"' class='ipt-goods-no am-field-valid'></td>";
                    tmps += "<td>"+res[i][j]+"<input type='hidden' name='discount_spec[]' data-test='' value='"+res[i][j]+"' class='ipt-goods-no am-field-valid'></td>";
                }
            }
                str_td = '<td><input type="text" name="spec_sn[]" value="'+(spec_sn_arr_new[i]==undefined?'':spec_sn_arr_new[i])+'" class="ipt-goods-no" data-spec-id="'+key[i]+'"></td>'
					+ '<td><input type="text" name="spec_price[]" value="'+(spec_price_arr_new[i]==undefined?'':spec_price_arr_new[i])+'" class="checkNum ipt-w80" data-spec-id="'+key[i]+'"></td>'
					+ '<td><input type="text" name="spec_line_price[]" value="'+(spec_line_price_arr_new[i]==undefined?'':spec_line_price_arr_new[i])+'" class="checkNum ipt-w80" data-spec-id="'+key[i]+'"></td>'
					+ '<td><input type="number" name="spec_stock[]" value="'+(spec_stock_arr_new[i]==undefined?'':spec_stock_arr_new[i])+'" class=" ipt-w80 spec_stock" data-spec-id="'+key[i]+'"></td>'
					+'<td><input type="number" name="spec_weight[]" value="'+(spec_weight_arr_new[i]==undefined?'':spec_weight_arr_new[i])+'" class=" ipt-w80" data-spec-id="'+key[i]+'"></td>';
			if(member_discount.length > 0){
	        	for(var is = 0;is<member_discount.length;is++){
	        		var values = $('input[name="goods_counts_'+member_discount[is]["id"]+'[]'+'"][data-spec-id="'+key[i]+'"]').val();
	        		if(values == undefined || values == 'undefined'){
	        			values = '';
	        		}
	        		discount_td += '<td><input type="text" name="goods_counts_'+member_discount[is]['id']+'[]" value="'+values+'" class="ipt-w80" data-spec-id="'+key[i]+'"></td>';
	        	}
	        	discount += "<tr data-index='0' data-sku-id='10000'>" + tmp+discount_td + "</tr>";
			}
			if(dis_configs.length > 0){
				for(var is = 0;is<dis_configs.length;is++){
	        		var values = $('input[name="distrib_'+dis_configs[is]["level"]+'[]'+'"][data-spec-id="'+key[i]+'"]').val();
	        		if(values == undefined || values == 'undefined'){
	        			values = '';
	        		}
	        		con_sign += '<td><input type="text" name="distrib_'+dis_configs[is]['level']+'[]" value="'+values+'" class="ipt-w80" data-spec-id="'+key[i]+'"></td>';
	        	}
				distribution += "<tr data-index='0' data-sku-id='10000'>" + tmp+con_sign + "</tr>";
			}
            str += "<tr data-index='0' data-sku-id='10000'>" + tmp+str_td + "</tr>";

        }
        //thead
        var th = "";
        str = "<table>" + th + str + "</table>";
        $('.goods-sku').html(str);
        if(member_discount.length > 0){
        	//会员价格    改变表格的信息
        	$('#goods_discount').html(discount);
        }
        if(dis_configs.length > 0){
        	$('#goods_distributisons').html(distribution);
    	}
    }
    //合并数组
    function combine(arr) {

        var r = [];
        (function f(t, a, n) {
            if (n == 0) return r.push(t);
            for (var i = 0; i < a[n-1].length; i++) {
                f(t.concat(a[n-1][i]), a, n - 1);
            }
        })([], arr, arr.length);
        var res = [];
		for(var i in r){
            res[i] = r[i].join("+")
		}
        res = res.join('|')
        $("input[name=spec_titles]").val(res);
        return r;
    }

    //删除小分类
    function deleteitem(id){
        $(".spec-item[data-item-index='"+id+"']").remove();
        specifications();
    }
    //删除大分类
    function deletes(id){
        $(".spec-group-item[data-group-id='"+id+"']").remove();
        specifications();
    }
    //设置多规格后，有规格库存时动态改变原本库存值
	$(document).on('change','.spec_stock',function () {
	    console.log($(this).val());
	    var count = 0;
		$('.spec_stock').each(function () {
		    var num = parseInt($(this).val());
		    num = !isNaN(num)?num:0;
			count += num;
        });
		$('input[name=save]').val(count);
    })
	//批量设置
	$(document).on('click',".btn-specBatchBtn",function () {
		var sepc_sn = $('.batch-spec-sn').val();
		if( sepc_sn !='' && sepc_sn!=undefined){
		    $('input[name="spec_sn[]"]').val(sepc_sn);
		}
        var sepc_price = $('.batch-spec-price').val();
        if( sepc_price !='' && sepc_price!=undefined){
            $('input[name="spec_price[]"]').val(sepc_price);
        }
        var sepc_line_price = $('.batch-spec-line-price').val();
        if( sepc_line_price !='' && sepc_line_price!=undefined){
            $('input[name="spec_line_price[]"]').val(sepc_line_price);
        }
        var sepc_stock = $('.batch-spec-stock').val();
        if( sepc_stock !='' && sepc_stock!=undefined){
            $('input[name="spec_stock[]"]').val(sepc_stock);
            $('.spec_stock').trigger('change');
        }
        var sepc_weight = $('.batch-spec-weight').val();
        if( sepc_weight !='' && sepc_weight!=undefined){
            $('input[name="spec_weight[]"]').val(sepc_weight);
        }
    });
    //会员价格批量设置
    $(document).on('click',".btn-specBatchBtns",function(res){
    	$(".spec-batchs input").each(function(i,j){
    		var id = $(j).data('id');
    		var value = $(j).val();
			$("input[name='goods_counts_"+id+"[]']").val(value);
    	})
    })
    //分销佣金批量设置
    $(document).on('click',".btn-distribution",function(res){
    	$(".btn_distribution input").each(function(i,j){
    		var id = $(j).data('id');
    		var value = $(j).val();
			$("input[name='distrib_"+id+"[]']").val(value);
    	})
    })
    //验证是否输入的是数字
    $(document).on("input  propertychange",'.checkNum',function(){
        $(this).val($(this).val().replace(/[^0-9.]/g,''));//只能输入数字
        $(this).val( $(this).val().replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3')); //只能输入两个小数
    });
    //计算商品预计佣金
	$(document).on("input  propertychange","#g_commission",function () {
        $(this).val($(this).val().replace(/[^0-9]/g,''));//只能输入数字
        $(this).val( $(this).val().replace(/^(\-)*(\d+)\.(\d\d)/,'$1$2')); //只能输入两个小数
		var price = parseFloat($("#price").val());
		var g_commission = parseFloat($("#g_commission").val()/100);
		var res =0;

		res = price*g_commission;
		$('#g_commission_num').html(res.toFixed(2))
        console.log(price,g_commission,res,$('#g_commission_num'))
    })
	$('.good_nav').click(function(res){
		var id = $(this).data('id');
		$(".am-tabs-nav li").removeClass('am-active');
		$("#"+id).addClass('am-active');
		$(".nav_goods_add").hide();
		$(".nav_"+id).show();
	})
	//是否开启单品分销
	$("input[name='dis_type']").change(function(e){
		var i = $(this).val();
		if(i == 1){
			$('#distribution_goods').show();
		}else{
			$('#distribution_goods').hide();
		}
	})
	//是单品分销  还时多规格分销
	$("input[name='dis_rule']").change(function(e){
		var i = $(this).val();
		if(i == 1){
			$('#dis_rule_single').show();
			$('#dis_rule_many').hide();
		}else{
			$('#dis_rule_many').show();
			$('#dis_rule_single').hide();
		}
	})
</script>