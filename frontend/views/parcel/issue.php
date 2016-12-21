<?php
use yii\widgets\LinkPager;
use common\assets\DataTablesAsset;

DataTablesAsset::register($this);
/* @var $this yii\web\View */
$this->title = '我的包裹';
$this->params['active_menu'] = 'issue_parcel';
$this->params['header_titles'] = ['首页', '问题包裹'];
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
EOF;
$this->registerCss($css);
$this->registerJsFile('/js/areaselect/area-select.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_END]);
$js = <<<EOF
$(function(){
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
});
EOF;
$this->registerJs($js, $this::POS_END);

?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <div class="tab-content">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget flat">
                            <div class="widget-header">

                                <span class="widget-caption">
                                      <form id="searchParcel" method="get">
                                          <div>
                                    <span class="input-icon icon-right inverted">
                                       <!-- <input type="hidden" name="page" value="<?/*=Yii::$app->request->get('page')*/?>" class="form-control">
                                        <input type="hidden" name="per-page" value="<?/*=Yii::$app->request->get('per-page')*/?>" class="form-control">
                                       --> <input type="text" name="tracking_code_moyun" placeholder="陌云运单号" class="form-control">
                                        <i class="glyphicon glyphicon-search bg-darkorange" style="cursor:pointer"></i>
                                    </span>
                                          </div>
                                      </form>
                                </span>

                                <!--Widget Buttons-->
                            </div>
                            <!--Widget Header-->
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="widget">
                                            <div class="widget-body">
                                                <div role="grid" id="editabledatatable_wrapper"
                                                     class="dataTables_wrapper form-inline no-footer">
                                                    <table class="table table-striped table-hover table-bordered"
                                                           id="editabledatatable">
                                                        <thead>
                                                        <tr role="row">
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
                                                            <th>
                                                                问题描述
                                                            </th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <?php if($list){ foreach($list as $l){ ?>
                                                            <tr>
                                                                <td><?=$l['tracking_code_moyun']?></td>
                                                                <!--<td>alex</td>
                                                                <td>alex</td>
                                                                <td>Alex Nilson</td>-->
                                                                <td><?=$l['name']?></td>
                                                                <td class="center "><?=$l['lname']?></td>
                                                                <td class="center "><?php echo date('Y-m-d H:i',$l['issue_at']);?></td>
                                                                <td>
                                                                    <?=$l['issue_remark']?>
                                                               </td>
                                                            </tr>
                                                        <?php }} ?>

                                                        </tbody>
                                                    </table>
                                                    <div class=" DTTTFooter">
                                                        <div class="col-sm-3">
                                                            <div class="dataTables_info" id="editabledatatable_info"
                                                                 role="alert" aria-live="polite"
                                                                 aria-relevant="all"></div>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <div class="dataTables_paginate paging_bootstrap"
                                                                 id="editabledatatable_paginate"><?=
                                                                LinkPager::widget([
                                                                    'pagination' => $pages,
                                                                    'nextPageLabel' => '下一页',
                                                                    'prevPageLabel' => '上一页',
                                                                    'firstPageLabel' => '首页',
                                                                    'lastPageLabel' => '尾页',
                                                                    'hideOnSinglePage' => false,
                                                                    'maxButtonCount' => 5,
                                                                ]);
                                                                ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Widget Body-->
                </div>
                <!--Widget-->
            </div>
        </div>
    </div>
</div>
<div class="horizontal-space"></div>
<div class="ui-widget-overlay ui-front" style="z-index: 10001;position: fixed;display: none;"></div>
</div>

</div>
</div>
