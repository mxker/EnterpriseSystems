<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\assets;

$this->title = '个人中心';
$this->params['active_menu'] = 'personal';
$this->params['header_titles'] = ['首页', '个人中心'];

$css = <<<EOF
    .row-title{
        margin-top: 0px !important;
        margin-left: -12px !important;
    }
EOF;
$this->registerCss($css);
?>
    <div class="profile-container">
        <div class="profile-header row">
            <div class="col-lg-2 col-md-4 col-sm-12 text-center">
                <img src="/img/avatars/avatar.jpg" alt="" class="header-avatar">
            </div>
            <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
                <div class="header-fullname"><?php echo $memberInfo['username']?></div>
                <a href="#" class="btn btn-palegreen btn-sm  btn-follow">
                    <i class="fa fa-check"></i>
                    已认证
                </a>
                <div class="header-information">
                    可用余额：<?php echo '<span style="color: red; font-size: 20px;">'.$memberInfo['available_predeposits'].'</span>元'?><br/>
                    冻结金额：<?php echo '<span style="color: red">'.$memberInfo['freeze_predeposits'].'</span>元'?>
                </div>
            </div>
        </div>
        <div class="profile-body">
            <div class="col-lg-12">
                <div class="tabbable">
                    <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
                        <li class="active">
                            <a data-toggle="tab" href="#overview">
                                基本信息
                            </a>
                        </li>
                        <li class="tab-yellow">
                            <a data-toggle="tab" href="#settings">
                                修改信息
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content tabs-flat">
                        <div id="overview" class="tab-pane active">
                            <form role="form">
                                <div class="form-title">
                                    <h5 class="row-title before-themeprimary">个人信息</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="姓名：<?php echo $memberInfo['username']?>">
                                                    <i class="fa fa-user blue"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="邮箱：<?php echo $memberInfo['email']?>">
                                                    <i class="fa fa-flickr blue"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="手机号码：<?php echo $memberInfo['mob_phone']?>">
                                                    <i class="glyphicon glyphicon-phone palegreen"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="所在地：中华人民共和国">
                                                    <i class="fa fa-globe"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-title">
                                    <h5 class="row-title before-themeprimary">证件信息</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="证件号码：510824199909099999">
                                                </span>
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="row">-->
<!--                                    <div class="col-sm-5">-->
<!--                                        <div class="form-group">-->
<!--                                                <span class="input-icon icon-right">-->
<!--                                                    <i style="color:grey;">证件照正面：</i>-->
<!--                                                    <img src="http://www.picture.com\uploads\img\201611\22\5833e4eef044a7.40644527.jpg" style="width: 200px; height: 120px; margin-right: 80px;">-->
<!--                                                    <i style="color:grey;">证件照背面：</i>-->
<!--                                                    <img src="http://www.picture.com\uploads\img\201611\22\5833e35cedf467.52479337.jpg" style="width: 200px; height: 120px;">-->
<!--                                                </span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </form>
<!--                                <span>-->
<!--                                    温馨提示：<br/>-->
<!--                                    1. 请在此处上传证件信息以完善会员信息，请上传证件的正面、反面各一张，并保持证件图像清晰，号码可识别。每张图片小于2M。隐私声明<br/>-->
<!--                                    2. 如您选择的产品线路在清关环节需要使用证件，请前往收货地址管理处上传。<br/>-->
<!--                                </span>-->
                        </div>
                        <div id="settings" class="tab-pane">
                            <?php $form = ActiveForm::begin([
                                'id' => 'edit-info',
                                'action' => ['personal/edit'],
                                'method' => 'post',
                            ]);?>
                            <div class="form-title">
                                <h5 class="row-title before-themeprimary">个人信息</h5>
                            </div>

                                <?= $form->field($model, 'username')->textInput(['value' => $memberInfo['username']])?>

                                <?= $form->field($model, 'email')->textInput(['value' => $memberInfo['email']])?>

                                <?= $form->field($model, 'mob_phone')->textInput(['value' => $memberInfo['mob_phone']])?>

                            <div class="form-group">
                                <?= Html::submitButton('保存以上信息', ['class' => 'btn btn-primary']) ?>
                            </div>
                            <?php ActiveForm::end()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>