<?php
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = '新增包裹';
$this->params['active_menu'] = 'new_parcel';
$this->params['header_titles'] = ['首页', '新增包裹'];

$css = <<<EOF
.success-info{text-align: center;padding: 45px;}
.success-info h6{font-size: 34px; color: #333333;}
.success-info h6 .ui-icons-circle-solid-tick{font-size: 40px; color: #8dc519;}
.parcel-info strong{color: #333333; font-weight: bold;}
.step-btn-wrap {
    text-align: center;
    padding: 50px 0 100px;
}
.next {
    background-color: #019fe8;
    color: #ffffff;
    border-radius: 2px;
}
.buttn {
    display: inline-block;
    font-size: 20px;
    height: 45px;
    line-height: 45px;
    padding: 0 33px;
    cursor: pointer;
}
a:hover{color:#ffffff;text-decoration:none;}
EOF;
$this->registerCss($css)
?>
<div class="row">
<div class="col-lg-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="success-info">
            <?php if($parcel_id){ ?>
            <h6>
                <span  class="ui-icon glyphicon glyphicon-ok-sign middle" style="color: #a0d468""></span>
                <span class="middle">恭喜您~包裹<span id="parcel-state">编辑</span>成功~</span>
            </h6>
            <p id="tip-text">您的包裹到达仓库后需支付转运费，请持续关注包裹动态。</p>
            <?php }else{ ?>
                <h6>
                    <span  class="ui-icon glyphicon  glyphicon-info-sign middle" style="color:red"></span>
                    <span class="middle">sorry~包裹<span id="parcel-state">编辑</span>失败~</span>
                </h6>
            <?php } ?>
        </div>
        <p class="step-btn-wrap">
            <?php if($parcel_id){ ?>
            <a href="/parcel/list" class="buttn next" id="viewParcel">查看包裹</a>
            <?php }else{ ?>
            <a href="/parcel/add" class="buttn next" id="addParcel" style="">继续新增</a>
            <?php } ?>
        </p>

    </div>
</div>
</div>

