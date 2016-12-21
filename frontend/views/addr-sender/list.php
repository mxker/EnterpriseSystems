<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

\common\assets\DataTablesMinJs::register($this);

$this->title = '发货地址列表';
$this->params['active_menu'] = 'addr_sender';
$this->params['header_titles'] = ['发货地址', '列表'];

$css = <<<EOF
    #pages{
        float:right;
        margin-top: 10px;
    }
    .widget-header{
        text-align:left;
    }
    .table{
        margin-top:16px;
    }

EOF;
$this->registerCss($css);
$js = <<<EOF
jQuery(function($){
    //删除发货地址
    $('.removeInfo').click(function(){
        var as_id = $(this).attr('catalogid');
        var csrfToken = $('input[name="_csrf"]').val();
        if(confirm('确认删除？')){
            removeInfo(as_id, csrfToken);
            return;
        }
    });

    function removeInfo(as_id, csrfToken){
        $.ajax({
            url:'/addr-sender/delete',
            type:"post",
            data:{'as_id':as_id,'_csrf':csrfToken},
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
    <div class="header bordered-pink">
        <h5 class="row-title before-themeprimary" >已有发货地址</h5>
        <a href="#add-adr" class="btn btn-primary add-channel" style="float: right">新增发货地址</a>
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>
                <i class="fa fa-user"></i>发件人
            </th>
            <th width="10%">
                <i class="fa fa-flag-checkered"></i> 国家
            </th>
            <th width="30%">
                <i class="fa fa-flag-checkered"></i> 详细地址
            </th>
            <th>
                <i class="fa  fa-envelope"></i> 邮编
            </th>
            <th>
                <i class="fa fa-mobile"></i> 电话/手机
            </th>
            <th width="10%">
                <i class="fa fa-gear"></i> 操作
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if($senderList){
            foreach($senderList as $k => $v){?>
                <tr>
                    <td>
                        <?php echo $v['name']?>
                    </td>
                    <td>
                        <?php echo $v['country']?>
                    </td>
                    <td>
                        <?php echo $v['adress']?>
                    </td>
                    <td>
                        <?php echo $v['postcode']?>
                    </td>
                    <td>
                        <?php echo $v['mob_phone']?>
                    </td>
                    <td>
                        <a id="editInfo" href="edit?asid=<?php echo $v['as_id']?>" catalogId = '<?php echo $v['as_id']?>' class="btn btn-default btn-xs purple"><i class="fa fa-edit"></i> 修改</a>
                        <a href="javascript:;" catalogId = '<?php echo $v['as_id']?>' class="btn btn-default btn-xs black removeInfo"><i class="fa fa-trash-o"></i> 删除</a>
                    </td>
                </tr>
            <?php }}else{?>
                <tr><td colspan="6" align="center"><h3>暂时还没有发货地址哟~！</h3></td></tr>
        <?php }?>
        </tbody>
    </table>
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

<div class="widget  radius-bordered">
    <div class="widget-header">
        <h5 id="add-adr" class="row-title before-themeprimary" >新增发货地址</h5>
    </div>
    <div class="widget-body">
        <div id="togglingForm" class="form-horizontal bv-form">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['addr-sender/add'],
            'fieldConfig'=>[
                'template'=> "<div class=\"form-group has-feedback\">
                                <label class=\"col-lg-4 control-label\">{label}\n</label>
                                <div class=\"col-lg-4\">{input}</div>\n{error}
                               </div>",
            ]
        ])?>

        <?= $form->field($model, 'name')->label('发件人姓名：')?>
        <?= $form->field($model, 'country_id')->dropDownList($country)->label('所属国家：')?>
        <?= $form->field($model, 'adress')->label('详细地址：')?>
        <?= $form->field($model, 'postcode')->label('邮政编码：')?>
        <?= $form->field($model, 'mob_phone')->label('手机号码：')?>

        <div class="col-lg-offset-4" style="padding-bottom: 50px;">
        <?= Html::submitButton('保存发货地址', ['class' => 'btn btn-primary'])?>
        </div>

        <?php ActiveForm::end()?>
        </div>
    </div>
</div>

