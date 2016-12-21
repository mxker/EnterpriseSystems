<?php
use common\models\Parcel;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = '我的包裹';
$this->params['active_menu'] = 'my_parcel';
$this->params['header_titles'] = ['首页', '包裹详情'];
$css = <<<EOF
#parcelTabs{position: relative;}
#parcelTabs .absolute{position: absolute; right: 0px; top: 18px; font-size: 18px;}
#parcelTabs .absolute .ui-icons-circle-left{font-size: 14px;}
#parcelTabs .absolute a{color: #2bafff;}
#parcelTabs .absolute a:hover{text-decoration: underline;}
#parcelTabs .tabs{padding-top: 15px; border-bottom: 1px solid #dddddd;}
#parcelTabs .tabs li{float: left; padding-right: 20px;}
#parcelTabs .tabs a{font-size: 18px; text-decoration: none;}
#parcelTabs .tabs a:hover{color: #2bafff;}
#parcelTabs .ui-tabs-panel{padding: 30px 0;}

#detail li{line-height: 28px;}
#detail ul{border-radius: 5px;}

#detail .state{border: 1px solid #e6e6e6; border-radius: 5px; padding: 25px; background-color: #f5f5f5; color: #474747; font-size: 16px;}
#detail .state li{line-height: 32px;}
#detail .state .ui-icons-circle-solid-exclamation{font-size: 30px; margin-right: 5px;}
#detail .state strong{color: #8dc325; font-size: 24px;}
#detail .state .note{text-indent: 35px; color: #8c8c8c;}

#detail dl{padding-top: 20px; font-size: 13px;}
#detail dl dt{font-size: 15px; font-weight: bold; line-height: 35px;}

#detail .address{position: relative;}
#detail .address ul{padding: 0px 20px;}
#detail .address ol{position: absolute; top: 65px; right: 0;}
#detail .address ol li{float: left; padding-left: 20px;}
#detail .address ol img{width: 150px; height: 90px;}
#detail .address ol p{text-align: center;}

#detail .order ul{background-color: #f5f5f5; padding: 10px 20px;}
#detail .order li{float: left; width: 50%;}

#detail .detail table{width: 100%; table-layout: fixed;}
#detail .detail table th,
#detail .detail table td{padding: 10px; border: 1px solid #cccccc; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;}
#detail .detail table th{background-color: #e6e6e6;}

#detail .cost ul{background-color: #474747; color: #ffffff; padding: 10px 20px;}
#detail .cost li{float: left; width: 16.5%;}
#detail .cost li ,
#detail .cost li .cont{display: block; text-align: center;}
#detail .cost li .cont{font-size: 18px;}
#detail .cost li .cont.last{color: #fa5805;}
#detail  ul, ol {
    list-style: none;
}
#trace ul, ol {
    list-style: none;
}
#trace ul{padding-bottom: 20px; font-size: 15px;}
#trace ul li{float: left; width: 33%;}
#trace table{width: 100%; table-layout: fixed;}
#trace table th,
#trace table td{padding: 10px; border: 1px solid #d8d8d8;}
#trace table th{background-color: #e4e4e4; color: #333333;}


#myPhotoListWrap{padding: 0 20px;}
#myPhotoListWrap img{display: block; vertical-align: top;}
#myPhotoListWrap .loading-center{text-align: center; line-height: 300px; font-size: 18px; color: #999999;}
#myPhotoListWrap .image-box{border: 1px solid #019fe8;}
#myPhotoListWrap .image-box img{width: 100%;}
#myPhotoListWrap ul.image-btn{margin-left: -15px; padding-top: 15px;}
#myPhotoListWrap ul.image-btn li{float: left; width: 100px; padding-left: 15px; text-align: center; cursor: pointer;}
#myPhotoListWrap ul.image-btn li img{width: 96px; border: 2px solid #ffffff;}
#myPhotoListWrap ul.image-btn li.active img{border-color: #019fe8;}
.ellipsis {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
li {
    display: list-item;
    text-align: -webkit-match-parent;
}
#trace ul li {
    float: left;
    width: 25%;
}
EOF;
$this->registerCss($css)
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs nav-justified" id="myTab5">
                <li class="active">
                    <a data-toggle="tab" href="#home5">
                        包裹详情
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#profile5">
                        物流轨迹
                    </a>
                </li>

            </ul>

            <div class="tab-content">
                <div id="home5" class="tab-pane in active">
                    <div id="detail">
                        <!--包裹状态-->
                        <ul class="state">
                            <li><span class="glyphicon glyphicon-info-sign middle"></span><span class="middle">
                            当前状态：<strong><?=Parcel::$STATUS['parcel_status'][$parcel['parcel_status']].','.Parcel::$STATUS['shipping_status'][$parcel['shipping_status']]?></strong></span>
                            </li>
                          <!--  <li class="note">
                                包裹正在送往海外仓库途中，请继续保持关注！</li>-->
                        </ul>
                        <!--国内收货地址-->
                        <dl class="address">
                            <dt>收货地址</dt>
                            <dd>
                                <ul>
                                    <li><span class="">收货姓名：</span> <span class="cont">
                                    <?=$parcel['addrReceiver']['true_name']?></span> </li>
                                    <li><span class="" style="display: inline-block;">详细地址：</span> <span class="cont"
                                                                                                              style="display: inline-block; word-break: break-all; width: 400px; display: inline-block;
                                    vertical-align: top;">
                                    <?=$parcel['addrReceiver']['area_info']?><?=$parcel['addrReceiver']['adress']?></span> </li>
                                    <li><span class="">邮政编码：</span> <span class="cont">
                                    <?=$parcel['addrReceiver']['postcode']?></span> </li>
                                    <li><span class="">身份证号：</span> <span class="cont">
                                    <?=substr($parcel['addrReceiver']['idcard_number'], 0, 4).'********'.substr($parcel['addrReceiver']['idcard_number'], 14)?></span> </li>
                                    <li><span class="">手机号码：</span> <span class="cont">
                                    <?=substr($parcel['addrReceiver']['mob_phone'], 0, 4).'****'.substr($parcel['addrReceiver']['mob_phone'], 8)?></span> </li>
                                </ul>
                                <ol class="clearfix">
                                    <li>
                                        <p>
                                            <img src="<?=Yii::$app->params['upload_static_url'].$parcel['idcard1']?>" id="imgIdCardFile" alt="证件正面" /></p>
                                        <p id="pIdCardFile">
                                            证件1</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="<?=Yii::$app->params['upload_static_url'].$parcel['idcard2']?>" id="imgIdCardFileEX" alt="证件背面" /></p>
                                        <p id="pIdCardFileEX">
                                            证件2</p>
                                    </li>
                                </ol>
                            </dd>
                        </dl>

                        <dl class="address">
                            <dt>发货地址</dt>
                            <dd>
                                <ul>
                                    <li><span class="">发货人姓名：</span> <span class="cont">
                                    <?=$parcel['addrSender']['name']?></span> </li>
                                    <li><span class="" style="display: inline-block;">详细地址：</span> <span class="cont" style="display: inline-block; word-break: break-all; width: 400px; display: inline-block;vertical-align: top;">
                                    <?=$parcel['addrSender']['country'].$parcel['addrSender']['adress']?></span> </li>
                                    <li><span class="">邮政编码：</span> <span class="cont">
                                    <?=$parcel['addrSender']['postcode']?></span> </li>
                                    <li><span class="">手机号码：</span> <span class="cont">
                                    <?=substr($parcel['addrSender']['mob_phone'], 0, 4).'****'.substr($parcel['addrSender']['mob_phone'], 8)?></span> </li>
                                </ul>
                            </dd>
                        </dl>
                        <!--订单信息-->
                        <dl class="order">
                            <dt>订单信息</dt>
                            <dd>
                                <ul class="clearfix">
                                    <li><span class="">订单号：</span> <span class="cont">
                                    <?php if($parcel['order_id']){ echo $parcel['order_id'];}else{
                                        echo '暂无';
                                    }?></span> </li>
                                    <li><span class="">转运仓库：</span> <span class="cont">
                                    <?=$parcel['storehouse']['name']?></span> </li>
                                    <li><span class="">陌云运单号：</span> <span class="cont">
                                    <?=$parcel['tracking_code_moyun']?></span> </li>
                                  <!--  <li><span class="">终端派送号：</span> <span class="cont">
                                    暂无</span> </li>-->
                                    <li><span class="">派送渠道：</span> <span class="cont">
                                    <?=$parcel['logisticsChannel']['name']?></span> </li>
                                    <li><span class="">国内快递单号：</span> <span class="cont">
                                    <?php if($parcel['tracking_code_domestic']){ echo $parcel['tracking_code_domestic'];}else{
                                        echo '暂无';
                                    }?></span> </li>
                                    <li><span class="">添加时间：</span> <span class="cont">
                                    <?=date('Y-m-d H:i',$parcel['ptime'])?></span> </li>
                                   <!-- <li><span class="">申报金额：</span> <span class="cont">
                                    20.00（美金）</span> </li>
                                    <li><span class="">备注信息：</span> <span class="cont">
                                    暂无</span> </li>-->
                                    <li><span id="spViewPhoto" class="link viewMyPhoto" style="display:none;">查看照片</span> </li>
                                </ul>
                            </dd>
                        </dl>
                        <!--包裹详情-->
                        <dl class="detail">
                            <dt>包裹详情</dt>
                            <dd>
                                <table>
                                    <tr>
                                   <!--     <th style="width: 25%">
                                            商家物流号
                                        </th>-->
                                        <th style="width: 10%">
                                            商品类别
                                        </th>
                                        <th style="width: 25%">
                                            商品名称
                                        </th>
                                        <th style="width: 12%">
                                            单价（人民币）
                                        </th>
                                        <th style="width: 8%">
                                            数量
                                        </th>
                                       <!-- <th style="width: 8%">
                                            入库重量
                                        </th>
                                        <th style="width: 12%">
                                            总价（美金）
                                        </th>-->
                                    </tr>
                                    <?php if($parcel['parcelGoods']){ foreach($parcel['parcelGoods'] as $goods){ ?>
                                    <tr class="odd"><td title='<?=$goods['importCatalog']['name']?>'><?=$goods['importCatalog']['name']?></td><td title='<?=$goods['parcel_descript']?>'><span><?=$goods['parcel_descript']?></span></td><td><?=$goods['unit_price']?></td><td><?=$goods['parcel_num']?></td><!--<td rowspan="1">0.0</td><td >20.00</td>--></tr>
                                    <?php }} ?>
                                </table>
                            </dd>
                        </dl>
                        <!--费用详情-->
                        <dl class="cost">
                            <dt>费用详情</dt>
                            <dd>
                                <ul class="clearfix">
                                    <li><span class="">上报重量</span> <span class="cont">
                                    <?php if($parcel['weight_m']!=0){ echo $parcel['weight_m']; }else{ ?>（待称重）<?php } ?></span> </li>
                                    <li><span class="">真实重量</span> <span class="cont">
                                    <?php if($parcel['weight_p']!=0){ echo $parcel['weight_p']; }else{ ?>（待称重）<?php } ?></span> </li>
                                    <li><span class="">转运费</span> <span class="cont">
                                    <?php if($parcel['shipping_price']!=0){ echo '￥'.$parcel['shipping_price']; }else{ ?>（待称重）<?php } ?></span> </li>
                                    <li><span class="">税费</span> <span class="cont">
                                    <?php if($parcel['tariff_price']!=0){ echo '￥'.$parcel['tariff_price']; }else{ ?>（待确定）<?php } ?></span> </li>
                                    <li><span class="">合计费用</span> <span class="cont last">
                                    <?php if($parcel['tariff_price']!=0&&$parcel['shipping_price']!=0){ echo '￥'.sprintf('%.2f',$parcel['tariff_price']+$parcel['shipping_price']); }else{ ?>（待确定）<?php } ?></span> </li>
                                </ul>
                            </dd>
                        </dl>
                    </div>

                </div>

                <div id="profile5" class="tab-pane">
                    <div id="trace">
                        <ul class="clearfix">
                            <li class="ellipsis"><span class="">订单号：</span> <span class="cont">
                            待生成</span> </li>
                            <li class="ellipsis"><span class="">转运仓库：</span> <span class="cont">
                            <?=$parcel['storehouse']['name']?></span> </li>
                            <li class="ellipsis"><span class="">陌云物流号：</span> <span class="cont">
                            <?=$parcel['tracking_code_moyun']?></span> </li>
                            <li class="ellipsis"><span class="">国内快递单号：</span> <span class="cont">
                            <?php if($parcel['tracking_code_domestic']){ echo $parcel['tracking_code_domestic'];}else{
                                echo '暂无';
                            }?></span>
                            </li>
                        </ul>
                        <table>
                            <tr>
                                <th style="width: 20%;">
                                    时间（北京）
                                </th>
                                <th style="width: 80%;">
                                    国外物流追踪
                                </th>
                            </tr>
                            <?php if($overseas_data){ foreach($overseas_data as $oversea_data){ ?>
                            <tr>
                                <td>
                                    <?=$oversea_data['time']?>
                                </td>
                                <td>
                                    <?=$oversea_data['context']?>
                                </td>
                            </tr>
                            <?php }}?>
                        </table>
                        <hr>
                        <table style="margin-top: 0px;">
                            <tr>
                                <th style="width: 20%;">
                                    时间（北京）
                                </th>
                                <th style="width: 80%;">
                                    国内物流追踪
                                </th>
                            </tr>

                            <?php if($data){ foreach($data as $da){ ?>
                            <tr>
                                <td>
                                    <?=$da['ftime']?>
                                </td>
                                <td>
                                    <?=$da['context']?>
                                </td>
                            </tr>
                            <?php }} ?>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

