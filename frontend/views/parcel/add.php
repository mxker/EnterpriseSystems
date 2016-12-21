<?php
use yii\widgets\ActiveForm;
use common\assets\Select2Asset;
use common\assets\WizardAsset;
use common\assets\TreeviewAsset;
use common\widgets\upload\FileUpload;
use common\widgets\upload\FileUploadUI;
use yii\helpers\Html;
Select2Asset::register($this);
WizardAsset::register($this);
TreeviewAsset::register($this);
/* @var $this yii\web\View */
$this->title = '新增包裹';
$this->params['active_menu'] = 'new_parcel';
$this->params['header_titles'] = ['首页', '新增包裹'];
//写入css
$this->registerCssFile('/css/dialog.css');
$css = <<<EOF
.wizard.wizard-wired ul li{
    width: 33%;
}
.modal-preview .modal{
max-width:1000px;
}
.radio, .checkbox {
    position: relative;
    display: block;
    min-height: 20px;
    margin-top: 0px;
    margin-bottom: 0px;
}
.fileinput-button{
    display:none;
}
 /*下单方式标题*/
    .qk_menu {font-size:0;line-height:40px;text-align:center;}
    .qk_menu .qk_menu_tab {display:inline-block;*display:inline;*zoom:1;height:40px;width:auto;margin:0 30px;font-size:18px;color:#333;vertical-align:middle;}
    .qk_menu .qk_menu_tab:hover {text-decoration:none;}
    .qk_menu .qk_menu_tab.act,.qk_menu .qk_menu_tab.act:hover {border-bottom:1px solid #6a55a0;color: #6a55a0;}
    .qk_menu .imp {display:inline-block;*display:inline;*zoom:1;height:25px;width:1px;background-color:#333;vertical-align:middle;}
    .qk_subhead {font-size:14px;line-height:30px;text-align:center;font-weight:300;color:#999;}

    /*新增版块按钮*/
    .qk_new {position:relative;display:block;height:40px;width:100px;padding-left:30px;margin:0 auto;color:#fff;font-size:16px;line-height:40px;text-align:center;background-color:#60ade3;cursor:pointer;}
    .qk_new i {position:absolute;left:10px;top:0;display:block;height:40px;width:30px;background:url("/images/icons/icons-shizi-white.png") no-repeat right center;}
    .qk_new:active {background-color:#43799f;}

    /*页面框架*/
    input {box-shadow: none!important;/*之前默认css影响*/}
    .color_red {color: #ee0404!important;}

    .qk_wrapper {height:auto;width:1180px;margin:0 auto;color: #333;}
    .qk_mains {position:relative;height:auto;width:1180px;}
    .qk_main {position:relative;height:auto;width:1140px;padding:0 19px;margin-bottom:20px;border:1px solid #cacccb;}
    .qk_main_close {position: absolute;right:-1px;top: -1px;z-index:2;height: 35px;width: 35px;border: 1px solid #cacccb;background: url("<?php echo SHOP_TEMPLATES_URL;?>/images/icons/icons-x-big.png") no-repeat center #fff;cursor: pointer}
    .qk_main_close:active {background-color: #f0f0f0}
    .qk_panel {position:relative;height:auto;width:1140px;}
    .qk_orders {position:relative;height:auto;width:1180px;}
    .qk_order {position:relative;height:auto;width:1140px;padding:0 19px;margin-bottom:20px;border:1px solid #cacccb;}
    .qk_panel_row,.qk_order_row {min-height:50px;width:1140px;}

    .qk_panel_box,.qk_panel_shopping,.qk_order_box,.qk_order_shopping {}

    .clean {display: block;height: 0;width: 0;overflow: hidden;visibility: hidden;opacity: 0;clear: both;}
    .qk_w20 {position:relative;display: block;min-height:1px;width:20px;float: left;}
    .qk_w40 {position:relative;display: block;min-height:1px;width:40px;float: left;}
    .qk_w125 {position:relative;display: block;min-height:1px;width:125px;float: left;}
    .qk_w130 {position:relative;display: block;min-height:1px;width:130px;float: left;}
    .qk_w135 {position:relative;display: block;min-height:1px;width:135px;float: left;}
    .qk_w265 {position:relative;display: block;min-height:1px;width:265px;float: left;}
    .qk_w400 {position:relative;display: block;min-height:1px;width:400px;float: left;}
    .qk_w575 {position:relative;display: block;min-height:1px;width:575px;float: left;}
    .qk_w700 {position:relative;display: block;min-height:1px;width:700px;float: left;}
    .qk_w720 {position:relative;display: block;min-height:1px;width:720px;float: left;}
    .qk_w740 {position:relative;display: block;min-height:1px;width:740px;float: left;}
    .qk_w1015 {position:relative;display: block;min-height:1px;width:1015px;float: left;}

    .qk_z10 {z-index: 10;}
    .qk_z11 {z-index: 11;}
    .qk_z12 {z-index: 12;}
    .qk_z13 {z-index: 13;}
    .qk_max {z-index: 99;}

    .qk_sub {height:40px;font-size:0;line-height:40px;text-align:center;}
    .qk_sub .qk_sub_btn {display:inline-block;*display:inline;*zoom:1;height:40px;width:auto;padding:0 40px;margin:0 10px;font-size:18px;line-height:40px;text-align:center;vertical-align:middle;cursor:pointer;}
    .qk_sub.qk_sub_small .qk_sub_btn {height:32px;padding:0 30px;line-height:32px;}
    .qk_sub .qk_sub_btn.c_green {color:#fff;background-color:#61bc6e;}
    .qk_sub .qk_sub_btn.c_green:active {background-color:#3a7342;}
    .qk_sub .qk_sub_btn.c_yellow {color:#fff;background-color:#efa21c;}
    .qk_sub .qk_sub_btn.c_yellow:active {background-color:#ba7e16;}
    .qk_sub .qk_sub_btn.dis,.qk_sub .qk_sub_btn.dis:active {color:#fff;background-color:#cfcfcf;}


    /*------------操作面板---------------*/
    /*操作标题*/
    .qk_panel_title {height:90px;font-size:16px;line-height:90px;text-align:center;}


    /*商品操作*/
    .qk_panel_handle {position:relative;height:40px;}
    .qk_panel_handle .c_handle {position:absolute;width:100%;z-index:1;border:1px solid #ccc;overflow:hidden;}
    .qk_panel_handle .c_handle input {display:block;height:38px;width:100%;padding:0;margin:0;border:0;text-indent:10px;line-height:38px;}
    .qk_panel_handle .c_search {padding:0px;position:absolute;left:0;top:39px;z-index:3;display:block;height:auto;max-height:390px;width:100%;border-style:solid;border-color:#ccc;border-width:1px 1px 0 1px;font-size:14px;line-height:40px;background-color:#fff;overflow: auto;}
    .qk_panel_handle .c_search li {height:38px;padding:0 20px 0 10px;border-bottom:1px solid #ccc;text-align:left;cursor:pointer;background-color:#fff;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;;}
    .qk_panel_handle .c_search li:hover {background-color:#f5f5f5;}
    .qk_panel_handle .c_search li:active {background-color:#eee;}
    .qk_panel_handle .c_search li .c_xs {display: inline-block;*display:inline;*zoom:1;height:20px;width:auto;padding:0 5px;margin-right:3px;border-radius:2px;font-weight:300;color:#fff;line-height:20px;background-color:#ee0404;vertical-align: middle;}
    .qk_panel_handle .c_search li .imp {float:right;color:#369be1;}
    .qk_panel_handle .c_search li .imp:active {margin-left:1px;margin-top:1px;}
    .qk_panel_handle .c_cover {position:absolute;left:0;right:0;top:0;z-index:2;height:40px;padding:5px 10px;background-color:#d3eafa;overflow: hidden;}
    .qk_panel_handle .c_cover .c_xs {display: inline-block;*display:inline;*zoom:1;height:20px;width:auto;padding:0 5px;margin-right:3px;border-radius:2px;font-weight:300;color:#fff;line-height:20px;background-color:#ee0404;vertical-align: middle;}
    .qk_panel_handle .c_cover .c_close {display:block;height:20px;width:20px;border:1px solid #d2d2d2;position:absolute;right:9px;top:9px;cursor:pointer;background:url("/img/icons/icons-x.png") no-repeat center #fff;}
    .qk_panel_handle .c_cover p {line-height:30px;}
    .qk_panel_handle .c_btn {position:absolute;right:0;top:0;z-index:2;display:block;height:40px;padding-left:30px;width:70px;line-height:40px;color:#369be1;cursor:pointer;no-repeat 10px center;}
    .qk_panel_handle .c_btn:active {right:-1px;top:1px;}

    /*-------------------------------------------------------*/
    /*本页弹窗高度略大 重新约束弹窗top值*/
    #fwin_dialogWin {top:15%!important;}

    /*红框框-直接加border简单粗暴*/
    .hkk {position:relative;padding-bottom:30px!important;border: 1px solid #FF0000}
    .hkk_hint {position:absolute;left:0;bottom:0;height: 30px;padding-left:100px;line-height: 30px;font-size: 12px;color: #ff0000;}
    .upload_flower {display: block;position: absolute;left: 50%;top:0;z-index:10;height:70px;width: 110px;padding:20px 0;margin-left:-55px;color:#fff;text-align:center;border-radius: 50%;background-color: rgba(0,0,0,0.5);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#88000000,endColorstr=#88000000);}
    .upload_flower span {display: block;line-height: 30px;font-size: 16px;}
    .upload_flower label {display: block;line-height: 40px;font-size: 18px;}
    /*新增地址、编辑地址强行植入*/
    .qk_load_cover {position: fixed;left: 0;top: 0;z-index: 98;height: 100%;width: 100%;background-color:#fff;opacity: 0.3;}
    .qk_load_addr {position: absolute;left: -700px;top: 0;z-index:99;height: auto;width:698px;border:1px solid #ddd;background-color: #fff;}
    .qk_load_addr .qk_load_addr_content {margin-bottom: 5px;}
    .qk_load_addr .qk_load_addr_btns {height:35px;padding: 5px 0 5px 110px;}
    .qk_load_addr .qk_load_addr_btns .c_btns {height: 35px;width: 90px;margin-right: 30px;float:left;font-size: 14px;line-height: 35px;text-align: center;color: #fff;background-color: #7c61bb;cursor: pointer;}
    .qk_load_addr .qk_load_addr_btns .c_btns.c_black {background-color: #333;}
    .qk_load_addr .qk_load_addr_btns .c_btns:active {background-color: #573e91;}
    .qk_load_addr .qk_load_addr_btns .c_btns.c_black:active {background-color: #000;}

    .search_addr_import input {width:300px;height:30px;line-height: 30px;}
    .search_addr_import {height: 36px;width: 300px;background-color: #fff;margin-bottom: 10px;}
    #region .edit_region{display: inline-block;height: 24px;margin-left: 10px;padding: 0 5px;color: #fff;font-size: 12px;line-height:24px;vertical-align:middle;background-color: #3aac3d;}
    #region .edit_region:active {background-color: #2c822f;}
    .actions{
    z-index:0;
    }

EOF;
$this->registerCss($css);
//写入js
$this->registerJsFile('/js/areaselect/area-select.js', ['depends' => ['frontend\assets\AppAsset'], 'position' => $this::POS_END]);
$picurl = Yii::$app->params['upload_static_url'];
$js = <<<EOF
jQuery(function ($) {
        //获取token
        var is_idcard;
        var csrfToken = $('input[name="_csrf"]').val();
        //切换美元欧元
//        var money_name = $('.warehouse option:selected').attr('data-money')?$('.warehouse option:selected').attr('data-money'):'欧元';
//        $('.warehouse').change(function(){
//            money_name = $('.warehouse option:selected').attr('data-money');
//            $('.money-name').text(money_name);
//            })
//         $('.money-name').text(money_name);
        UITree.init();
         $('#WiredWizard').wizard().on('change', function (e,p1) {
         console.log(p1);
            if(p1.direction=='next'){
                if(p1.step==1){
                   //出发仓库判断
                    var warehouse = $('.warehouse option:selected').val();
                    if(warehouse==''){
                        alert('请选择出发仓库');
                        return false
                    }
                    if (!$("#pacelList").is(':has(div)') ) {
                        alert('请填写包裹信息');
                        return false
                    }
                    var weight_m = $('#weight_m').val();
                    if(weight_m==''){
                        alert('请填写包裹总重量');
                        return false
                    }
                    var pass = true;
                    var msg = '';
                    //申报类别
                    $("#pacelList input[name='import_catelog_id[]']").each(function(){
                        if($(this).val()==''){
                            pass = false;
                            alert('请填写申报类别');
                        }
                    });
                    //商品信息
                    $("#pacelList input[name='parcel_descript[]']").each(function(){
                        if($(this).val()==''){
                            pass = false;
                            alert('请填写商品信息');
                        }
                    });
                    //数量
                    $("#pacelList input[name='parcel_num[]']").each(function(){
                        if($(this).val()==''){
                            pass = false;
                            alert('请填写数量');
                        }else if(!(/^(\+|-)?\d+$/.test($(this).val()))){
                            pass = false;
                            alert('数量格式有误');
                        }
                    });
                    //单价
                    $("#pacelList input[name='unit_price[]']").each(function(){
                        if($(this).val()==''){
                            pass = false;
                            alert('请填写单价');
                        }else if(!(/^\\d+(\\.\\d+)?$/.test($(this).val()))){
                            pass = false;
                            alert('单价格式有误');
                        }
                    });
                     return pass;
                }else if(p1.step==2){
                 if($('input:radio[name="logistics_channel_id"]:checked').val()==undefined){
                    alert('请选择转运渠道');
                    return false
                 }else{
                    is_idcard =$('input:radio[name="logistics_channel_id"]:checked').attr('data-idcard');
                 }

                }
            }

        });
        $('#WiredWizard').wizard().on('finished', function (e) {
          if($('#ar_id').val()==''){
            alert('请选择收货人地址');
            return false
          }
//         if($('input:radio[name="addr_sender_id"]:checked').val()==undefined){
//            alert('请选择发货人地址');
//            return false
//         }
           $("#form").submit();
        });
        //$('#WiredWizard').wizard();
        $(".warehouse").select2({placeholder:"Select a state",allowClear:true});

        //添加商品包裹
        $('#addParcel').bind('click', function() {
            var str = '<div class="col-lg-12 col-sm-12 col-xs-12 pacel">'+
                '<div class="widget">'+
                    '<div class="widget-header bordered-left ">'+
                        '<span style="cursor:pointer" class="widget-caption glyphicon glyphicon-trash"></span>'+
                    '</div>'+
                    '<div style="height:100px;" class="widget-body bordered-left ">'+
                            '<div class="form-group col-lg-3 col-sm-3 col-xs-3">'+
                                '<label>商品名称:</label><input type="hidden" class="form-control type_id" name="import_catelog_id[]"  placeholder="请选择申报类别"><input type="declare" name="import_catelog_name[]" class="form-control declare"  placeholder="请选择申报类别">'+
                            '</div>'+
                            '<div class="form-group col-lg-3 col-sm-3 col-xs-3">'+
                                '<label>品牌/型号/规格:</label>'+
                                '<input type="text" name="parcel_descript[]" class="form-control"  placeholder="爱他美1+A1+600g">'+
                            '</div>'+
                            '<div class="form-group col-lg-3 col-sm-3 col-xs-3">'+
                                '<label>数量:</label>'+
                                '<input type="text" name="parcel_num[]" class="form-control"  placeholder="请输入数量">'+
                            '</div>'+
                            '<div class="form-group col-lg-3 col-sm-3 col-xs-3">'+
                                '<label>单价:</label>'+
                                 '<div class="input-group">'+
                                    '<input type="text" name="unit_price[]" placeholder="请输入单价" class="form-control">'+
                                    '<span class="input-group-addon money-name">人民币</span>'+
                                '</div>'+
                            '</div>'+

                    '</div>'+
                '</div>'+
            '</div>';
            $("#pacelList").append(str);
        });
        $("#pacelList").on("click",".glyphicon-trash", function() {
            $(this).closest(".pacel").remove();
        });

        //保存当前input节点
        var self;
         $("#pacelList").on("click",".declare", function() {
            self = $(this);
            $("#dialog").show();
            $(".ui-widget-overlay").show();
        });

         $(".ui-dialog-titlebar-close").on("click",function() {
            $("#dialog").hide();
            $(".ui-widget-overlay").hide();
        });

        $("#goodsTypeContWrap").on("click","a",function(){
            var type_name = $(this).text();
            var type_id = $(this).attr('catalogid');
            self.val(type_name);
            self.prev().val(type_id);
            $("#dialog").hide();
            $(".ui-widget-overlay").hide();
        });

         $("#goodsTypeMenuWrap").on("click","a",function(){
           var ic_id = $(this).attr('catalogid');
           var now =$(this);
           $.ajax({
               url: '/parcel/gettclist',
               type: 'post',
               data: {'ic_id':ic_id,'_csrf':csrfToken},
               dataType:'json',
               success: function (data) {
                  if(data.code==200){
                     $("#goodsTypeMenuWrap a").removeClass("active");
                     now.addClass("active");
                     var secondlist = data.data;
                     var html = '';
                       $.each(secondlist, function (n, value) {
                            var ht='';
                            $.each(value.thirdList,function(i,v){
                             ht += '<a href="javascript:;" class="item" catalogid="'+v.ic_id+'" data-units="[]">'+v.name+'</a>';
                            });
                           html += '<li class="clearfix">'+
                                   '<div class="fl" catalogid="'+value.ic_id+'">'+value.name+
                                      '<span class="arrow"></span></div>'+
                                      '<div class="fr" style="width: 395px;">'+ht+
                                   '</div>'+
                                   '</li>';
                        });


                     $("#goodsTypeContWrap").html(html);
                     goodsTypeContWrap
                  }else{
                    console.log(data);
                  }
               }
          });

        });

        //删除收货地址
         $("#wiredstep3").on("click",".delSr", function() {
         if(confirm('确定删除?')==false)return false;
             var ar_id = $(this).attr('data-id');
             var self = $(this);
             $.ajax({
               url: '/parcel/del-address',
               type: 'post',
               data: {'ar_id':ar_id,'_csrf':csrfToken},
               dataType:'json',
               success: function (data) {
                  if(data.code==200){
                    self.closest("tr").remove();
                  }else{
                    console.log(data);
                  }
               }
           });

         });

         //删除发货地址
         $("#wiredstep3").on("click",".delSd", function() {
            if(confirm('确定删除?')==false)return false;
             var as_id = $(this).attr('data-id');
             var self = $(this);
             $.ajax({
               url: '/parcel/del-sender-address',
               type: 'post',
               data: {'as_id':as_id,'_csrf':csrfToken},
               dataType:'json',
               success: function (data) {
                  if(data.code==200){
                    self.closest("tr").remove();
                  }else{
                    console.log(data);
                  }
               }
           });

         });

        var tr;
         //收货地址弹框
         $("#addAdr").on("click",function(){
                $("#region").nextAll().remove();
                 $("#region").nc_region();
                 $("#reDia").show();
                 $(".ui-widget-overlay").show();
         })
         $("#wiredstep3").on("click",".modifySr", function() {
           // self = $(this);
           tr = $(this).closest("tr");
            var ar_id = $(this).attr('data-id');
             $.ajax({
               url: '/parcel/get-receiver-address',
               type: 'post',
               data: {'ar_id':ar_id,'_csrf':csrfToken},
               dataType:'json',
               success: function (data) {
                  if(data.code==200){
                    var ar = data.data;
                    console.log(data.data);
                     $("#region").nextAll().remove();
                    $("#editAddressForm input[name='ar_id']").val(ar.ar_id);
                    $("#editAddressForm input[name='region']").val(ar.area_info);
                    $("#editAddressForm input[name='adress']").val(ar.adress);
                    $("#editAddressForm input[name='postcode']").val(ar.postcode);
                    $("#editAddressForm input[name='true_name']").val(ar.true_name);
                    $("#editAddressForm input[name='mob_phone']").val(ar.mob_phone);
                    $("#editAddressForm input[name='idcard_number']").val(ar.idcard_number);
                    $("#region").nc_region();
                     $("#reDia").show();
                     $(".ui-widget-overlay").show();
                     var result=ar.idcard_photo.split(",");
                     console.log(result);
                    $("#addrIdPhoto01").attr('src','$picurl'+result[0]);
                    $("#idcard1").val(result[0]);
                    $("#addrIdPhoto02").attr('src','$picurl'+result[1]);
                    $("#idcard2").val(result[1]);
                  }else{
                    console.log(data);
                  }
               }
           });


        });

        //发货地址弹框
          $("#addsAdr").on("click",function(){
                    $("#region").nextAll().remove();
                  $(".dialog2").show();
                    $(".ui-widget-overlay").show();
         })
         $("#wiredstep3").on("click",".modifySd", function() {
           // self = $(this);
            tr = $(this).closest("tr");
            var as_id = $(this).attr('data-id');
             $.ajax({
               url: '/parcel/get-sender-address',
               type: 'post',
               data: {'as_id':as_id,'_csrf':csrfToken},
               dataType:'json',
               success: function (data) {
                  if(data.code==200){
                    var ar = data.data;
                    console.log(data.data);
                    $("#editAddressForm2 .country_id").val(ar.country_id);
                    $("#editAddressForm2 input[name='as_id']").val(ar.as_id);
                    $("#editAddressForm2 input[name='adress']").val(ar.adress);
                    $("#editAddressForm2 input[name='postcode']").val(ar.postcode);
                    $("#editAddressForm2 input[name='true_name']").val(ar.name);
                    $("#editAddressForm2 input[name='mob_phone']").val(ar.mob_phone);
                     $(".dialog2").show();
                     $(".ui-widget-overlay").show();
                  }else{
                    console.log(data);
                  }
               }
           });


        });

         $(".glyphicon-remove3").on("click",function() {
            $("#reDia").css({"display":"none"});
            $(".ui-widget-overlay").hide();
        });
        $(".glyphicon-remove2").on("click", function() {
            $(".dialog2").hide();
            $(".ui-widget-overlay").hide();
        });

        $("#addrIdPhoto1").on('click',function(){
           return $('#upload-img-1').click();
        })
         $("#addrIdPhoto2").on('click',function(){
           return $('#upload-img-2').click();
        })

        function uploadImg(formdata,dom){
            jQuery.ajax({
                url : url,
                type : 'post',
                data : formdata,
                cache : false,
                contentType : false,
                processData : false,
                dataType : "json",
                success : function(data) {
                if (data.error == 0) {
                    v_this.parent().children(".img_upload").attr("src", data.url);
                    //$("#img").attr("src",data.url);
                    }
                }
            });
        }

        /*$('#file1,#file2').change(function() {
            var formdata = new FormData();
            var v_this = $(this);
            console.log(v_this);
            var fileObj = v_this.get(0).files;
            url = "/parcel/uploadimg";
            //var fileObj=document.getElementById("fileToUpload").files;
            if(v_this.attr("id")=='file1'){
                formdata.append("firstimg", fileObj[0]);
            }else{
                formdata.append("secondimg", fileObj[0]);
            }
            formdata.append("_csrf", csrfToken);
            uploadImg(formdata,v_this);
        });*/

        //收货地址提交
        $(".ui-button-text").on("click", function() {
                var idcard = '';
                var ar_id = $("#editAddressForm input[name='ar_id']").val();
                var region = $("#editAddressForm input[name='region']").val();
                var adress = $("#editAddressForm input[name='adress']").val();
                var postcode = $("#editAddressForm input[name='postcode']").val();
                var true_name = $("#editAddressForm input[name='true_name']").val();
                var mob_phone = $("#editAddressForm input[name='mob_phone']").val();
                var idcard_number = $("#editAddressForm input[name='idcard_number']").val();
                var idcard1 = $("#editAddressForm input[name='idcard1']").val();
                var idcard2 = $("#editAddressForm input[name='idcard2']").val();
                if(!(region&&adress&&postcode&&true_name&&mob_phone)){
                    alert('请完善地址信息');
                    return false;
                }
                if((idcard_number&&idcard1&&idcard2)||(!idcard_number&&!idcard1&&!idcard2)){
                    if(idcard1&&idcard2){
                     idcard = idcard1+','+idcard2;
                    }
                }else{
                    alert('身份信息不齐全');
                    return false;
                }

               $.ajax({
                cache: true,
                type: "POST",
                url:'/parcel/modify-address',
                data:{'ar_id':ar_id,'idcard_number':idcard_number,'idcard':idcard,'area_info':region,'adress':adress,'postcode':postcode,'true_name':true_name,'mob_phone':mob_phone,_csrf:csrfToken},
                async: false,
                dataType:'json',
                error: function(request) {
                    alert("Connection error");
                },
                success: function(data) {
                    if(data.code==200){
//                    var data = data.data;
//                     tr.find(".name").text(data.true_name);
//                     tr.find(".area_info").text(data.area_info);
//                     tr.find(".adress").text(data.adress);
//                     tr.find(".postcode").text(data.postcode);
//                     tr.find(".mob_phone").text(data.mob_phone);
                     $("#reDia").hide();
                     $(".ui-widget-overlay").hide();
                    }
                }
            });
        })

        //发货地址提交
        $(".ui-button-text2").on("click", function() {
                var as_id = $("#editAddressForm2 input[name='as_id']").val();
                var adress = $("#editAddressForm2 input[name='adress']").val();
                var postcode = $("#editAddressForm2 input[name='postcode']").val();
                var name = $("#editAddressForm2 input[name='true_name']").val();
                var mob_phone = $("#editAddressForm2 input[name='mob_phone']").val();
                var country_id = $("#editAddressForm2 select[name='country_id']").val();
                if(!(adress&&postcode&&name&&mob_phone&&country_id)){
                    alert('请完善发货地址信息');
                    return false;
                }
               $.ajax({
                cache: true,
                type: "POST",
                url:'/parcel/modify-send-address',
                data:{'country_id':country_id,'as_id':as_id,'adress':adress,'postcode':postcode,'name':name,'mob_phone':mob_phone,_csrf:csrfToken},
                async: false,
                dataType:'json',
                error: function(request) {
                    alert("Connection error");
                },
                success: function(data) {
                    if(data.code==200){
//                      var data = data.data;
//                     tr.find(".name").text(data.name);
//                     tr.find(".city").text(data.city);
//                     tr.find(".adress").text(data.adress);
//                     tr.find(".postcode").text(data.postcode);
//                     tr.find(".mob_phone").text(data.mob_phone);
                     $(".dialog2").hide();
                    $(".ui-widget-overlay").hide();
                    }
                }
            });
        })

         //搜索地址
         var adrDeleteBtn=$("#deleteAdr");//移除地址按钮
         var adrsDeleteBtn=$("#deleteAdrs");//移除地址按钮
        var mainData={address:null,addresss:null};
        var adrHandle=$("#adrHandle");//地址搜索input
        var adrSearch=$("#adrSearch");//地址搜索下拉列表
        var adrCover=$("#adrCover");//地址遮罩
         var adrsHandle=$("#adrsHandle");//地址搜索input
        var adrsSearch=$("#adrsSearch");//地址搜索下拉列表
        var adrsCover=$("#adrsCover");//地址遮罩
        var searchCache=null,searchKey=0,searchInterval=null;
        adrHandle.on("keyup",inputSearchAdr).on("focus",inputFocus);
        adrsHandle.on("keyup",inputSearchAdr).on("focus",inputFocus);
        $("body").on("click",function(e){
            var evt=$(e.target);
            if(!evt.parents(".e_handle").length&&searchCache!==null){
                //移除所有input的搜索结果
                clearInputSearch();
            }
        });

        function inputSearchAdr(e){

            var _t=$(this);
            var _v=_t.val();
            var adrType = $(this).attr('id');
            var url;
            if(adrType=='adrHandle'){
                url = '/parcel/get-addr-receiver';
                adrSearch.show();
            }else{
                url = '/parcel/get-addr-sender';
                adrsSearch.show();
            }
            if(searchCache!==_v){
                searchCache=_v;
                if(!searchInterval){
                    searchInterval=setTimeout(function(){
                        searchInterval=null;
                        searchKey++;
                        var mack=searchKey;
                        //搜索地址
                        $.ajax({
                            url:url,
                            type:"post",
                            dataType:"json",
                            data:{keyword:searchCache},
                            global:false,
                            timeout:3000,
                            success:function(res){
                                if(adrType=='adrHandle'){
                                    if(mack!==searchKey){//舍弃此次搜索结果
                                        return false;
                                    }
                                    if(res){
                                       var html = '';
                                            console.log(res.data);
                                        $.each(res.data,function(i,val){
                                                var id_card=0;
                                                if(val.idcard_photo&&val.idcard_number){
                                                id_card = 1;
                                                }
                                                var obj ={
                                                 ar_id:val.ar_id,
                                                 hasCard:id_card,
                                                 trueName:val.true_name,
                                                 phone:val.mob_phone,
                                                 areaInfo:val.area_info,
                                                 adress:val.adress,
                                                 postcode:val.postcode,
                                                 }
                                              var str = JSON.stringify(obj).replace(/"/ig,"'")
                                              html+='<li class="e_adr_row" data-json="'+str+'">'+
                                                    '<span class="addr">'+val.true_name+'&nbsp;'+val.mob_phone+'&nbsp;'+val.area_info+'&nbsp;'+val.adress+'&nbsp;'+'邮编'+val.postcode+'</span></li>';
                                        })
                                       // console.log(html);
                                        adrSearch.html(html);
                                    }
                                    else {
                                        adrSearch.html('<li class="text_center">没有找到相关地址</li>');
                                    }
                                }else{
                                    if(mack!==searchKey){//舍弃此次搜索结果
                                        return false;
                                    }
                                    if(res){
                                       var html = '';
                                            console.log(res.data);

                                        $.each(res.data,function(i,val){
                                              var obj ={
                                                 as_id:val.as_id,
                                                 trueName:val.name,
                                                 phone:val.mob_phone,
                                                 adress:val.adress,
                                                 postcode:val.postcode,
                                                 }
                                              var str = JSON.stringify(obj).replace(/"/ig,"'");
                                              html+='<li class="e_adr_row" data-json="'+str+'">'+
                                                    '<span class="addr">'+val.name+'&nbsp;'+val.mob_phone+'&nbsp;'+val.adress+'&nbsp;'+'邮编'+val.postcode+'</span></li>';
//                                              html+='<li class="e_adr_row" data-json={"as_id":"'+val.as_id+'","trueName":"'+val.name+'","phone":"'+val.mob_phone+'","adress":"'+val.adress+'","postcode":"'+val.postcode+'"}>'+
//                                            '<span class="e_edit_adr imp">修改</span><span class="addr">'+val.name+'&nbsp;'+val.mob_phone+'&nbsp;'+val.adress+'&nbsp;'+'邮编'+val.postcode+'</span></li>';
//
                                        })
                                       // console.log(html);
                                        adrsSearch.html(html);
                                    }
                                    else {
                                        adrsSearch.html('<li class="text_center">没有找到相关地址</li>');
                                    }
                                }
                            },
                            error:function(){
                                adrSearch.html('<li class="text_center">没有找到相关地址</li>');
                            }
                        });
                    },150);
                }
            }
        }
        function fetchAdr(adrData){
                adrData = JSON.parse(adrData);
                if(typeof adrData==="object"&&adrData!==null){
                    if(!adrData.hasCard){
                        //检查商品中是否有需要身份证的商品
                        if(is_idcard>0){
                            alert("购买该商品需要上传身份证，请更换地址或为地址添加身份证");
                            return false;
                        }
                    }
                    mainData.address=adrData;
                    $('#ar_id').val(adrData.ar_id);
                    adrCover.show().find("p").html(adrData.trueName+'&nbsp'+adrData.phone+'&nbsp'+adrData.areaInfo+'&nbsp'+adrData.adress+' &nbsp 邮编:'+adrData.postcode );
                    adrSearch.hide();
                }
                else {
                    //移除地址
                    mainData.address=null;
                    $('#ar_id').val('');
                    adrCover.hide().find("p").html("");
                    adrSearch.hide();
                }
                //是否能提交订单
                return true;
            }
        function fetchAdrs(adrData){
                adrData = JSON.parse(adrData);
                if(typeof adrData==="object"&&adrData!==null){
                    mainData.addresss=adrData;
                    $('#as_id').val(adrData.as_id);
                    adrsCover.show().find("p").html(adrData.trueName+'&nbsp'+adrData.phone+'&nbsp'+adrData.adress+' &nbsp 邮编:'+adrData.postcode );
                    adrsSearch.hide();
                }
                else {
                    //移除地址
                     $('#as_id').val('');
                    mainData.addresss=null;
                    adrsCover.hide().find("p").html("");
                    adrsSearch.hide();
                }
                //是否能提交订单
                return true;
            }
        $("#adrSearch").on("click", 'li',function() {
        var addresssJson=$(this).attr('data-json').replace(/'/ig,'"');
                if(fetchAdr(addresssJson)){
                    clearInputSearch();
                }
            adrSearch.hide();
        })
         $("#adrsSearch").on("click", 'li',function() {

                var addresssJson=$(this).attr('data-json').replace(/'/ig,'"');
                if(fetchAdrs(addresssJson)){
                    clearInputSearch();
                }
            adrsSearch.hide();
        })
       /*  adrHandle.on("blur",function(e){
            adrSearch.hide();
        })*/

         /*清除所有input搜索状态*/
        function clearInputSearch(){
            adrSearch.html("").hide();
            adrsSearch.html("").hide();
            searchCache=null;
            searchKey++;
            searchInterval&&clearTimeout(searchInterval);
            searchInterval=null;
        }
        /*input获得焦点移除其他input下拉列表*/
        function inputFocus(e){
            var _t=$(this);
            //移除其他input的搜索结果
            clearInputSearch();
            _t.keyup();
        }

         adrDeleteBtn.on("click",function(){
           fetchAdr(null);
        });
        adrsDeleteBtn.on("click",function(){
           fetchAdrs(null);
        });

    });
EOF;
$this->registerJs($js, $this::POS_END);
?>
<div class="row">
<div class="col-lg-12 col-sm-12 col-xs-12">
<div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps">
    <ul class="steps">
        <li data-target="#wiredstep1" class="active"><span class="step steps">1</span><span
                class="title">添加物流/商品信息</span><span class="chevron"></span></li>
        <li data-target="#wiredstep2"><span class="step steps">2</span><span class="title">选择转运服务</span> <span
                class="chevron"></span></li>
        <li data-target="#wiredstep3"><span class="step steps">3</span><span class="title">选择收货地址/发货地址</span> <span
                class="chevron"></span></li>
        <!--      <li data-target="#wiredstep4"><span class="step">4</span><span class="title">完成包裹</span> <span class="chevron"></span></li>
         --><!--     <li data-target="#wiredstep5"><span class="step">5</span><span class="title">Step 5</span> <span class="chevron"></span></li>
           --> </ul>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'form',
]);?>
<input type="hidden" name="id" value="<?=$id?>">
<div class="step-content" id="WiredWizardsteps">
<div class="step-pane active" id="wiredstep1" style="padding-left: 5px;">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div id="registration-form" style="padding-left: 20px;">
                        <h5 class="row-title before-Success"><i class="fa fa-edit " style="color: #03b3b2"></i>新增包裹</h5>

                        <div class="form-title">
                            物流信息
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <h6>第三方订单号:</h6>
                            <div class="input-group col-sm-3">
                                <input type="text" id="out_trade_no" name="out_trade_no" class="form-control" value="<?=isset($parcel['out_trade_no'])?$parcel['out_trade_no']:''?>">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 30px;">
                            <h6>出发地:</h6>
                            <select name="storehouse_id" class="warehouse" style="width:50%;">
                                <option value="">请选择出发仓库</option>
                                <?php if ($country && is_array($country)) { ?>
                                    <?php foreach ($country as $value) { ?>
                                        <optgroup label="<?= $value['name'] ?>">
                                            <?php foreach ($value['storehouse'] as $v) { ?>
                                                <option <?php if(isset($parcel['storehouse_id'])) if($parcel['storehouse_id']==$v['storehouse_id']){ ?> selected <?php } ?>
                                                        value="<?= $v['storehouse_id'] ?>"><?= $v['name'] ?></option>
                                            <?php } ?>
                                        </optgroup>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-title">
                            包裹信息
                        </div>
                        <div class="row" id="pacelList">
                            <?php if(isset($parcel['parcelGoods'])&&$parcel['parcelGoods']&&is_array($parcel['parcelGoods'])){ foreach($parcel['parcelGoods'] as $pa){ ?>
                            <div class="col-lg-12 col-sm-12 col-xs-12 pacel">
                                <div class="widget">
                                    <div class="widget-header bordered-left "><span style="cursor:pointer"
                                                                                    class="widget-caption glyphicon glyphicon-trash"></span>
                                    </div>
                                    <div style="height:100px;" class="widget-body bordered-left ">
                                        <div class="form-group col-lg-3 col-sm-3 col-xs-3"><label>商品名称:</label><input
                                                type="hidden" class="form-control type_id" name="import_catelog_id[]"
                                                placeholder="请选择申报类别" value="<?=$pa['importCatalog']['ic_id']?>"><input type="declare" name="import_catelog_name[]"
                                                                             class="form-control declare"
                                                                             placeholder="请选择申报类别" value="<?=$pa['importCatalog']['name']?>"></div>
                                        <div class="form-group col-lg-3 col-sm-3 col-xs-3"><label>品牌/型号/规格:</label><input
                                                type="text" name="parcel_descript[]" class="form-control"
                                                placeholder="爱他美1+A1+600g" value="<?=$pa['parcel_descript']?>"></div>
                                        <div class="form-group col-lg-3 col-sm-3 col-xs-3"><label>数量:</label><input
                                                type="text" name="parcel_num[]" class="form-control"
                                                placeholder="请输入数量" value="<?=$pa['parcel_num']?>"></div>
                                        <div class="form-group col-lg-3 col-sm-3 col-xs-3"><label>单价:</label>

                                            <div class="input-group"><input type="text" name="unit_price[]"
                                                                            placeholder="请输入单价"
                                                                            class="form-control" value="<?=$pa['unit_price']?>"><span
                                                    class="input-group-addon money-name">人民币</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }} ?>
                        </div>

                        <div id="addParcel" style="cursor:pointer;height:25px;color:#03b3b2;font-size: 20px;"
                             class="glyphicon glyphicon-plus-sign"><span style="padding-left: 2px;margin-top: 0px;">添加一个商品</span>
                        </div>


                        <div class="form-group" style="margin-top: 30px;">
                            <h6>包裹总重量:</h6>
                            <div class="input-group col-sm-3">
                                <input type="text" id="weight_m" name="weight_m" class="form-control" value="<?=isset($parcel['weight_m'])?$parcel['weight_m']:''?>">
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<div class="step-pane" id="wiredstep2">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="widget">
                <div class="widget-header ">
                    <span class="widget-caption">选择转运服务</span>

                    <div class="widget-buttons">
                        <a href="#" data-toggle="maximize">
                            <i class="fa fa-expand"></i>
                        </a>
                        <a href="#" data-toggle="collapse">
                            <i class="fa fa-minus"></i>
                        </a>
                        <!--<a href="#" data-toggle="dispose">
                            <i class="fa fa-times"></i>
                        </a>-->
                    </div>
                </div>
                <div class="widget-body">
                    <table class="table table-striped table-bordered table-hover" id="expandabledatatable">
                        <thead>
                        <tr>
                            <th>

                            </th>
                            <th>
                                名称
                            </th>
                            <!-- <th>
                                 Family
                             </th>
                             <th>
                                 Age
                             </th>
                             <th>
                                 Position
                             </th>
                             <th>
                                 Interests
                             </th>
                             <th>Picture</th>-->
                        </tr>
                        </thead>

                        <tbody>
                        <?php if ($logistics_channel && is_array($logistics_channel)) { ?>
                            <?php foreach ($logistics_channel as $log_ch) { ?>
                                <tr>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input data-idcard="<?= $log_ch['is_idcard'] ?>" name="logistics_channel_id" type="radio"
                                                       value="<?= $log_ch['lc_id'] ?>" <?php if(isset($parcel['logistics_channel_id'])) if($log_ch['lc_id']==$parcel['logistics_channel_id']){ ?> checked="" <?php } ?> class="colored-success">
                                                <span class="text"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $log_ch['name'] ?>
                                    </td>
                                    <!--<td>
                                        Larson
                                    </td>
                                    <td>
                                        27
                                    </td>
                                    <td>
                                        Software Manager
                                    </td>
                                    <td>
                                        Swimming
                                    </td>
                                    <td>
                                        Nicolai-Larson.jpg
                                    </td>-->
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="step-pane " id="wiredstep3">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="widget">
                <div class="widget-header ">
                    <span class="widget-caption">选择收货地址</span>

                    <div class="widget-buttons">
                        <a href="#" data-toggle="maximize">
                            <i class="fa fa-expand"></i>
                        </a>
                        <a href="#" data-toggle="collapse">
                            <i class="fa fa-minus"></i>
                        </a>
                        <!--<a href="#" data-toggle="dispose">
                            <i class="fa fa-times"></i>
                        </a>-->
                    </div>
                </div>
                <div class="widget-body">
                    <div class=" qk_panel_row e_row qk_z10">
                        <div class="col-xs-6">
                            <div class="qk_panel_handle e_handle">
                                <div id="addAdr" class="c_btn">新增</div>
                                <div class="c_handle">
                                    <input type="hidden" id="ar_id" name="ar_id" value="<?=isset($parcel['addr_reciver_id'])?$parcel['addr_reciver_id']:''?>">
                                    <input id="adrHandle" type="text" placeholder="请输入收货地址关键字">
                                </div>
                                <ul id="adrSearch" class="c_search" style="display: none;">
                                    <!--<li class="e_adr_list"><span class="imp">修改</span>地址信息地址址信息地址信息地址信息地址信息地址信息地址信息</li>-->
                                </ul>

                                <div id="adrCover" class="c_cover" <?php if(isset($parcel['addrReceiver'])){ ?>style="display: block;"<?php }else{?>style="display: none;" <?php }?>>
                                    <div id="deleteAdr" class="c_close"></div>
                                    <p><?php if(isset($parcel['addrReceiver'])){ ?><?=$parcel['addrReceiver']['true_name']?></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="mob_phone"><?=$parcel['addrReceiver']['mob_phone']?></span>&nbsp;&nbsp; <span class="area_info_adress"><?=$parcel['addrReceiver']['area_info']?>&nbsp;&nbsp;<?=$parcel['addrReceiver']['adress']?></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="postcode"><?=$parcel['addrReceiver']['postcode']?></span><?php } ?></p>
                                </div>
                            </div>
                        </div>
                        <!--<div class="qk_w40">
                            <div id="qkLoadCover" class="qk_load_cover" style="display: none;"></div>
                            <div id="qkLoadPage" class="qk_load_addr" style="display: none;">
                                <div id="qkLoadContent" class="qk_load_addr_content"></div>
                                <div class="qk_load_addr_btns">
                                    <div id="qkLoadSave" class="c_btns">保存</div>
                                    <div id="qkLoadCancel" class="c_btns c_black">取消</div>
                                </div>
                                <div class="blank3"></div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-12 col-md-12">
            <div class="widget">
                <div class="widget-header ">
                    <span class="widget-caption">选择发货地址</span>

                    <div class="widget-buttons">
                        <a href="#" data-toggle="maximize">
                            <i class="fa fa-expand"></i>
                        </a>
                        <a href="#" data-toggle="collapse">
                            <i class="fa fa-minus"></i>
                        </a>
                        <!--<a href="#" data-toggle="dispose">
                            <i class="fa fa-times"></i>
                        </a>-->
                    </div>
                </div>
                <div class="widget-body">
                    <div class=" qk_panel_row e_row qk_z10">
                        <div class="col-xs-6">
                            <div class="qk_panel_handle e_handle">
                                <div id="addsAdr" class="c_btn">新增</div>
                                <div class="c_handle">
                                    <input type="hidden" id="as_id" name="as_id" value="<?=isset($parcel['addr_sender_id'])?$parcel['addr_sender_id']:''?>">
                                    <input id="adrsHandle" type="text" placeholder="请输入发货地址关键字">
                                </div>
                                <ul id="adrsSearch" class="c_search" style="display: none;">
                                    <!--<li class="e_adr_list"><span class="imp">修改</span>地址信息地址址信息地址信息地址信息地址信息地址信息地址信息</li>-->
                                </ul>
                                <div id="adrsCover" class="c_cover" <?php if(isset($parcel['addrSender'])){ ?>style="display: block;"<?php }else{?>style="display: none;" <?php }?>>
                                    <div id="deleteAdrs" class="c_close"></div>
                                    <p><?php if(isset($parcel['addrSender'])){ ?><span class="name"><?=$parcel['addrSender']['name']?></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="mob_phone"><?=$parcel['addrSender']['mob_phone']?></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="city_adress"><?=$parcel['addrSender']['adress']?></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="postcode"><?=$parcel['addrSender']['postcode']?><?php } ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div id="reDia" tabindex="-1" role="dialog" class="ui-dialog ui-corner-all ui-widget ui-widget-content ui-front ui-dialog-buttons ui-draggable"
             aria-describedby="addressDialog" aria-labelledby="ui-id-144"
             style="height: auto; width: 760px; margin-left: 25%; margin-top: -300px; display: none; z-index: 10002;">
            <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle"><span
                    id="ui-id-144" class="ui-dialog-title">编辑地址</span>
                <button  type="button"
                        class="glyphicon-remove3 ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close"
                        title="Close">
                    <span style="margin-top: 12px; font-size: 20px;" class="glyphicon  glyphicon-remove"></span>
                </button>
            </div>
            <div id="addressDialog" class="ui-dialog-content ui-widget-content"
                 style="display: block; width: auto; min-height: 558px; max-height: none; height: auto;">
                <form id="editAddressForm" >
                    <input name="ar_id" type="hidden" value="">
                    <ul class="edit-address-wrap">
                        <li><label>所在地区<b>*</b>：</label><input id="region" name="region" type="hidden" class="input" value="" ></li>
                        <li><label>详细地址<b>*</b>：</label> <input type="text" name="adress" class="input"
                                                                value=""
                                                                placeholder="建议您如实填写详细收货地址，例如街道名称，门牌号码，楼层和房间号等信息"></li>
                        <li><label>邮政编码<b>*</b>：</label> <input type="text" name="postcode" class="input" value=""
                                                                placeholder="为保证包裹派送时效，请准确填写邮编" style="width: 280px;"></li>
                        <li><label>收货人姓名<b>*</b>：</label> <input type="text" name="true_name" class="input" value=""
                                                                 style="width: 280px;"> <span
                                class="gray">（收货人姓名请务必与证件保持一致）</span></li>
                        <li><label>手机号码<b>*</b>：</label>  <input type="text" name="mob_phone"
                                                                 class="input" value=""
                                                                 style="width: 176px;"></li>
                        <li><label>身份证号码：</label> <input type="text" id="idcard_number"
                                                         name="idcard_number" class="input"
                                                         value=""
                                                         style="width: 275px;"></li>
                        <li><label>身份证照片：</label>
                            <?=Html::csrfMetaTags()?>
                            <div id="idPhotoBox01"  style="position: relative;" class="webuploader-container">

                                <div  class="webuploader-pick"><img id="addrIdPhoto01" src="">
                                </div>
                                <input type="hidden" id="idcard1" name="idcard1" value="">
                                <div id=""
                                     style="position: absolute; top: 0px; left: 0px; width: 75px; height: 42px; overflow: hidden; bottom: auto; right: auto;">
                                    <?=FileUpload::widget([
                                        'model' => $fileModel,
                                        'attribute' => 'file',
                                        'url' => ['site/uploadImg'], // your url, this is just for demo purposes,
                                        'buttonClass' => 'btn btn-xs btn-default purple',
                                        'options' => [
                                            'accept' => 'image/*',
                                            'class' => 'abc',
                                            'id' => 'upload-img-1'
                                        ],
                                        'clientOptions' => [
                                            'maxFileSize' => 2000000,
                                            'autoUpload' => true,
                                        ],
                                        // Also, you can specify jQuery-File-Upload events
                                        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
                                        'clientEvents' => [
                                            'fileuploaddone' => 'function(e, data) {
                                            if(data.result.error){
                                                alert(data.result.error);
                                            }else{
                                                var pic = JSON.parse(data.result).files[0];
                                                $("#addrIdPhoto01").attr("src",pic.thumbnailUrl);
                                                $("#idcard1").val(pic.url);
                                            }
                                            console.log(pic);
                                }',
                                            'fileuploadfail' => 'function(e, data) {

                                }',
                                        ],
                                    ]);?>
                                   <!-- <input id="file1" type="file" name="file" class="webuploader-element-invisible" multiple="multiple"
                                           accept="image/*">--><label id="addrIdPhoto1"
                                                                   style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
                                </div>
                            </div>
                            <div id="idPhotoBox02" style="position: relative;" class="webuploader-container">
                                <div class="webuploader-pick"><img id="addrIdPhoto02" src="">
                                </div>
                                <input type="hidden" id="idcard2" name="idcard2" value="">
                                <div id=""
                                     style="position: absolute; top: 0px; left: 0px; width: 75px; height: 42px; overflow: hidden; bottom: auto; right: auto;">
                                    <?=FileUpload::widget([
                                        'model' => $fileModel,
                                        'attribute' => 'file',
                                        'url' => ['site/uploadImg'], // your url, this is just for demo purposes,
                                        'buttonClass' => 'btn btn-xs btn-default purple',
                                        'options' => [
                                            'accept' => 'image/*',
                                            'class' => 'abc',
                                            'id' => 'upload-img-2'
                                        ],
                                        'clientOptions' => [
                                            'maxFileSize' => 2000000,
                                            'autoUpload' => true,
                                        ],
                                        // Also, you can specify jQuery-File-Upload events
                                        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
                                        'clientEvents' => [
                                            'fileuploaddone' => 'function(e, data) {
                                             if(data.result.error){
                                                alert(data.result.error);
                                            }else{
                                                var pic = JSON.parse(data.result).files[0];
                                                $("#addrIdPhoto02").attr("src",pic.thumbnailUrl);
                                                $("#idcard2").val(pic.url);
                                            }

                                }',
                                            'fileuploadfail' => 'function(e, data) {

                                }',
                                        ],
                                    ]);?><label id="addrIdPhoto2"
                                                                   style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
                                </div>
                            </div>
                            <span>（点击左边图片可上传）</span> <!--<a href="javascript:;" class="examplecard">正确上传证件示例</a>--></li>
                        <li><label>&nbsp;</label>

                            <div class="text"><span id="cardImgExplain">您选择的口岸在清关环节需要使用证件。请上传证件的正面、反面各一张，并保持证件图像清晰、号码可识别、每张图片小于2M。</span>
                                <!--<a href="javascript:;" class="AddresPrivacy">隐私声明</a>--></div>
                        </li>
                        <!-- <li><label>&nbsp;</label> <input type="checkbox" id="addrSetDefault" name="addrSetDefault"
                                                          checked=""> <label for="addrSetDefault">设置为默认地址</label></li>-->
                    </ul>
                </form>
            </div>
            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                <div class="ui-dialog-buttonset">
                    <button type="button" class="ui-button-text confirm ui-button ui-corner-all ui-widget"><span
                            class="">确定</span></button>
                </div>
            </div>
        </div>
        <div id="reDia2" tabindex="-1" role="dialog" class=" dialog2 ui-dialog ui-corner-all ui-widget ui-widget-content ui-front ui-dialog-buttons ui-draggable"
             aria-describedby="addressDialog" aria-labelledby="ui-id-144"
             style="height: auto; width: 760px; margin-left: 25%; margin-top: -300px; display: none; z-index: 10002;">
            <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle"><span
                    id="ui-id-144" class="ui-dialog-title">编辑发货地址</span>
                <button type="button"
                        class="glyphicon-remove2 ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close"
                        title="Close">
                    <span style="margin-top: 12px; font-size: 20px;" class="glyphicon glyphicon-remove"></span>
                </button>
            </div>
            <div id="addressDialog" class="adDialog2 ui-dialog-content ui-widget-content"
                 style="display: block; width: auto; min-height: 558px; max-height: none; height: auto;">
                <form id="editAddressForm2" >
                    <input name="as_id" type="hidden" value="">
                    <ul class="edit-address-wrap">
                        <li><label>所在国家<b>*</b>：</label><select class="country_id" name="country_id"><option value="">请选择国家</option><?php if($country){?> <?php foreach($country as $c){ ?><option value="<?=$c['country_id']?>"><?=$c['name']?></option> <?php }} ?></select></li>
                        <li><label>地址<b>*</b>：</label> <input type="text" name="adress" class="input"
                                                                value=""
                                                                placeholder="请填写地址"></li>
                        <li><label>邮政编码<b>*</b>：</label> <input type="text" name="postcode" class="input" value=""
                                                                placeholder="填写邮编" style="width: 280px;"></li>
                        <li><label>发货人姓名<b>*</b>：</label> <input type="text" name="true_name" class="input" value=""
                                                                 style="width: 280px;"> <span
                                class="gray">（收货人姓名请务必与证件保持一致）</span></li>
                        <li><label>手机号码<b>*</b>：</label>  <input type="text" name="mob_phone"
                                                                 class="input" value=""
                    </ul>
                </form>
            </div>
            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                <div class="ui-dialog-buttonset">
                    <button type="button" class="ui-button-text2 confirm ui-button ui-corner-all ui-widget"><span
                            class="">确定</span></button>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="ui-widget-overlay ui-front" style="z-index: 10001;position: fixed;display: none;"></div>
</div>


<div class="actions actions-footer" id="WiredWizard-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm btn-prev"><i class="fa fa-angle-left"></i>上一步</button>
        <button type="button" class="btn btn-default btn-sm btn-next" data-last="提交">下一步<i
                class="fa fa-angle-right"></i></button>
    </div>
</div>
</div>
</div>


<!--弹框-->
<div tabindex="-1" id="dialog" role="dialog"
     class="ui-dialog ui-corner-all ui-widget ui-widget-content ui-front ui-draggable col-lg-6 col-sm-6 col-xs-12"
     aria-describedby="selectGoodsTypeDialog" aria-labelledby="ui-id-23"
     style="display: none;min-width:800px;height: 920px; left: 20%; top: 0px; z-index: 10002;position: absolute;">
    <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle">
        <span id="ui-id-23" class="ui-dialog-title">选择申报类别</span>
        <button type="button"
                class="ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close"
                title="Close">
            <span style="margin-top: 12px; font-size: 20px;" class="glyphicon glyphicon-remove"></span>
        </button>
    </div>
    <div id="selectGoodsTypeDialog" class="ui-dialog-content ui-widget-content goodsTypeModule"
         style=" width: auto; min-height: 900px; max-height: none; height: auto;display: block; ">
        <!--   <div class="area-block search-sblb">
               <div class="search-wrap">
                   <input class="search-input" type="text" placeholder="输入关键字搜索你要寻找的类别">
                                       <span class="search-btn">
                                         <i class="ui-icon ui-icon-search"></i>
                                       </span>
                   <div class="search-result" id="searchResultWrap"></div>
               </div>
           </div>
           <dl class="changyongleibie clearfix" id="dlchangyong">
               <dt>您的常用类别</dt>
               <dd id="commonlyUsedWrap">
                   <span class="item" catalogid="1814" data-units="[]">罐头（食品）</span>
                   <span class="item" catalogid="700" data-units="[]">婴幼儿奶粉</span></dd>
           </dl>-->
        <div class="leibie-wrap clearfix">
            <ul class="leibie-menu" id="goodsTypeMenuWrap">
                <?php if ($catalogFirst) { ?>
                    <?php foreach ($catalogFirst as $key => $catafirst) { ?>
                        <li>
                            <a href="javascript:;"
                               catalogid="<?= $catafirst['ic_id'] ?>" <?php if ($key == 0) { ?> class="active" <?php } ?>><?= $catafirst['name'] ?>
                                <span class="arrow"></span></a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <ul class="leibie-content" id="goodsTypeContWrap">
                <?php if($catalogSecondOne&&is_array($catalogSecondOne)){ ?>
                    <?php foreach ($catalogSecondOne as $cso) { ?>
                        <li class="clearfix">
                            <div class="fl" catalogid="<?=$cso['ic_id']?>"><?=$cso['name']?>
                                <span class="arrow"></span></div>
                            <div class="fr" style="width: 395px;">
                                <?php foreach($cso['thirdList'] as $c){ ?>
                                    <a href="javascript:;" class="item" catalogid="<?=$c['ic_id']?>"
                                       data-units="[]"><?=$c['name']?></a>
                                <?php } ?>
                            </div>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
