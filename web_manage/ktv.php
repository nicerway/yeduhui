<?php
namespace Admin;
use Core\Page as Page;
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = $showname = 'ktv';

//条件
$map = array('pid'=>2,'ty'=>10,'tty'=>0);

###########################筛选开始
$id    =   I('get.id','','trim');if(!empty($id))$map['id'] = array('like',"%$id%");
$title =   I('get.title','','trim');if(!empty($title))$map['title'] = array('like',"%$title%");
$city_id =   I('get.city_id',0,'intval');if(!empty($city_id))$map['city_id'] = $city_id;
$cate_id =   I('get.cate_id',0,'intval');if(!empty($cate_id))$map['cate_id'] = $cate_id;
$istop2 =  I('get.istop2',0,'intval');if(!empty($istop2))$map['istop2'] = $istop2;
if(!empty($tty)) $map['tty'] = $tty;
###########################筛选开始
########################分页配置开始
$psize   =   I('get.psize',30,'intval');
$order='isgood desc,disorder desc,id desc';

$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => $order,
    /*条数*/'psize' => $psize,
    /*表  */'table' => $table,
    );
list($data,$pagestr) = Page::paging($pageConfig);
$opt = new Output;//输出流  输出表单元素
########################分页配置结束
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<?php include('js/head'); ?>
</head>
<body>
	<div class="content clr">
        <?php Style::weizhi() ?>
        <div class="right clr">
          <form class="" id="jsSoForm">
            <input type="hidden" name="pid" value="<?=$pid?>" />
            <input type="hidden" name="ty"  value="<?=$ty?>"  />
            <input type="hidden" name="tty" value="<?=$tty?>" />
            <!-- <b>显示</b><input style="width:50px;" name="psize" type="text" class="dfinput" value="<?=$psize?>"/>条 -->
            <!-- <b>编号</b><input name="id" type="text" class="dfinput" value="<?=$id?>"/> -->
      <?php
        $d2 = M('news')->where('pid=1 and ty=9')->order('disorder desc, isgood desc, id asc')->getField('id,title');Output::select2($d2,'城市','city_id');
      ?>
        <?php /*<?php if ($ty==8): ?>

        <?php endif ?>
        <?php if ($ty==10): ?>
            <?php
                $d2 = M('news')->where('pid=3 and ty=21')->order('disorder desc, isgood desc, id asc')->getField('id,title');Output::select2($d2,'风格','istop2');
             ?>
        <?php endif ?>
        <?php if ($ty==26): ?>
            <?php
                $d2 = M('news')->where('pid=4 and ty=27')->order('disorder desc, isgood desc, id asc')->getField('id,title');Output::select2($d2,'品牌','istop2');
             ?>
        <?php endif ?>*/ ?>
        关键字<input name="title" type="text" class="dfinput" value="<?=$title?>"/>
        <input name="search" type="submit" class="btn" value="搜索"/></td>
    </form>
    <div class="zhengwen clr">
      <div class="zhixin clr">
        <ul class="toolbar">
            <li>&nbsp;<input style="display:none" type="checkbox"><i id="sall" class="alls" onclick="selectAll(this)">&nbsp;</i><label style="cursor:pointer;font-size:9px" onclick="selectAll(document.getElementById('sall'))" for="">全选</label></li></li>
        </ul>
        <a href="?<?=queryString()?>" class="zhixin_a2 fl"></a><!-- 刷新  -->
        <a href="<?=getUrl(queryString(true),$showname.'_pro')?>" target="righthtml" class="zhixin_a3 fl"></a><!-- 添加  -->
        <input id="del" type="button" class="zhixin_a4 fl"/><!-- 删除  -->
        <?php Style::moveback() ?>
        <?php if (false && 5 == $showtype): // || 3 == $pid ?>
        <a style="background:none;border:1px solid;line-height:28px;text-align:center" href="content.php?<?=queryString()?>" class="fl">编辑详情</a>
    <?php endif ?>
</div>
</div>
<div class="neirong clr">
    <table cellpadding="0" cellspacing="0" class="table clr">
       <tr class="first">
        <td onclick="selectAll(document.getElementById('sall'))" style="font-size:8px;cursor:pointer" width="24px">全选</td>
        <td width="24px">编号</td> <td width="200px">操作</td>

    <?php
        $opt->td('图|width="24px"', '标题');
        $opt->td('发布时间|width="104px"');
     ?>
</tr>
<?php
    foreach ($data as $key => $bd) : extract($bd);

                            #生成修改地址
    $query = queryString(true);
    $query['id'] = $id;
    $editUrl = getUrl($query, $showname.'_pro');
                            #时间
    $time =  date('Y-m-d H:i',$sendtime);
    $img1 =  '<img src="'.src($img1).'" width="80" />';
    $img2 =  '<img src="'.src($img2).'" width="80" />';

    // $title = '<a href="' . U('blog/view', ['id'=>$id]) . '" target="_blank">'.$title.'</a>';
?>
<tbody>
    <tr>
        <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
        <td><?=$id?></td>
        <td>
            <a href="<?=$editUrl?>" class="thick ">编辑</a>|
            <?php if (false): //在首页?>
                <a data-class="btn-warm" class="json <?=$istop==1?'btn-warm':'' ?>" data-url="isindex&id=<?=$id?>"><?=config('webarr.isindex')[$istop] ?></a>|
            <?php endif ?>
            <a data-class="btn-danger" class="json <?=$isgood==1?'btn-danger':'' ?>" data-url="isgood&id=<?=$id?>"><?=config('webarr.isgood')[$isgood] ?></a>|
            <a data-class="btn-warm" class="json <?=$isstate==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=config('webarr.isstate')[$isstate] ?></a>|
            <!-- <a href="<?=$editUrl?>" class="thick edits">编辑</a>| -->
            <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>
        </td>
        <td><?=$img1?></td>
        <td><?=$title,' <i style="font-size:12px">'.$ftitle.'</i>'?></td>
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/if ($showtype==1):/*＜＞＜＞新闻＜＞＜＞*/?>
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==5):/*＜＞＜＞单条＜＞＜＞*/?>
            <td><?=$img1?></td>
            <td>
                <?php if ($ty==12): ?>
                    <a href="pic.php?ti=<?=$id?>&ci=4">荣誉(<?=M('pic')->where("ti=$id and ci=4 and isstate=1")->count()?>个)</a>
                <?php endif ?>
                <?php if ($ty==29): ?>
                    <a href="link.php?showtype=5&istop2=<?php echo $id ?>">下属列表(<?=M('news')->where('istop2='.$id)->count()?>)</a>
                <?php endif ?>
                <?=$title,'&emsp;',$ftitle,'&emsp;',$name?>
            <!-- <span class="fr"><a href="link.php?showtype=6&istop=<?php echo $id ?>">下属列表</a></span> --></td>
            <!-- <td><a href="pic.php?ti=<?=$id?>">图集(<?php echo M('pic')->where("ti=$id and isstate=1")->count()?>条)</a></td> -->
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==9):/*＜＞＜＞产品＜＞＜＞*/?>
        <td><?=$img1?></td>
        <td><?=$title,'&emsp;',$ftitle,'&emsp;',$name?><!-- <a href="pic.php?ti=<?php echo $id?>">图集(<?php echo M('pic')->where("ti=$id")->count(); ?>)</a> --></td>

        <?php if ($ty==11): ?><td><?=isset($d1[$istop]) ? $d1[$istop] : '','&emsp;',isset($d2[$istop2]) ? $d2[$istop2] : '' ?></td><?php endif ?>
        <!-- <td><?=$hits?></td> -->
        <!-- <a href="pic.php?ti=<?=$id?>&cid=5">户型介绍(<?//=M('pic')->where("ti=$id and cid=5 and isstate=1")->count()?>条)</a> -->
        <?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==10):/*＜＞＜＞产品分类＜＞＜＞*/?>
        <td><?=$title?></td>
        <td><a href="link.php?showtype=10&istop=<?php echo $id ?>">下属区域(<?=M('news')->where('istop='.$id)->count()?>)</a></td>
        <td><a href="link.php?showtype=10&istop2=<?php echo $id ?>">下属商圈(<?=M('news')->where('istop2='.$id)->count()?>)</a></td>

<!-- <td><span data-content="<?=$introduce?>" class="lookinfo layui-btn layui-btn-primary layer-demolist">查看简介</span></td> -->
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/elseif ($showtype==11):/*＜＞＜＞图文列表＜＞＜＞*/?>
        <td><?=$img1?></td>
        <td>
            <?php if ($ty==10||$ty==13): ?>
                <a href="pic.php?ti=<?=$id?>&ci=1">平面户型图(<?=M('pic')->where("ti=$id and ci=1 and isstate=1")->count()?>张)</a>
                <a href="pic.php?ti=<?=$id?>&ci=2">三维户型图(<?=M('pic')->where("ti=$id and ci=2 and isstate=1")->count()?>张)</a>
                <a href="pic.php?ti=<?=$id?>&ci=3">效果图(<?=M('pic')->where("ti=$id and ci=3 and isstate=1")->count()?>张)</a>
            <?php endif ?>
            <?=$title,'&emsp;',$ftitle,'&emsp;',$name?>
        </td>
<?php /*＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞＜＞*/endif?>
     <td><?=$time?></td>
 </tr>
<?php endforeach?>
<?php include('js/foot'); ?>
<!-- <td><?=$img1?><a class="lookPic" href="javascript:;" data-id="<?=$id?>">添加更多图片(<?=M('pic')->where("ti=$id")->count()?>个)</a></td> -->
