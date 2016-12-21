<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\common\assets\DataTablesMinJs::register($this);
$this->title = '修改发货地址';
$this->params['active_menu'] = 'addr_sender';
$this->params['header_titles'] = ['发货地址', '修改'];

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
        <h5 class="row-title before-themeprimary" >修改发货地址</h5>
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
            <?php $model->country_id = $senderInfo['country_id']?>
            <?= $form->field($model, 'name')->textInput(['value' => $senderInfo['name']])?>
            <?= $form->field($model, 'country_id')->dropDownList($country)?>
            <?= $form->field($model, 'adress')->textInput(['value' => $senderInfo['adress']])?>
            <?= $form->field($model, 'postcode')->textInput(['value' => $senderInfo['postcode']])?>
            <?= $form->field($model, 'mob_phone')->textInput(['value' => $senderInfo['mob_phone']])?>
            <?= $form->field($model, 'as_id')->hiddenInput(['value' => $senderInfo['as_id']])?>

            <div class="col-lg-offset-4" style="padding-bottom: 50px;">
                <?= Html::submitButton('保存发货地址', ['class' => 'btn btn-primary'])?>
            </div>

            <?php ActiveForm::end()?>
        </div>
    </div>
</div>