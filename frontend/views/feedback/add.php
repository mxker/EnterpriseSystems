<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/18
 * Time: 15:57
 */
$this->title = '售后/工单';
$this->params['active_menu'] = 'feedback';
$this->params['header_titles'] = ['首页', '添加工单'];

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\widgets\upload\FileUpload;

$css = <<<EOF
    #feedbackform-content{
        height: 150px;
    }
    .upload{
        width:150px;
        line-height:100px;
        text-align: center;
    }
    .upload span{
        display:none;
    }
    .submit_data{
        margin-top:10px;
    }
EOF;
$this->registerCss($css);

?>
<div class="widget">
    <div class="widget-body">
        <h5 class="row-title before-themeprimary">添加工单</h5>
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['feedback/save'],
        ])?>
        <?php $model->feedback_catalog_id = $catalog['fc_id']?>

        <?= $form->field($model, 'feedback_catalog_id')->dropDownList($catalogs)->label('工单类型')?>
        <?= $form->field($model, 'order_id')->label('包裹|订单号')?>
        <?= $form->field($model, 'content')->textarea(['placeholder' => $catalog['remark']])->label('问题描述')?>
        <?= $form->field($model, 'attachment')->hiddenInput(['id' => 'img-box-hidden'])->label('附件')?>

        <div class="img-box upload-img" style="width: 150px; height: 100px; border: 1px darkgrey dashed;">
            <img src="" style="width: 150px; height: 100px; position: absolute">
        <?= FileUpload::widget([
            'model' => $modelFile,
            'attribute' => 'file',
            'url' => ['feedback/uploadImg'],
            'buttonClass' => 'upload',
            'options' => [
                'accept' => 'image/*',
                'class' => 'abc',
                'id' => 'upload-img',
            ],
            'clientOptions' => [
                'maxFileSize' => 2000000,
                'autoUpload' => true,
            ],
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {
                                    if(data.result.error){
                                        alert(data.result.error);
                                    }else{
                                        var pics = JSON.parse(data.result).files[0];
                                        $(".img-box img").attr("src",pics.thumbnailUrl);
                                        $("#img-box-hidden").val(pics.url);
                                        $(".upload span i").css("display","none");
                                    }
                                }',
            ],
        ]);?>
        </div>
        <span style="color: red;">注：请在此处上传问题信息图片，并保持图像清晰。每张图片小于2M。</span><br/>

        <?= Html::submitButton('提交工单', ['class' => 'btn btn-primary submit_data'])?>

        <?php ActiveForm::end()?>
    </div>
</div>
