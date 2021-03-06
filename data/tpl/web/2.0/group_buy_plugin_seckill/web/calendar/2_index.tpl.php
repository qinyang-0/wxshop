<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    #calendar .header {

        width: 840px;
        height: 40px;
        margin-bottom: 40px;

    }

    #calendar .weeks {
        border-bottom: 1px solid #ccc;
        width: 840px;
        height: 40px;
        line-height: 40px;
        background: #f2f2f2;
    }

    #calendar .weeks .col-sm-2 {
        width: 120px;
        font-weight: bold;
        text-align: center;
    }

    #calendar .dates {
        width: 840px;
        height: 120px;
        text-align: center;

    }

    #calendar .dates .col-sm-2 {
        position: relative;
        width: 120px;
        height: 120px;
        text-align: center;
        background: #fefefe;
        line-height: 110px;
        border: 1px solid #f2f2f2;
    }


    #calendar .dates .col-sm-2 .btn {
        margin: 0;

        color:#fff;
        overflow: hidden;

        -ms-word-break: break-all;
        word-break: break-all;
        word-wrap: break-word;
        white-space:normal;

        max-height:50px;
        background:#f2f2f2;
        color:#333;

    }
    #calendar .dates .col-sm-2 .btn.btn-set-has {
        background: #22c397;
        color:#fff;
    }
    #calendar .dates .col-sm-2 .date{
        position:absolute;
        right:0;top:5px;
        font-size:14px;
        color:#999;
        line-height:20px;
        display:inline-block;width:20px;height:20px;
    }
    #calendar .dates .col-sm-2 .link{
        position:absolute;
        right:0;bottom:5px;
        font-size:14px;
        color:#666;
        line-height:20px;
        text-align: center;
        display:inline-block;width:120px;height:20px;
        display: none;

    }

    #loading {
        width:100%;
        padding:20px 0;
        text-align: center;;
    }

    #calendar .dates .col-sm-2.select {
        /*background:#fefdeb;*/
    }
    #calendar .dates .col-sm-2 a {
        color:#666;
    }
</style>
<!-- 内容区域 start -->
<div class="tpl-content-wrapper">
    <div class="row-content am-cf">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf">任务设置</div>
                    </div>
                    <!--用来弹窗回调传值-->
                    <input id="hlep-param" type="hidden" value=""/>
                    <div class="widget-body am-fr">
                        <!-- 工具栏 -->
                        <div class="page-content">
                            <div class="row">
                                <div class="alert alert-danger">
                                    <p>注意：秒杀任务使用Redis存储 , 设置好秒杀任务后 , 请勿清理平台系统缓存 , 以免秒杀任务丢失</p>
                                </div>
                                <div class="col-sm-12">
                                    <div id="calendar">
                                        <div class="header">
                                            <div>
                                                <label for="" style="vertical-align: sub">批量设置:</label>
                                                <label class="am-checkbox-inline am-success">
                                                    <input type="checkbox"  value="all" checked data-am-ucheck/> 全月
                                                </label>
                                                <label class="am-checkbox-inline am-success" >
                                                    <input type="checkbox"  value="1" checked data-am-ucheck/> 周一
                                                </label>
                                                <label class="am-checkbox-inline am-success" style="">
                                                    <input type="checkbox"  value="2" checked data-am-ucheck/> 周二
                                                </label>
                                                <label class="am-checkbox-inline am-success" style="">
                                                    <input type="checkbox"  value="3" checked data-am-ucheck/> 周三
                                                </label>
                                                <label class="am-checkbox-inline am-success" style="">
                                                    <input type="checkbox"  value="4" checked data-am-ucheck/> 周四
                                                </label>
                                                <label class="am-checkbox-inline am-success" style="">
                                                    <input type="checkbox"  value="5"  checked data-am-ucheck/> 周五
                                                </label>
                                                <label class="am-checkbox-inline am-success" style="">
                                                    <input type="checkbox"  value="6" checked data-am-ucheck/> 周六
                                                </label>
                                                <label class="am-checkbox-inline am-success" style="">
                                                    <input type="checkbox"  value="7" checked data-am-ucheck/> 周日
                                                </label>

                                                <span class=" pull-right">
                            <select class="form-control" style="width:100px;display:inline-block;"  id="year">
                                <?php  if(is_array($years)) { foreach($years as $y) { ?>
                                <option value="<?php  echo $y;?>" <?php  if($currentyear==$y) { ?>selected<?php  } ?>><?php  echo $y;?></option>
                                <?php  } } ?>
                            </select>
                                    年
                                    <select class="form-control" style="width:100px;display:inline-block;" id="month">
                                        <?php  if(is_array($months)) { foreach($months as $m) { ?>
                                        <option value="<?php  echo $m;?>" <?php  if($currentmonth==$m) { ?>selected<?php  } ?>><?php  echo $m;?></option>
                                        <?php  } } ?>
                                    </select>
                                    月
                        </span>
                                            </div>

                                            <div class="input-group">
                                                <a href="javascript:;" class="btn btn-default btn-sm btn-batch-set" style="display:inline-block;margin-top:10px">批量设置</a>
                                                <a href="javascript:;" class="btn btn-default btn-sm btn-batch-delete" style="display:inline-block;margin-top:10px">批量取消</a>
                                                <a href="javascript:;" class="btn btn-default btn-sm btn-clear" style="display:inline-block;margin-top:10px">清空当月</a>
                                            </div>


                                        </div>
                                        <div class="weeks">
                                            <div class="col-sm-2">日</div>
                                            <div class="col-sm-2">一</div>
                                            <div class="col-sm-2">二</div>
                                            <div class="col-sm-2">三</div>
                                            <div class="col-sm-2">四</div>
                                            <div class="col-sm-2">五</div>
                                            <div class="col-sm-2">六</div>
                                        </div>
                                        <div id="loading"><i class="fa fa-spinner fa-spin"></i> 正在加载数据</div>
                                        <div id="dates" class="dates">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language="javascript">
        function getDates(){
            year = $('#year').val();
            month = $('#month').val();
            $('#loading').show();
            $('#dates').html('');
            $.ajax({
                url: "<?php  echo $this->createWebUrl('calendar',array('op'=>'dates'))?>",
                data: {year:year,month:month},
                cache:false,
                dataType:'html',
                type:'POST',
                success:function(html){
                    $('#dates').html( html );
                    $('#loading').hide();
                    bindEvents();
                }
            })
        }
        var currentDate = null;
        function bindEvents(){


            $('.btn-set').click(function(){
                var btn = $(this);
                var item = btn.closest('.date-item');
                currentDate = item.attr('date');
                console.log(1);
                layer.open({
                    type: 2,
                    title: '选择秒杀',
                    closeBtn: 1, //不显示关闭按钮
                    shade: [0.3, '#000'],
                    maxmin:true,
                    resize:false,
                    shadeClose: false,
                    area: ['750px', '500px'],
                    anim: 5,
                    content: "<?php  echo $this->createWebUrl('calendar',array('op'=>'query'))?>",
                    end: function(data,obj){
                        var taskid = $('#hlep-param').val();
                        console.log(taskid);
                        $('#hlep-param').val('')
                        if(parseInt(taskid)>0){
                            $.ajax({
                                url: "<?php  echo $this->createWebUrl('calendar',array('op'=>'set'))?>",
                                data: {taskid: taskid , date: currentDate},
                                dataType:'json',
                                type:'POST',
                                success:function(ret){
                                    if(ret.status==1){
                                        btn.addClass('btn-set-has').html( "[" + taskid + "]"+ ret.data.title + "");
                                        item.attr('taskid',taskid).addClass('select').find('.link').show();
                                        var btngoods = item.find('.btn-goods');
                                        btngoods.attr('href' , btngoods.data('href') + "&taskid=" + taskid);

                                        var btnedit = item.find('.btn-edit');
                                        btnedit.attr('href' , btnedit.data('href') + "&id=" + taskid);
                                        bindHover();
                                        return;
                                    }
                                    layer.msg(ret.msg);
                                }
                            });
                        }
                        console.log(taskid)
                        //layer.closeAll();
                    },
                    success:function(layero, index){

                    }
                });

            });


            $('.btn-delete').click(function(){
                var btn = $(this);
                var item = btn.closest('.date-item');
                currentDate = item.attr('date');

                layer.confirm('确认取消 ' + currentDate + " 的秒杀?",function(index){

                    btn.button('loading');
                    $.ajax({
                        url: "<?php  echo $this->createWebUrl('calendar',array('op'=>'delete'))?>",
                        data: { date: currentDate},
                        dataType:'json',

                        type:'POST',
                        success:function(ret){
                            if(ret.status==1) {
                                item.find('.btn-set').html('选择');
                                btn.button('reset'),item.attr('taskid','').find('.link').hide();
                                item.find('.btn-set').removeClass('btn-set-has');
                                bindHover();
                                layer.close(index);
                                return;
                            }
                            layer.msg(ret.msg);
                            layer.close(index);
                        }
                    });

                });
            });
            bindHover();
        }

        function bindHover(){
            $('.date-item').unbind('mouseover').mouseover(function(){

                if( $(this).attr('taskid')){

                    $(this).find('.link').show();

                }else{
                    $(this).find('.link').hide();
                }

            }).unbind('mouseout').mouseout(function(){
                $(this).find('.link').hide();

            })
        }
        $(function(){

            getDates();

            $('#year,#month').change(function(){
                getDates();
            });

            $(':checkbox').click(function(){
                var val  =$(this).val();
                var checked = $(this).prop('checked');
                if(val=='all'){
                    $(':checkbox').prop('checked',checked);
                }else{
                    if( !checked){
                        $(':checkbox[value="all"]').prop('checked',false);
                    }
                }
            });

            $('.btn-clear').click(function(){
                var btn = $(this);
                year = $('#year').val();
                month = $('#month').val();
                layer.confirm('确认要清空 ' + month + "年" + month+"月份的秒杀吗?",function(index){
                    btn.button('loading');
                    $.ajax({
                        url: "<?php  echo $this->createWebUrl('calendar',array('op'=>'clear'))?>",
                        data: { year: year,month:month},
                        dataType:'json',
                        type:'POST',
                        success:function(ret){
                            if(ret.status==1) {
                                btn.button('reset');
                                $('.date-item').each(function(){
                                    var obj = $(this);
                                    obj.removeClass('select').attr('taskid','');
                                    obj.find('.link').hide(),obj.find('.btn-set').removeClass('btn-set-has').html('选择');
                                });
                                bindHover();
                                layer.close(index);
                                return;
                            }
                            layer.msg(ret.msg);
                            layer.close(index);
                        }
                    });
                });
            });


            $('.btn-batch-set').click(function(){
                var btn = $(this);

                var days = $(':checkbox:checked').map(function () {
                    return $(this).val()
                }).get();

                year = $('#year').val();
                month = $('#month').val();
                layer.open({
                    type: 2,
                    title: '选择秒杀',
                    closeBtn: 1, //不显示关闭按钮
                    shade: [0.3, '#000'],
                    maxmin:true,
                    resize:false,
                    shadeClose: false,
                    area: ['750px', '500px'],
                    anim: 5,
                    content: "<?php  echo $this->createWebUrl('calendar',array('op'=>'query'))?>",
                    end: function(data,obj){
                        var taskid = $('#hlep-param').val();
                        console.log(taskid);
                        $('#hlep-param').val('')
                        if(parseInt(taskid)>0){
                            $.ajax({
                                url: "<?php  echo $this->createWebUrl('calendar',array('op'=>'batch_set'))?>",
                                data: {taskid: taskid , year:year,month:month, days: days},
                                dataType:'json',
                                type:'POST',
                                success:function(ret){
                                    if(ret.status==1) {
                                        $('.date-item').each(function () {
                                            var item = $(this), btn = item.find('.btn-set');
                                            console.log(item.attr('date'))
                                            console.log(item.attr('date'))
                                            if (ret.dates.indexOf(item.attr('date')) != -1) {
                                                item.removeClass('select').attr('taskid', '');
                                                item.find('.link').hide(), item.find('.btn-set').removeClass('btn-set-has').html('选择');
                                            }
                                        });
                                        bindHover();
                                        window.location.reload();
                                        return;
                                    }
                                    layer.msg(ret.msg);
                                }
                            });
                        }
                        console.log(taskid)
                        //layer.closeAll();
                    },
                    success:function(layero, index){

                    }
                });
                // biz.selector_open.select({
                //     'name': 'task_batch_set',
                //     'readonly': true,
                //     'url':"<?php  echo $this->createWebUrl('calendar',array('op'=>'query'))?>",
                //     'nokeywords':1,
                //     'autosearch':1,
                //     'placeholder':'请输入秒杀标题',
                //     'callback':function(data,obj){
                //
                //         var taskid = data.id;
                //         $.ajax({
                //             url: "<?php  echo $this->createWebUrl('calendar',array('op'=>'batch_set'))?>",
                //             data: {taskid: taskid , year:year,month:month, days: days},
                //             dataType:'json',
                //             type:'POST',
                //             success:function(ret){
                //                 if(ret.status==1){
                //                     $('.date-item').each(function(){
                //
                //                         var item = $(this),btn = item.find('.btn-set');
                //                         if( ret.result.dates.indexOf(item.attr('date'))!=-1){
                //                             item.removeClass('select').attr('taskid','');
                //                             item.find('.link').hide(),item.find('.btn-set').removeClass('btn-set-has').html('选择');
                //                         }
                //
                //                     });
                //                     bindHover();
                //                     return;
                //                 }
                //                 layer.msg(ret.msg);
                //             }
                //         });
                //     }
                // });
            });


            $('.btn-batch-delete').click(function(){
                var btn = $(this);

                var days = $(':checkbox:checked').map(function () {
                    return $(this).val()
                }).get();

                year = $('#year').val();
                month = $('#month').val();
                layer.confirm('确认要取消这些日期的秒杀吗?',function(index){
                    $.ajax({
                        url: "<?php  echo $this->createWebUrl('calendar',array('op'=>'batch_delete'))?>",
                        data: {year:year,month:month, days: days},
                        dataType:'json',
                        type:'POST',
                        success:function(ret){
                            if(ret.status==1){
                                $('.date-item').each(function(){

                                    var item = $(this),btn = item.find('.btn-set');
                                    if( ret.dates.indexOf(item.attr('date'))!=-1){
                                        item.removeClass('select').attr('taskid','');
                                        item.find('.link').hide(),item.find('.btn-set').removeClass('btn-set-has').html('选择');
                                    }

                                });
                                bindHover();
                                layer.close(index);
                                return;
                            }
                            layer.close(index);
                            layer.msg(ret.msg);
                        }
                    });
                });
            });
        })
    </script>

</div>
<!-- 内容区域 end -->
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>