<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/18
 * Time: 17:52
 */
$this->title = '售后/工单';
$this->params['active_menu'] = 'feedback';
$this->params['header_titles'] = ['首页', '回复工单'];

$css = <<<EOF
    .reply{
        font-size: 14px;
        margin-top:10px;
        margin-left:20px;
        line-height:30px;
    }
    .content{
        margin-left:70px;
    }
EOF;
$this->registerCss($css);
?>
<div class="widget  radius-bordered">
    <div class="widget-body">
        <h5 class="row-title before-themeprimary">工单详情</h5>
        <div class="reply">
            <p>订单编号：<?php echo $dataInfo['order_id'];?></p>
            <p>工单类型：<?php echo $dataInfo['type'];?></p>
            工单内容：<br/>
            <div class="content">
                <p><?php echo $dataInfo['user_name']?> 于 <?php echo $dataInfo['create_at']?> 提问：<?php echo $dataInfo['content']?></p>
                <?php if($contents){foreach($contents as $k => $v){?>
                    <p><?php echo $v['user_name']?> 于 <?php echo $v['create_at']?> 回复：<?php echo $v['content']?></p>
                <?php }}?>

                <form method="get" action="reply" >
                    <input type="hidden" name="feedback_id" value="<?php echo $dataInfo['feedback_id'];?>">
                    <input type="hidden" name="feedback_catalog_id" value="<?php echo $dataInfo['feedback_catalog_id'];?>">
                    <input type="hidden" name="order_id" value="<?php echo $dataInfo['order_id'];?>">
                    <textarea  rows="3" cols="80" name="content" placeholder="亲，请如实描述您的问题"></textarea><br/>
                    <button class="btn btn-primary" value="submit">回复</button>
                </form>
            </div>
        </div>
    </div>
</div>