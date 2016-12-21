<?php
use frontend\assets\PortalAsset;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

PortalAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SuperB-Grace 注册</title>
    <?php $this->head()?>
    <style type="text/css">
        .form-horizontal .form-group{margin: 0;}
    </style>

</head>
<!-- /Head -->
<!-- Body -->
<body>
<?php $this->beginBody()?>
    <div class="register-container animated fadeInDown">
        <div class="registerbox bg-white">

            <div class="registerbox-title">用户注册</div>
            <div class="registerbox-caption ">请填入以下信息</div>
            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "<div class=\"registerbox-textbox\">{input}{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]);?>

                <?=$form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')])?>
                <?=$form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')])?>
                <?=$form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])?>
                <?=$form->field($model, 'repassword')->passwordInput(['placeholder' => $model->getAttributeLabel('repassword')])?>
                <?=$form->field($model, 'verifyCode')->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6 col-sm-6 col-xs-6 padding-right-10">{input}</div></div>',
                    'options' => ['placeholder' => $model->getAttributeLabel('verifyCode'), 'class' => 'form-control', 'autocomplete' => 'off']
                ])?>

                <div class="registerbox-textbox no-padding-bottom">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="colored-primary" name="primary">
                            <span class="text darkgray">我同意SuperB-Grace <a class="themeprimary" href="#">注册协议</a></span>
                        </label>
                    </div>
                </div>
                <div class="registerbox-submit">
                    <?=Html::submitButton('注册', ['class' => 'btn btn-primary pull-right'])?>
                </div>
            <?php ActiveForm::end();?>

        </div>
    </div>
<?php $this->endBody()?>
</body>
<?php $this->endPage()?>