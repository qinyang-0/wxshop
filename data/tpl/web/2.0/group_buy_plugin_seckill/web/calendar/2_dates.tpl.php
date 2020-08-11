<?php defined('IN_IA') or exit('Access Denied');?><?php  for($i=0;$i<$week;$i++) { ?>
<div class="col-sm-2 date-item empty"></div>
<?php  } ?>

<?php  if(is_array($calendar)) { foreach($calendar as $k => $c) { ?>
<div class="col-sm-2 date-item <?php  if(is_array($c)) { ?>select<?php  } ?>" date="<?php  echo $k;?>" taskid="<?php echo is_array($c)? intval($c['taskid']): ''?>">
    <div class="date"><?php  echo date('d', strtotime($k))?></div>
    <div class="link" <?php  if(empty($c)) { ?>style="display:none"<?php  } ?> style="display:none">
    <a href="<?php echo $this->createWebUrl('index',array('op'=>'add','id'=>(is_array($c)?$c['taskid']:'')))?>" target="_blank" data-href="<?php  echo $this->createWebUrl('index',array('op'=>'add'))?>" class="btn-edit" title="编辑秒杀">
        <i class="fa fa-pencil"></i></a>

    <a href="<?php echo $this->createWebUrl('goods',array('op'=>'index','id'=>(is_array($c)?$c['taskid']:'')))?>" target="_blank" data-href="<?php  echo $this->createWebUrl('goods',array('op'=>'index'))?>" class="btn-goods"  title="查看商品">
        <i class="fa fa-shopping-cart"></i></a>
    <a href="javascript:;" class="btn-delete" title="取消"><i class="fa fa-trash-o"></i></a>
</div>
<a href="javascript:;" class="btn btn-set  <?php  if(!empty($c)) { ?>btn-set-has<?php  } ?>">
    <?php  if(empty($c)) { ?>
    选择
    <?php  } else { ?>
    [<?php  echo $c['taskid'];?>]<?php  echo $c['title'];?>
    <?php  } ?>
</a></div>
<?php  } } ?>
