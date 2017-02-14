<?php
/* @var $this yii\web\View */
$this->title = '系统设置';
$this->params['active_menu'] = ['system', 'logistics-channel'];
$this->params['header_titles'] = ['系统设置', '发货渠道'];

use yii\widgets\LinkPager;

$css = <<<EOF
    #pages{
        float:right;
        margin-top: 10px;
    }
    .table{
        margin-top:16px;
    }
    .alert{
        width:300px;
    }
EOF;
$this->registerCss($css);

//写入js
$js = <<<EOF
jQuery(function($){
    //渠道删除
    $('.removeInfo').click(function(){
        var lc_id = $(this).attr('catalogid');
        var csrfToken = $('input[name="_csrf"]').val();
        if(confirm('确认删除？')){
            removeInfo(lc_id, csrfToken);
            return;
        }
    });

    function removeInfo(lc_id, csrfToken){
        console.log(lc_id);
        console.log(csrfToken);
        $.ajax({
            url:'/logistics-channel/delete',
            type:"post",
            data:{'lc_id':lc_id,'_csrf':csrfToken},
            dataType:'json',
            success:function(result){
                return;
            }
        });
    }
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
            <i class="fa-fw fa fa-check"></i>
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
        <h5 class="row-title before-themeprimary">渠道列表</h5>
        <a href="add" class="btn btn-primary add-channel" style="float: right">添加发货渠道</a>
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>
                <i class="fa fa-tag"></i>渠道名称
            </th>
            <th class="hidden-xs">
                <i class="fa fa-map-marker"></i> 国家
            </th>
            <th>
                <i class="fa fa-retweet"></i> 海外渠道
            </th>
            <th>
                <i class="fa fa-retweet"></i> 国内渠道
            </th>
            <th>
                <i class="fa fa-truck"></i> 陌云渠道
            </th>
            <th>
                <i class="fa fa-fire"></i> 国内段
            </th>
            <th>
                <i class="fa fa-male"></i> 身份证
            </th>
            <th>
                <i class="fa fa-tag"></i> 关税
            </th>
            <th>
                <i class="fa fa-tag"></i> 渠道代码
            </th>
            <th width="10%">
                <i class="fa fa-gear"></i> 操作
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if($list){
            foreach($list as $k => $v){?>
                <tr>
                    <td>
                        <?php echo $v['name']?>
                    </td>
                    <td>
                        <?php echo $v['country']?>
                    </td>
                    <td class="hidden-xs">
                        <?php echo $v['overSea']?>
                    </td>
                    <td>
                        <?php echo $v['domestic']?>
                    </td>
                    <td>
                        <?php echo $v['is_moyun']?>
                    </td>
                    <td>
                        <?php echo $v['is_include_demestic']?>
                    </td>
                    <td>
                        <?php echo $v['is_idcard']?>
                    </td>
                    <td>
                        <?php echo $v['is_tariff']?>
                    </td>
                    <td>
                        <?php echo $v['code']?>
                    </td>
                    <td>
                        <a id="editInfo" href="edit?lc_id=<?php echo $v['lc_id']?>" catalogId = '<?php echo $v['lc_id']?>' class="btn btn-default btn-xs purple"><i class="fa fa-edit"></i> 编辑</a>
                        <a href="javascript:;" catalogId = '<?php echo $v['lc_id']?>' class="btn btn-default btn-xs red removeInfo"><i class="fa fa-trash-o"></i> 删除</a>
                    </td>
                </tr>
            <?php }}else{?>
                <tr><td colspan="10" align="center"><h3>暂时还没有发货渠道，请点击添加。</h3></td></tr>
        <?php }?>
        </tbody>
    </table>
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <!-- 分页 -->
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
