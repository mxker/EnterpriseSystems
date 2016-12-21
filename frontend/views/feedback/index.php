<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;

$this->title = '售后/工单';
$this->params['active_menu'] = 'feedback';
$this->params['header_titles'] = ['首页', '售后/工单'];
$css = <<<EOF
    #pages{
        float:right;
        margin-top: 10px;
    }
    .remark{
        height: 50px;
    }
    .remark p{
        line-height: 50px;
    }
    .table{
        margin-top:16px;
    }
    .alert{
        width:350px;
    }
    .for-search{
        float:right;
    }
EOF;
$this->registerCss($css);

$js = <<<EOF
jQuery(function($){
    //删除
    $('.removeInfo').click(function(){
        var feedback_id = $(this).attr('catalogid');
        var csrfToken = $('input[name="_csrf"]').val();
        if(confirm('确认删除？')){
            removeInfo(feedback_id, csrfToken);
            return;
        }
    });

    function removeInfo(feedback_id, csrfToken){
        $.ajax({
            url:'/feedback/delete',
            type:"post",
            data:{'feedback_id':feedback_id,'_csrf':csrfToken},
            dataType:'json',
            success:function(result){
                return;
            }
        });
    }
    $(".glyphicon-search").on("click",function(){
        $("#searchFeedback").submit();
    });
})
EOF;
$this->registerJs($js,$this::POS_END);

?>
<div class="well with-header with-footer">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success fade in">
            <button class="close" data-dismiss="alert">
                ×
            </button>
            <strong><?php echo Yii::$app->session->getFlash('success') ?></strong>
        </div>
    <?php elseif(Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger fade in">
            <button class="close" data-dismiss="alert" style="color: white">
                ×
            </button>
            <strong><?php echo Yii::$app->session->getFlash('error') ?></strong>
        </div>
    <?php endif ?>

    <div class="header bordered-pink">
        <h5 class="row-title before-themeprimary">我的工单</h5>
        <form id="searchFeedback" method="get" class="for-search">
            <span class="input-icon icon-right inverted widget-caption">
                <select name="type_id" style="margin-right: 33px;">
                    <?php if($types){foreach($types as $k=>$value){?>
                        <option value="<?php echo $value['fc_id'];?>"><?php echo $value['name'];?></option>
                    <?php }}?>
                </select>
                <i class="glyphicon glyphicon-search bg-darkorange" style="cursor:pointer"></i>
            </span>
        </form>
        <a href="#add" class="btn btn-primary add-channel" style="float: right;margin-right: 10px;">新增工单</a>
    </div>
    <table class="table table-stripe  table-bordered table-hover">
        <thead>
        <tr>
            <th width="10%">
                <i class="fa fa-circle-o"></i>工单编号
            </th>
            <th>
                <i class="fa fa-circle-o"></i>订单编号
            </th>
            <th width="40%">
                <i class="fa fa-question-circle"></i> 问题内容
            </th>
            <th width="10%">
                <i class="fa fa-tasks"></i> 工单类型
            </th>
            <th width="10%">
                <i class="fa  fa-calendar-o"></i> 提交时间
            </th>
<!--            <th width="10%">-->
<!--                <i class="fa  fa-cog"></i> 状态-->
<!--            </th>-->
            <th width="10%">
                <i class="fa fa-cutlery"></i> 操作
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if($list){
            foreach($list as $k => $v){?>
                <tr>
                    <td>
                        <?php echo $v['feedback_id']?>
                    </td>
                    <td>
                        <?php echo $v['order_id']?>
                    </td>
                    <td>
                        <?php echo $v['content']?>
                    </td>
                    <td>
                        <?php echo $v['feedback_catalog']?>
                    </td>
                    <td>
                        <?php echo $v['create_at']?>
                    </td>
<!--                    <td>-->
<!--                        --><?php //echo $v['create_at']?>
<!--                    </td>-->
                    <td>
                        <a id="editInfo" href="edit?feedback_id=<?php echo $v['feedback_id']?>" catalogId = '<?php echo $v['feedback_id']?>' class="btn btn-default btn-xs purple"><i class="fa fa-edit"></i> 回复</a>
                        <a href="javascript:;" catalogId = '<?php echo $v['feedback_id']?>' class="btn btn-default btn-xs red removeInfo"><i class="fa fa-trash-o"></i> 删除</a>
                    </td>
                </tr>
            <?php }}else{?>
                <tr><td colspan="6" align="center"><h3>暂时还没有工单哟~！</h3></td></tr>
        <?php }?>
        </tbody>
    </table>
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="page" id="pages">
        <?= LinkPager::widget([
            'pagination' => $pages,
            'firstPageLabel' => '首页',
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'lastPageLabel' => '尾页',
        ]); ?>
    </div>
</div>
<div class="well">
    <h5 id="add" class="row-title before-themeprimary">提交工单</h5>
    <div class="row pricing-container">
        <?php foreach($catalogs as $key => $catalog){?>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="plan">
                <div class="header bordered-azure"><?php echo $catalog['name']?></div>
                <div class="monthly remark"><P><?php echo $catalog['remark']?></P></div>
<!--                <a class="btn btn-primary " href="add?fc_id=--><?php //echo $catalog['fc_id']?><!--">点此提交</a>-->
                <a class="signup bg-orange" href="add?fc_id=<?php echo $catalog['fc_id']?>">点此提交</a>
            </div>
        </div>
        <?php }?>
    </div>
</div>
