<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Alert;
use common\widgets\upload\FileUpload;

\common\assets\DataTablesMinJs::register($this);

$this->title = '修改收货地址';
$this->params['active_menu'] = 'addr_reciver';
$this->params['header_titles'] = ['收货地址', '修改'];

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
    .photo{
        width:200px;
        height:150px;
    };
    .img-box1{
        width:180px;
        height:150px;
    }
    .img-box2, .img-box1{
        width:180px;
        height:150px;
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
    .widget-header{
        text-align:left;
    }
    .table{
        margin-top:16px;
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
})
EOF;
$this->registerJs($js,$this::POS_END);
?>
<!--普通表单提交-->
<div class="widget  radius-bordered">
    <div class="widget-header">
        <h5 class="row-title before-themeprimary" >修改收货地址</h5>
    </div>
    <div class="widget-body">
        <form id="togglingForm" class="form-horizontal bv-form" method="post" action="saveform">

            <?php $form = \yii\bootstrap\ActiveForm::begin([
                'method' => 'post',
                'action' => ['addr-reciver/saveform'],
            ])?>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">所在地区 <sup>*</sup></label>
                <div class="col-lg-4">
                    <select id="province" name = "prov_id">
                        <option value="<?php echo $reciverInfo['prov_id']?>" selected="selected"><?php echo $reciverInfo['prov']?></option>
                        <?php if($provinceList){foreach($provinceList as $key => $value){?>
                            <option value="<?php echo $value['area_id']?>"><?php echo $value['area_name']?></option>
                        <?php }}?>
                    </select>
                    <select id="city" name = 'city_id'>
                        <option value="<?php if($reciverInfo['city_id']){echo $reciverInfo['city_id'];}?>"><?php echo $reciverInfo['city']?></option>
                    </select>
                    <select id="area" name = 'area_id'>
                        <option value="<?php if($reciverInfo['area_id']){echo $reciverInfo['area_id'];}?>"><?php echo $reciverInfo['area']?></option>
                    </select>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">详细地址 <sup>*</sup></label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="address" required="" value="<?php echo $reciverInfo['adress']?>">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">邮政编码 <sup>*</sup></label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="postcode" required="" value="<?php echo $reciverInfo['postcode']?>">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">收货人姓名 <sup>*</sup></label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="true_name" required="" value="<?php echo $reciverInfo['true_name']?>">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">手机号码 <sup>*</sup></label>
<!--                <div class="col-lg-1">-->
<!--                    <select class="mob" name = 'mob'>-->
<!--                        <option>0086</option>-->
<!--                        <option>0061</option>-->
<!--                    </select>-->
<!--                </div>-->
                <div class="col-lg-2">
                    <input type="text" class="form-control" name="mob_phone" required="" value="<?php echo $reciverInfo['mob_phone']?>">
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
                <div class="col-lg-2">
                    <input type="text" class="form-control" name="idcard_number" required="" value="<?php echo $reciverInfo['idcard_number']?>">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-lg-4 control-label">证件照片 <sup>*</sup></label>
                <div class="col-lg-2">
                    <input type="hidden" name="front" alt="正面" id="img-box-hidden1" value="<?php if($reciverInfo['front_hidden']) {echo $reciverInfo['front_hidden'];}?>">
                    <div class="img-box upload-img" style="width: 150px; height: 100px;">
                        <img src="<?php if($reciverInfo['front']) {echo $reciverInfo['front'];}?>" style="width: 150px; height: 100px; position: absolute" class="img-box1">
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
                    <input type="hidden" name="back" alt="背面" id="img-box-hidden2" value="<?php if($reciverInfo['back_hidden']){echo $reciverInfo['back_hidden'];}?>">
                    <div class="img-box upload-img" style="width: 150px; height: 100px;">
                        <img src="<?php if($reciverInfo['back']) {echo $reciverInfo['back'];}?>" style="width: 150px; height: 100px; position: absolute" class="img-box2">
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
                    <input type="checkbox" class="colored-danger isdefault" name="is_default"
                           value="<?php echo $reciverInfo['is_default']?>"
                        <?php if($reciverInfo['is_default'] && $reciverInfo['is_default'] = 1){ echo "checked = 'checked'";} else{}?>
                        >
                    设为默认地址
                </div>
            </div>
            <input type="hidden" name="ar_id" value="<?php echo $reciverInfo['ar_id']?>">

            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-4">
                    <?= \yii\helpers\Html::submitButton('保存收货地址', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
                </div>
            </div>
            <?php  \yii\bootstrap\ActiveForm::end()?>
        </form>
    </div>
</div>