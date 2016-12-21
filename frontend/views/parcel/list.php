<?php
use yii\widgets\LinkPager;
use common\assets\DataTablesAsset;
use yii\helpers\Html;
DataTablesAsset::register($this);
\common\assets\DatePicker::register($this);
/* @var $this yii\web\View */
$this->title = '我的包裹';
$this->params['active_menu'] = 'my_parcel';
$this->params['header_titles'] = ['首页', '我的包裹'];
//$this->registerCssFile('/css/dataTables.bootstrap.css',['depends' => ['common\assets\CommonAsset'], 'position' => $this::POS_END]);
$css = <<<EOF
.batch-add {
    margin: 10px 30px;
    border: 1px solid #FFF;
    font-size: 12px;
    padding-bottom: 20px;
}
.batch-add dl {
    margin: 5px 0;
}
.batch-add dt {
    float: left;
    width: 130px;
    height: 35px;
    line-height: 35px;
    white-space: nowrap;
}
.batch-add label {
    display: inline-block;
    width: 120px;
    text-align: right;
}
label {
    cursor: pointer;
}
.batch-add dd {
    margin-left: 130px;
}
.batch-add #fileUpload {
margin-top:8px;
    float: left;
    width: 230px;
    border: 1px solid #eee;
    vertical-align: middle;
    margin-right: 10px;
}

.batch-add .btn-1 {
    float: left;
    width: 121px;
    text-align: center;
    height: 35px;
    line-height: 35px;
    font-size: 18px;
    border: 0;
    padding: 0;
}

.batch-add .upload-text {
    padding-top: 8px;
}

input, textarea {
    outline: none;
}
ul, ol ,li{
    list-style: none;
}
.tab-title {
    margin: 10px 0 0 10px;
}
.tab-title {
    zoom: 1;
}
.tab-title {
    color: #676767;
}
    .tab-title li {
     float: left;
     height: 32px;
     line-height: 32px;
     cursor: pointer;
     position: relative;
     font-size: 14px;
     margin: 0 8px;
     border-bottom: 1px solid #fff;
     white-space: nowrap;
}
.modal-body{
padding:0px;
}
.modal-preview .modal {
    max-width: 700px;
}
.btn-1, .dialog-ok {
    color: #fff !important;
    background-color: #019fe8;
}
.ui-widget-overlay {
    /* position: fixed; */
    _position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #8f8f8f;
    opacity: 0.5;
    filter: alpha(opacity=50);
}

.widget-caption{
    width:200px;
}
.for-search{
    float:left;
}
EOF;
$this->registerCss($css);
$this->registerJsFile('/js/areaselect/area-select.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_END]);
$js = <<<EOF
$(function(){
    var lc_id;
    $(".batch_add").on("click",function() {
        $(".modal-preview").show();
        $(".ui-widget-overlay").show();
    });
    $(".close").on("click",function() {
        $(".modal-preview").hide();
        $(".ui-widget-overlay").hide();
    });
    $(".glyphicon-search1").on("click",function(){
        $("#searchParcel").submit();
    });
    $("input[name='parcel_id[]']").on("click",function(){
        if(lc_id){
            if($("input[name='parcel_id[]']:checked").length==0){
                lc_id = '';
            }else{
                if(lc_id!=$(this).attr('data-channel-id')){
                    alert('请选择同一渠道面单进行批量下载或导出！')
                    return false;
                }
            }
        }else{
            lc_id = $(this).attr('data-channel-id');
        }
    });

    //--Bootstrap Date Picker--
    $('.date-picker').datepicker();


$('#export_excel').on('click',function(){
    document.forms.dwpdf.action="export_excel";
    document.forms.dwpdf.submit();
})
$('#face_paper').on('click',function(){
    document.forms.dwpdf.action="dwpdf";
    document.forms.dwpdf.submit();
})
$('.dwpdfb').on('click',function(){
    var ib_id =$(this).attr('ib_id');
    var self=$(this);
    $.ajax({
       url: '/parcel/changeibst',
       type: 'post',
       data: {'ib_id':ib_id},
       dataType:'json',
       async : false,
       success: function (data) {
          if(data.code==200){
            self.find('.msg').text('已下载');
            return true;
          }else{
            return false;
          }
       }
    });
   return true;

})


});
EOF;
$this->registerJs($js, $this::POS_END);

?>
<div class="row">
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success fade in">
        <button class="close" data-dismiss="alert">
            ×
        </button>
        <i class="fa-fw fa fa-check"></i>
        <strong><?php echo Yii::$app->session->getFlash('success') ?></strong>
    </div>
<?php elseif(Yii::$app->session->hasFlash('error')): ?>
<div class="alert alert-danger fade in">
    <button class="close" data-dismiss="alert">
        ×
    </button>
    <i class="fa-fw fa fa-times"></i>
    <strong><?php echo Yii::$app->session->getFlash('error') ?></strong>
</div>
<?php endif ?>

    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li <?php if($state===0){ ?>class="active"<?php }?>>
                <a href="/parcel/list">
                    全部运单
                </a>
            </li>
            <li <?php if($shipping_status==10){ ?>class="active"<?php }?>>
                <a href="/parcel/list?shipping_status=10">
                    待入库
                </a>
            </li>
            <li <?php if($shipping_status==20){ ?>class="active"<?php }?>>
                <a  href="/parcel/list?shipping_status=20">
                    已入库
                </a>
            </li>
            <li <?php if($shipping_status==30){ ?>class="active"<?php }?>>
                <a  href="/parcel/list?shipping_status=30">
                    已出库
                </a>
            </li>
            <li <?php if($parcel_status==10){ ?>class="active"<?php }?>>
                <a href="/parcel/list?parcel_status=10">
                    待付款
                </a>
            </li>
            <li <?php if($parcel_status==20){ ?>class="active"<?php }?>>
                <a href="/parcel/list?parcel_status=20">
                    已付款
                </a>
            </li>
            <li <?php if($shipping_status==40){ ?>class="active"<?php }?>>
                <a href="/parcel/list?shipping_status=40">
                    已签收
                </a>
            </li>
            <li <?php if($shipping_status==70){ ?>class="active"<?php }?>>
                <a href="/parcel/list?shipping_status=70">
                    批量记录
                </a>
            </li>
        </ul>

            <div class="tab-content">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget flat">
                            <div class="widget-header">

                                <form id="searchParcel" method="get">
                                    <div class="for-search">
                                        <input type="hidden" name="shipping_status" value="<?=$shipping_status?>">
                                        <?php if($shipping_status<70){ ?>
                                        <span class="input-icon icon-right inverted widget-caption">
                                           <!-- <input type="hidden" name="page" value="<?/*=Yii::$app->request->get('page')*/?>" class="form-control">
                                            <input type="hidden" name="per-page" value="<?/*=Yii::$app->request->get('per-page')*/?>" class="form-control">
                                            --><input type="text" name="tracking_code_moyun" placeholder="陌云运单号" class="form-control">
                                            <i class="fa fa-truck"></i>
                                        </span>
                                        <?php }?>
                                        <span class="input-icon icon-right inverted widget-caption">
                                            <input class="form-control date-picker" id="id-date-picker-1" name="start_time" type="text" data-date-format="dd-mm-yyyy" placeholder="开始时间">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <span class="input-icon icon-right inverted widget-caption">
                                            <input class="form-control date-picker" id="id-date-picker-1" name="end_time" type="text" data-date-format="dd-mm-yyyy" placeholder="结束时间">
                                            <i class="fa fa-calendar"></i>
                                        </span>

                                    </div>
                                    <div class="widget-buttons" style="float: left;height: 34px;margin-top: 3px;">
                                        <div class="buttons-preview">
                                            <a class="btn btn-orange glyphicon-search1" style="34px;" href="javascript:void(0);">搜索 <i class="glyphicon glyphicon-search left"></i></a>
                                        </div>
                                    </div>
                                </form>

                                <div class="widget-buttons">
                                    <div class="buttons-preview">
                                        <a style="margin-top: 2px;margin-right: 10px;" class="purple batch_add" href="javascript:void(0);">批量新增</a>
                                        <a href="./add" style="margin-top: 2px" class="btn btn-default purple" href="javascript:void(0);"><i class="fa fa-plus"></i>新增包裹</a>
                                    </div>
                                </div><!--Widget Buttons-->
                            </div><!--Widget Header-->
                            <div class="widget-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <div class="widget">
                                        <div class="widget-body" style="position: relative">
                                            <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                                            <table class="table table-striped table-hover table-bordered" id="editabledatatable">
                                                <?php if($shipping_status<70){ ?>
                                                <thead>
                                                <tr role="row">
                                                    <th>

                                                    </th>
                                                    <th>
                                                        陌云运单号
                                                    </th>
                                                    <!--<th>
                                                        包裹总量
                                                    </th>
                                                    <th>
                                                        申报总价
                                                    </th>
                                                    <th>
                                                        费用
                                                    </th>-->
                                                    <th>
                                                        出发仓库
                                                    </th>
                                                    <th>
                                                        转运渠道
                                                    </th>
                                                    <th>
                                                        添加时间
                                                    </th>
                                                    <th width="300px">
                                                        操作
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <form action="dwpdf" id="dwpdf" method="post">
                                                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                                    <?php if($list){ foreach($list as $l){ ?>
                                                    <tr>
                                                        <td><label>
                                                                <input data-channel-id="<?=$l['logisticsChannel']['lc_id']?>" type="checkbox" name="parcel_id[]" value="<?=$l['parcel_id']?>" >
                                                                <span class="text"></span>
                                                            </label></td>
                                                        <td><?=$l['tracking_code_moyun']?></td>
                                                        <!--<td>alex</td>
                                                        <td>alex</td>
                                                        <td>Alex Nilson</td>-->
                                                        <td><?=$l['name']?></td>
                                                        <td class="center "><?=$l['lname']?></td>
                                                        <td class="center "><?php echo date('Y-m-d H:i',$l['ptime']);?></td>
                                                        <td>
                                                            <a href="detail?id=<?=$l['parcel_id']?>" class="btn btn-default btn-xs edit"><i class="fa fa-info"></i> 详情</a>
                                                            <a href="dwpdf?parcel_id[]=<?=$l['parcel_id']?>" class="btn btn-default btn-xs edit"><i class="fa fa-file-text-o"></i> 下载面单</a>
                                                            <?php if($l['shipping_status']<20){ ?>
                                                            <a href="add?id=<?=$l['parcel_id']?>" class="btn btn-default btn-xs edit"><i class="fa fa-edit"></i> 编辑</a>
                                                            <?php } ?>
                                                        <?php if($l['shipping_status']<20){ ?>
                                                            <a onclick="if(confirm('确定删除?')==false)return false;" href="del?id=<?=$l['parcel_id']?>" class="btn btn-default btn-xs delete"><i class="fa fa-trash-o"></i> 删除</a>
                                                        <?php } ?>
                                                            </td>
                                                    </tr>
                                                    <?php }} ?>
                                                </tbody>
                                                <?php }else{ ?>
                                                    <thead>
                                                    <tr role="row">
                                                        <th>
                                                            批量id
                                                        </th>
                                                        <th>
                                                            上传时间
                                                        </th>
                                                        <th>
                                                            数量
                                                        </th>
                                                        <th>
                                                            处理结果
                                                        </th>
                                                        <th width="300px">
                                                            操作
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?=Html::csrfMetaTags()?>
                                                    <form action="dwpdf" id="dwpdf" method="post">
                                                        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                                        <?php if($list){ foreach($list as $l){ ?>
                                                            <tr>
                                                                <td><?=$l['ib_id']?></td>
                                                                <td><?=date('Y-m-d H:i:s',$l['create_at'])?></td>
                                                                <!--<td>alex</td>
                                                                <td>alex</td>
                                                                <td>Alex Nilson</td>-->
                                                                <td><?=$l['parcel_num']?></td>
                                                                <td class="center ">成功</td>
                                                                <td>
                                                                    <a href="export_excel?t=json&parcel_id=<?=$l['parcel_ids']?>" class="btn btn-default btn-xs edit"><i class="fa fa-file-text-o"></i> 下载成功信息单</a>
                                                                    <a href="dwpdf?t=json&parcel_id=<?=$l['parcel_ids']?>" ib_id="<?=$l['ib_id']?>" class="dwpdfb btn btn-default btn-xs edit"><i class="fa fa-file-text-o"></i> <span class="msg"><?php if($l['is_downpdf']==1){echo '已下载';}else{echo '下载面单'; }?></span></a>
                                                                </td>
                                                            </tr>
                                                        <?php }} ?>
                                                    </tbody>
                                                <?php }?>
                                            </table>

                                            <div class=" DTTTFooter"><div class="col-sm-3"><?php if($shipping_status<70){ ?><div class="dataTables_info" id="editabledatatable_info" role="alert" aria-live="polite" aria-relevant="all"><input type="button" id="face_paper" value="批量下载面单"> <input type="button" id="export_excel" value="导出excel"></div><?php }?></div><div class="col-sm-9"><div class="dataTables_paginate paging_bootstrap" id="editabledatatable_paginate"><?=
                                                        LinkPager::widget([
                                                            'pagination' => $pages,
                                                            'nextPageLabel' => '下一页',
                                                            'prevPageLabel' => '上一页',
                                                            'firstPageLabel' => '首页',
                                                            'lastPageLabel' => '尾页',
                                                            'hideOnSinglePage' => false,
                                                            'maxButtonCount' => 5,
                                                        ]);
                                                        ?></div></div></div>
                                                </form>
                                        </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div style="width:700px;position: absolute;top: 50px; z-index: 10002" class="col-lg-12 col-sm-12 col-xs-12">

                                        <div class="modal-preview" style="display: none; ">
                                            <div class="modal modal-darkorange">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title">批量新增包裹</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="batch-add" style="text-align: center" id="tabContent">
                                                                <li style="margin-right:40px; " class="download-link">
                                                                    <a href="<?=Yii::$app->params['upload_static_url']?>/transRushTpl/TransRushImport.xlsx" target="_blank">模板下载</a><span class="line">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href="<?=Yii::$app->params['upload_static_url']?>/transRushTpl/catTax.docx" target="_blank">完税价格商品</a>
                                                                </li>
                                                            </ul>
                                                            <form method="post" enctype="multipart/form-data" action="./import-parcel">
                                                            <div class="batch-add" id="batchAddHtml">
                                                                <dl class="clearfix">
                                                                    <dt><label for="">选择您要上传的文件：</label></dt>
                                                                    <dd>
                                                                        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                                                        <!-- <span class="select-batch-add">选择文件</span> --><input type="file" name="fileUpload" id="fileUpload" style="">
                                                                        <input type="submit" name="btnOk" value="确认上传"  id="btnOk" class="btn btn-1" style="">
                                                                    </dd>
                                                                </dl>
                                                                <dl class="clearfix">
                                                                    <dt><label for="">上传状态：</label></dt>
                                                                    <dd>
                                                                        <div class="upload-text">

                                                                            <div id="divStatus" style="text-align: left; margin-left: 5px;color:Red;">亲，请选择您要上传的文件，谢谢~</div>
                                                                            <div id="DivErrMsg" style="color:Red;"></div>
                                                                        </div>
                                                                    </dd>
                                                                </dl>
                                                                <!-- <div id="divCategorybody" style="background-color: White;">
                                                                    <div style="background-color: White; width: 100%; height: 30px; border-bottom: 2px solid #00bfff">

                                                                    </div>
                                                                    <table width="100%" cellspacing="0" id="BSmallList" style="width: 100%;font-size:12px;">
                                                                        <tr>
                                                                            <td width="30%" style="text-align: right;">
                                                                                选择你要上传的文件：
                                                                            </td>
                                                                            <td width="70%">
                                                                                <div style="text-align: left; margin-left: 5px;">

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="30%" style="text-align: right;">
                                                                                上传状态：
                                                                            </td>
                                                                            <td width="70%">

                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                </div> -->
                                                            </div>
                                                                </form>
                                                        </div>
                                                       <!-- <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-default">Ok</button>
                                                        </div>-->
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                    </div>
                                </div>
                            </div><!--Widget Body-->
                        </div><!--Widget-->
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
        <div class="ui-widget-overlay ui-front" style="z-index: 10001;position: fixed;display: none;"></div>
        </div>

    </div>
</div>
