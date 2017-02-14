<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use backend\assets\PortalAsset;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;

PortalAsset::register($this);
?>
<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white">
        <div class="loginbox-title">EDU管理后台</div>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
            'template' => '<div class="loginbox-textbox">{input}<div class="my-error-tips col-lg-8">{error}</div></div>'
            ],
            ]);?>

        <?=$form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')])?>

        <?=$form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])?>

        <?=$form->field($model, 'verifyCode')->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6 col-sm-6 col-xs-6 padding-right-10">{input}</div></div>',
                'options' => ['placeholder' => $model->getAttributeLabel('verifyCode'), 'class' => 'form-control', 'autocomplete' => 'off']
                ])?>

        <?=$form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class='loginbox-textbox'><label>{input} <span class='text'>" . $model->getAttributeLabel('rememberMe') . "</span></label></div>",
                ])?>
            <div class="loginbox-submit">
                    <?=Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button'])?>
        </div>

        <?php ActiveForm::end();?>
    </div>
</div>