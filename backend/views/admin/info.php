<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\common\assets\DataTablesMinJs::register($this);
$this->title = '系统设置';
$this->params['active_menu'] = ['home', 'info'];
$this->params['header_titles'] = ['系统设置', '公司信息'];

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
$js = <<< EOF
jQuery(function ($){

})
EOF;
$this->registerJs($js,$this::POS_END);
?>

<div class="widget  radius-bordered">
    <div class="widget-header">
        <h5 class="row-title before-themeprimary" >基本信息</h5>
    </div>
    <div class="widget-body">
        <div id="togglingForm" class="form-horizontal bv-form">
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['addr-sender/save'],
                'fieldConfig'=>[
                    'template'=> "<div class=\"form-group has-feedback\">
                                <label class=\"col-lg-4 control-label\">{label}\n</label>
                                <div class=\"col-lg-4\">{input}</div>\n{error}
                               </div>",
                ]
            ])?>

            <!--  注册select的默认值   -->
            <?= $form->field($model, 'company_name')->label('公司名称')?>
            <?= $form->field($model, 'company_tel')?>
            <?= $form->field($model, 'company_logo')?>
            <?= $form->field($model, 'company_area')?>
            <?= $form->field($model, 'culture')?>
            <?= $form->field($model, 'description')?>

            <div class="col-lg-offset-4" style="padding-bottom: 50px;">
                <?= Html::submitButton('保存并修改', ['class' => 'btn btn-primary'])?>
            </div>

            <?php ActiveForm::end()?>
        </div>
    </div>
</div>