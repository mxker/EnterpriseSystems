<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/18
 * Time: 14:19
 */
$this->title = '发货渠道';
$this->params['active_menu'] = ['system', 'logistics-channel'];
$this->params['header_titles'] = ['发货渠道', '编辑渠道'];

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$css = <<<EOF
    .widget input[type=radio]{
        left: 0px !important;
        opacity:80 !important;
        position:absolute !important;
        z-index:12 !important;
        width:15px !important;
        height:15px !important;
        cursor:pointer !important;
    }
    .radio{
       margin-left: 30px;
    }
EOF;
$this->registerCss($css);

$js = <<<EOF
jQuery(function($){
    $('#logisticschannelform-code').blur(function(){
        var code = $(this).val();
        var lc_id = $('#logisticschannelform-lc_id').val();
        var csrfToken = $('input[name="_csrf"]').val();
        if(code){
            ValidateCode(lc_id,code,csrfToken);
            return false;
        }
    });

    function ValidateCode(lc_id,code,csrfToken){
        $.ajax({
            url:'/logistics-channel/validate',
            type:"post",
            data:{'lc_id':lc_id,'code':code,'_csrf':csrfToken},
            dataType:'json',
            success:function(result){
                console.log(result);
                if(result != 1){
                    $('.hint').hide();
                    var code = "<span class= 'hint' style = 'color:red;'>渠道代码不能重复，请重新修改</span>";
                    $('#logisticschannelform-code').parent().append(code);
                    $('.validate').attr('disabled','disabled');
                }else{
                    $('.hint').hide();
                    $('.validate').removeAttr('disabled');
                }
                return;
            }
        });
    }
})
EOF;
$this->registerJs($js,$this::POS_END);
?>

<div class="widget  radius-bordered">
    <div class="widget-body">
        <h5 class="row-title before-themeprimary">编辑发货渠道</h5>
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['logistics-channel/save'],
        ])?>


        <!--  注册select的默认值   -->
        <?php $model->country_id = $channelInfo['country_id']?>
        <?php $model->channel_overseas_id = $channelInfo['channel_overseas_id']?>
        <?php $model->channel_domestic_id = $channelInfo['channel_domestic_id']?>

        <!--  注册radio的默认值   -->
        <?php $model->is_moyun = $channelInfo['is_moyun']?>
        <?php $model->is_include_demestic = $channelInfo['is_include_demestic']?>
        <?php $model->is_idcard = $channelInfo['is_idcard']?>
        <?php $model->is_tariff = $channelInfo['is_tariff']?>

        <?= $form->field($model, 'name')->textInput(['value' => $channelInfo['name']])?>
        <?= $form->field($model, 'country_id')->dropDownList($country)?>
        <?= $form->field($model, 'channel_overseas_id')->dropDownList($overSeasList)?>
        <?= $form->field($model, 'channel_domestic_id')->dropDownList($domesticList)?>

        <?= $form->field($model, 'start_weight')->textInput(['value' => $billing_rules['start_weight']])->label('首重(kg)')?>
        <?= $form->field($model, 'start_fee')->textInput(['value' => $billing_rules['start_fee']])->label('起步费用(￥)')?>
        <?= $form->field($model, 'first_weight')->textInput(['value' => $billing_rules['first_weight']])->label('第一阶梯重量(kg)')?>
        <?= $form->field($model, 'first_weight_unit')->textInput(['value' => $billing_rules['first_weight_unit']])->label('第一阶梯续重计重单位')?>
        <?= $form->field($model, 'first_fee')->textInput(['value' => $billing_rules['first_fee']])->label('第一阶梯费用(￥)')?>
        <?= $form->field($model, 'second_weight')->textInput(['value' => $billing_rules['second_weight']])->label('第二阶梯重量(kg)')?>
        <?= $form->field($model, 'second_weight_unit')->textInput(['value' => $billing_rules['second_weight_unit']])->label('第二阶梯续重计重单位')?>
        <?= $form->field($model, 'second_fee')->textInput(['value' => $billing_rules['second_fee']])->label('第二阶梯费用(￥)')?>
        <?= $form->field($model, 'code')->label('渠道代码')->textInput(['value' => $channelInfo['code']])?>

        <?= $form->field($model, 'is_moyun')->radioList(['1' => '是', '0' => '否'])->label('是否为陌云渠道')?>
        <?= $form->field($model, 'is_include_demestic')->radioList(['1' => '是', '0' => '否'])->label('是否包含国内段')?>
        <?= $form->field($model, 'is_idcard')->radioList(['1' => '是', '0' => '否'])->label('是否有身份证')?>
        <?= $form->field($model, 'is_tariff')->radioList(['1' => '是', '0' => '否'])->label('是否需要交纳关税')?>

        <?= $form->field($model, 'lc_id')->hiddenInput(['value' => $channelInfo['lc_id']])?>

        <?= Html::submitButton('保存渠道', ['class' => 'btn btn-primary validate'])?>

        <?php ActiveForm::end()?>
    </div>
</div>
