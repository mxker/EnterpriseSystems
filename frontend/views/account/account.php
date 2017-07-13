<?php
/* @var $this yii\web\View */
use common\assets\BootBox;
use yii\widgets\LinkPager;

BootBox::register($this);

$this->title = '账户充值';
$this->params['active_menu'] = 'account';
$this->params['header_titles'] = ['首页', '账户充值'];
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
    #pages{
        float:right;
        margin-top: 10px;
    }
EOF;
$this->registerCss($css);
//写入js
$js = <<<EOF
$(function(){
//        $("#bootbox-options").on("click", function () {
//            bootbox.dialog({
//                message: $("#myModal").html(),
//                title: "充值中心",
//                className: "modal-darkorange",
//                buttons: {
//                    success: {
//                        label: "立即充值",
//                        className: "btn-blue",
//                        callback: function (data) {
//                           add_account();
//                        }
//                    },
//                    "取消": {
//                        className: "btn-danger",
//                        callback: function () { }
//                    }
//                }
//            });
//        });

        function add_account(){
            alert('');
//            $.ajax({
//                url:'/account/add',
//                type:"post",
//                data:{'province_id':area_id,'_csrf':token},
//                dataType:"json",
//                success:function(result){
//
//                },
//            })
        }

    $(".batch_add").on("click",function() {
        $(".modal-preview").show();
        $(".ui-widget-overlay").show();
    });
    $(".close").on("click",function() {
        $(".modal-preview").hide();
        $(".ui-widget-overlay").hide();
    });
    $(".glyphicon-search").on("click",function(){
        $("#searchParcel").submit();
    });

    $('.alipay').on("click",function(){
        $('.alipay').attr('checked','checked');
        $('.wxpay').removeAttr('checked','checked');
    });
    $('.wxpay').on("click",function(){
        $('.wxpay').attr('checked','checked');
        $('.alipay').removeAttr('checked');
    });
});
EOF;
$this->registerJs($js,$this::POS_END);
?>
<!-- Content -->
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="profile-container">
                <div class="profile-header row">
                    <div class="col-lg-5 col-md-8 col-sm-12 profile-info" style="margin-left: 100px;">
                        <div class="header-fullname">
                            <span>
                                账户余额：0.00元
                            </span>
                            <button style="margin-left: 500px;" class="btn btn-darkorange batch_add" id="bootbox-options">充值</button>
                        </div>
                        <div class="header-information">
                            提示：<br/>
                            1.系统只显示两年内消费记录，如果有需要，可截图或其他方式自行保存；<br/>
                            2.转运四方的优惠券金额及折扣优惠显示在金额里，不显示在账户收支明细中。
                        </div>
                    </div>
                </div>
                <div class="profile-body">
                    <div class="col-lg-12">
                        <div class="tabbable">
                            <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
                                <li class="active">
                                    <a data-toggle="tab" href="#last-record">
                                        近三个月的收支明细
                                    </a>
                                </li>
                                <li class="tab-red">
                                    <a data-toggle="tab" href="#befor-record">
                                        三个月之前的收支明细
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content tabs-flat">
<!--                                最近三个月的充值记录-->
                                <div id="last-record" class="tab-pane active" style="margin-bottom: 50px;">
                                        <table class="table table-stripe  table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th width="20%">
                                                    <i class="fa fa-calendar"></i>交易时间
                                                </th>
                                                <th width="20%">
                                                    <i class="fa fa-sitemap"></i>消费类型
                                                </th>
                                                <th width="10%">
                                                    <i class="fa fa-money"></i> 收入
                                                </th>
                                                <th width="10%">
                                                    <i class="fa fa-money"></i> 支出
                                                </th>
                                                <th>
                                                    <i class="fa fa-pencil"></i> 备注（交易说明）
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($lastThreeList){
                                                foreach($lastThreeList as $k => $v){?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $v['time']?>
                                                        </td>
                                                        <td>
                                                            <?php echo $v['pl_type']?>
                                                        </td>
                                                        <td>
                                                            <?php echo $v['av_amount']?>
                                                        </td>
                                                        <td>
                                                            <?php echo $v['freeze_amount']?>
                                                        </td>
                                                        <td>
                                                            <?php echo $v['remark']?>
                                                        </td>
                                                    </tr>
                                            <?php }}else{?>
                                                <tr><td colspan="5" align="center"><h3>亲，抱歉，您暂时还没有充值消费记录哟~！</h3></td></tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    <div class="page" id="pages">
                                        <?= LinkPager::widget([
                                            'pagination' => $lastPages,
                                            'firstPageLabel' => '首页',
                                            'nextPageLabel' => '下一页',
                                            'prevPageLabel' => '上一页',
                                            'lastPageLabel' => '尾页',
                                        ]); ?>
                                    </div>
                                </div>
<!--                                三个月之前的充值记录-->
                                <div id="befor-record" class="tab-pane" style="margin-bottom: 50px;">
                                    <table class="table table-stripe  table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="20%">
                                                <i class="fa fa-calendar"></i>交易时间
                                            </th>
                                            <th width="20%">
                                                <i class="fa fa-sitemap"></i>消费类型
                                            </th>
                                            <th width="10%">
                                                <i class="fa fa-money"></i> 收入
                                            </th>
                                            <th width="10%">
                                                <i class="fa fa-money"></i> 支出
                                            </th>
                                            <th>
                                                <i class="fa fa-pencil"></i> 备注（交易说明）
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($beforeThreeList){?>
                                        <?php foreach($beforeThreeList as $k => $v){?>
                                            <tr>
                                                <td>
                                                    <?php echo $v['time']?>
                                                </td>
                                                <td>
                                                    <?php echo $v['pl_type']?>
                                                </td>
                                                <td>
                                                    <?php echo $v['av_amount']?>
                                                </td>
                                                <td>
                                                    <?php echo $v['freeze_amount']?>
                                                </td>
                                                <td>
                                                    <?php echo $v['remark']?>
                                                </td>
                                            </tr>
                                        <?php }}else{?>
                                            <tr><td colspan="5" align="center"><h3>亲，抱歉，您暂时还没有充值消费记录哟~！</h3></td></tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                    <div class="page" id="pages">
                                        <?= LinkPager::widget([
                                            'pagination' => $beforPages,
                                            'firstPageLabel' => '首页',
                                            'nextPageLabel' => '下一页',
                                            'prevPageLabel' => '上一页',
                                            'lastPageLabel' => '尾页',
                                        ]); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" enctype="multipart/form-data" action="add">
    <div id="myModal" style="display:none;">
        <div class="row" style="text-align: center;margin-top: 20px;margin-bottom: 20px;">
            充值金额：<input type="number" class="money">
        </div>
    </div>
    </form>

    <div style="width:700px;margin-left: 20%;position: absolute;margin-top: -400px; z-index: 10002" class="col-lg-12 col-sm-12 col-xs-12">
        <div class="modal-preview" style="display: none; ">
            <div class="modal modal-darkorange">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">充值中心</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="add">
                                <?php $form = \yii\bootstrap\ActiveForm::begin([
                                    'method' => 'post',
                                    'action' => ['account/add'],
                                ])?>
                                <div class="batch-add" id="batchAddHtml" style="height: 150px;">
                                    <dl class="clearfix" style="margin-left: 130px;">
                                        <dt>
                                            <label for="">充值金额：</label>
                                            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                            <input type="number" name="money" id="money" style="">
                                        </dt>
                                    </dl>
                                    <div class="pay-type" style="margin-left: 130px; margin-top: 10px;">
                                        <div>
                                            <div>
                                                <label>
                                                    <input checked class="alipay" name="paytype" value="alipay" type="radio">
                                                    <span class="text">支付宝</span>
                                                </label>
                                                <label>
                                                    <input class="wxpay" name="paytype" value="wxpay" type="radio" class="inverted">
                                                    <span class="text">微信</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group" style="margin-top: 30px;">
                                        <div class="col-lg-8 col-lg-offset-4">
                                            <?= \yii\helpers\Html::submitButton('立即充值', ['class' => 'btn btn-primary']) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php  \yii\bootstrap\ActiveForm::end()?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div

</div>
<!-- End Content-->