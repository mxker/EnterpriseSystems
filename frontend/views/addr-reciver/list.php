<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
use common\widgets\upload\FileUpload;

\common\assets\DataTablesMinJs::register($this);

$this->title = '发货地址列表';
$this->params['active_menu'] = 'addr_reciver';
$this->params['header_titles'] = ['发货地址', '列表'];

$css = <<<EOF
    .widget input[type=checkbox]{
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
//    .img-box1,.img-box2{
//        width:180px;
//        height:150px;
//    }
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
    .table{
        margin-top:16px;
    }
    .widget-header{
        text-align:left;
    }
EOF;
$this->registerCss($css);
//写入js
$js = <<<EOF
jQuery(function($){
    //获取城市信息
    $("#province").change(function(){
        var province_id = $('#province option:selected').val();
        var csrfToken = $('input[name="_csrf"]').val();
        console.log(csrfToken);
        get_city(province_id,csrfToken);
    });
    //获取三级城市信息
    $("#city").change(function(){
        var csrfToken = $('input[name="_csrf"]').val();
        var city_id = $('#city option:selected').val();
        get_area(city_id,csrfToken);

        console.log(city_id);
        if(city_id){
            var code = "<?$";
            code += "\<?=+'+ \$'+\"form->field(\$model, 'city_id')->hiddenInput(['value'=>+\"city_id\"+]) ?>";
            $('.widget-body').attr(code);
        }
    });

    function get_city(area_id, token){
        $.ajax({
            url:'/addr-reciver/arealist',
            type:"post",
            data:{'province_id':area_id,'_csrf':token},
            dataType:"json",
            success:function(result){
                var length = result.length;
                var html = '<option value=""' +'">' + '请选择' + '</option>';
                for (var i=0; i<length; i++){
                    html += '<option value="' + result[i].area_id + '" data-area-name="' + result[i].area_name + '">' + result[i].area_name + '</option>';
                }
                $("#city").html(html);
            },
        });
    }

    function get_area(area_id, token){
        $.ajax({
            url:'/addr-reciver/arealist',
            type:"post",
            data:{'province_id':area_id,'_csrf':token},
            dataType:"json",
            success:function(result){
                var length = result.length;
                var html = '<option value=""' +'">' + '请选择' + '</option>';
                for (var i=0; i<length; i++){
                    html += '<option value="' + result[i].area_id + '" data-area-name="' + result[i].area_name + '">' + result[i].area_name + '</option>';
                }
                $("#area").html(html);
            },
        });
    }

    //删除发货地址
    $('.removeInfo').click(function(){
        var ar_id = $(this).attr('catalogid');
        var csrfToken = $('input[name="_csrf"]').val();
        if(confirm('确认删除？')){
            removeInfo(ar_id, csrfToken);
            return;
        }
    });

    function removeInfo(ar_id, csrfToken){
        $.ajax({
            url:'/addr-reciver/delete',
            type:"post",
            data:{'ar_id':ar_id,'_csrf':csrfToken},
            dataType:'json',
            success:function(result){
                return;
            }
        });
    }

    //默认地址点击事件
    $('#is_default').click(function(){
        if($(".isdefault").attr("checked")){
            $('.isdefault').attr('checked',false);
            $('.isdefault').attr('value','0');
        }else{
            $('.isdefault').attr('checked',true);
            $('.isdefault').attr('value','1');
        }
    });

    //修改默认地址
    $('.default').click(function(){
        var ar_id = $(this).attr('catalogid');
        var csrfToken = $('input[name="_csrf"]').val();
        console.log(csrfToken);
        defaultAddr(ar_id,csrfToken);
    });

    function defaultAddr(ar_id,csrfToken){
        $.ajax({
            url:'/addr-reciver/default',
            type:"post",
            data:{'ar_id':ar_id,'_csrf':csrfToken},
            dataType:'json',
            success:function(result){
                return;
            }
        });
    }

})
EOF;
$this->registerJs($js,$this::POS_END);
?>
<div class="well with-header with-footer">
    <div class="header bordered-pink">
        <h5 class="row-title before-themeprimary" >已有收货地址</h5>
        <a href="#add-adr" class="btn btn-primary add-channel" style="float: right">新增收货地址</a>
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>
                <i class="fa fa-user"></i>收件人
            </th>
            <th class="hidden-xs">
                <i class="fa fa-flag-checkered"></i> 所在地区
            </th>
            <th>
                <i class="fa fa-flag-checkered"></i> 街道地址
            </th>
            <th>
                <i class="fa  fa-envelope"></i> 邮编
            </th>
            <th>
                <i class="fa fa-mobile"></i> 电话/手机
            </th>
            <th>
                <i class="fa fa-mobile"></i> 证件号码
            </th>
            <th width="20%">
                <i class="fa fa-gear"></i> 操作
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if($reciverList){
            foreach($reciverList as $k => $v){?>
                <tr>
                    <td>
                        <?php echo $v['true_name']?>
                    </td>
                    <td>
                        <?php echo $v['area_info']?>
                    </td>
                    <td class="hidden-xs">
                        <?php echo $v['adress']?>
                    </td>
                    <td>
                        <?php echo $v['postcode']?>
                    </td>
                    <td>
                        <?php echo $v['mob_phone']?>
                    </td>
                    <td>
                        <?php echo $v['idcard_number']?>
                    </td>
                    <td>
                        <?php if($v['is_default'] == 0){?>
                        <a href="javascript:;" catalogId = '<?php echo $v['ar_id']?>' class="btn btn-default btn-xs black default"><i class="fa fa-lock"></i>设为默认</a>
                        <?php }?>
                        <a id="editInfo" href="edit?arid=<?php echo $v['ar_id']?>" catalogId = '<?php echo $v['ar_id']?>' class="btn btn-default btn-xs purple"><i class="fa fa-edit"></i> 修改</a>
                        <a href="javascript:;" catalogId = '<?php echo $v['ar_id']?>' class="btn btn-default btn-xs red removeInfo"><i class="fa fa-trash-o"></i> 删除</a>
                    </td>
                </tr>
            <?php }}else{?>
                <tr><td colspan="7" align="center"><h3>暂时还没有收货地址哟~！</h3></td></tr>
        <?php }?>
        </tbody>
    </table>
    <div class="page" id="pages">
    <?= LinkPager::widget([
        'pagination' => $pages,
        'firstPageLabel' => '首页',
        'nextPageLabel' => '下一页',
        'prevPageLabel' => '上一页',
        'lastPageLabel' => '尾页',
    ]); ?>
    </div>
</div>

<!--普通表单提交-->
<div class="widget  radius-bordered">
    <div class="widget-header">
        <h5 class="row-title before-themeprimary" id="add-adr">新增收货地址</h5>
    </div>
    <div class="widget-body">
        <form id="togglingForm" class="form-horizontal bv-form" method="post" action="addform">

            <?php $form = \yii\bootstrap\ActiveForm::begin([
                'method' => 'post',
                'action' => ['addr-reciver/addform'],
            ])?>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">所在地区 <sup>*</sup></label>
                <div class="col-lg-4">
                    <select id="province" name = "prov_id">
                        <option value="" selected="selected">请选择</option>
                        <?php if($provinceList){foreach($provinceList as $key => $value){?>
                            <option value="<?php echo $value['area_id']?>"><?php echo $value['area_name']?></option>
                        <?php }}?>
                    </select>
                    <select id="city" name = 'city_id'>
                        <option>请选择</option>
                    </select>
                    <select id="area" name = 'area_id'>
                        <option>请选择</option>
                    </select>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">详细地址 <sup>*</sup></label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="address" required=""  placeholder="建议您如实填写详细收货地址，例如街道名称，门牌号码等信息">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">邮政编码 <sup>*</sup></label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="postcode" required=""  placeholder="为保证包裹派送时效，请准确填写邮编">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">收货人姓名 <sup>*</sup></label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="true_name" required=""  placeholder="收货人姓名请务必与证件保持一致">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">手机号码 <sup>*</sup></label>
<!--                <div class="col-lg-1">-->
<!--                    <select class="mob" name = 'mob'>-->
<!--                        <option>选择国际区号</option>-->
<!--                        <option>0086</option>-->
<!--                        <option>0061</option>-->
<!--                    </select>-->
<!--                </div>-->
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="mob_phone" required=""  placeholder="请输入手机号码，国际格式：如+86">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">证件号码 <sup>*</sup></label>
<!--                <div class="col-lg-2">-->
<!--                    <select name="id_type">-->
<!--                        <option>身份证</option>-->
<!--                        <option>护照</option>-->
<!--                        <option>港澳台居民来往大陆/内地通行证</option>-->
<!--                    </select>-->
<!--                </div>-->
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="idcard_number" required=""  placeholder="请正确输入身份证号码">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">证件照片 <sup>*</sup></label>
                <div class="col-lg-2">
                    <input type="hidden" name="front" alt="正面" id="img-box-hidden1">
                    <div class="img-box upload-img" style="width: 150px; height: 100px;">
                        <img src="" style="width: 150px; height: 100px; position: absolute" class="img-box1">
                    <?=Html::csrfMetaTags()?>
                    <?=FileUpload::widget([
                        'model' => $model,
                        'attribute' => 'file',
                        'url' => ['addr-reciver/uploadImg'],
                        'buttonClass' => 'upload',
                        'options' => [
                            'accept' => 'image/*',
                            'class' => 'abc',
                            'id' => 'upload-img-1',
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
                                        var pic = JSON.parse(data.result).files[0];
                                        $(".img-box1").attr("src",pic.thumbnailUrl);
                                        $("#img-box-hidden1").val(pic.url);
                                    }
                                }',
                        ],
                    ]);?>
                        <span style="margin-left: 60px; color: red;">正面</span>
                    </div>

                </div>
                <div class="col-lg-2">
                    <input type="hidden" name="back" alt="背面" id="img-box-hidden2">
                    <div class="img-box upload-img" style="width: 150px; height: 100px;">
                        <img src="" style="width: 150px; height: 100px; position: absolute" class="img-box2">
                    <?=FileUpload::widget([
                        'model' => $model,
                        'attribute' => 'file',
                        'url' => ['addr-reciver/uploadImg'],
                        'buttonClass' => 'upload',
                        'options' => [
                            'accept' => 'image/*',
                            'class' => 'abc',
                            'id' => 'upload-img-2',
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
                                        $(".img-box2").attr("src",pics.thumbnailUrl);
                                        $("#img-box-hidden2").val(pics.url);
                                    }
                                }',
                        ],
                    ]);?>
                        <span style="margin-left: 60px; color: red;">背面</span>
                    </div>
                </div>
            </div>

            <hr class="wide">

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label"></label>
                <div class="col-lg-2" id="is_default">
                    <input type="checkbox" class="colored-danger isdefault" name="is_default" value="0">
                    设为默认地址
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-4">
                    <?= \yii\helpers\Html::submitButton('保存收货地址', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
                </div>
            </div>
            <?php  \yii\bootstrap\ActiveForm::end()?>
        </form>
    </div>
</div>