<?php
namespace common\actions;

use Yii;
use yii\base\Action;
use common\models\PdLog;
use common\libs\Mypay;

class PayAction extends Action {
    public function init() {

    }


    function run(){
        $host = Yii::$app->request->hostInfo;
        $mypay = new Mypay();
        $pdlogModel = new PdLog();
        $request = Yii::$app->request;
        $pdlog = $pdlogModel->find()->where(['ordersn'=>$_POST['ordersn']])->asArray()->one();
        if(!$pdlog){
            echo '订单号不存在';DIE();
        }
        if($pdlog['pay_status']==1){
            echo '该订单已支付';DIE();
        }

        //支付前查看订单是否已支付
        $parameter = array();
        $parameter['outTradeNo'] = $pdlog['ordersn'];
        $parameter['time'] = time();
        $parameter['appId'] = Mypay::APP_ID;
        $parameter['sign'] = $mypay->buildMysign($parameter,Mypay::SIGN_KEY);//生成签名

        $return = Mypay::queryOrder($parameter);
        if(isset($return['tradeStatus'])&&$return['tradeStatus'] === 'success'){
            echo '该订单已支付';DIE();
        }

        //陌云支付商户号信息
        $appId = Mypay::APP_ID;

        //支付通道获取
        if(strpos($_POST['paytype'], 'alipay') !== false){
            $channel = 'ALI_WEB'; //支付宝web支付

        }elseif(strpos($_POST['paytype'], 'wxpay') !== false){
            $channel = 'WX_NATIVE';//微信扫码支付
        }else{
            echo '支付方式不存在';DIE();
        }

        //支付数据准备
        $data = array(
            'callback' => 'jsonp',
            'appId' => $appId,
            'channel' => $channel, //支付方式
            'subject' => '商品购买支付', //商品名称
            'body' => '商品描述',
            'outTradeNo' => $pdlog['ordersn'], //订单号
            'totalFee' => $pdlog['av_amount'], //金额
            'returnUrl' => urlencode($host.'/account/index'), //同步通知地址
            'notifyUrl' => urlencode($host.'/account/paynotify'), //异步通知地址
            'outContext' => json_encode(array('payment_code'=>$channel)), //支付方式
            'uid'=>isset($_SESSION['member']['member_id'])?$_SESSION['member']['member_id']:-1,
        );


        //生成签名
        $data['sign'] = $mypay->buildMysign($data,Mypay::SIGN_KEY);

        $pay_url = Mypay::MOYUN_PAY_URL;

        $sHtml = "<form id='submit' name='submit' action='{$pay_url}' method='POST'>";
        while (list ($key, $val) = each ($data)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' style='display:none;' value='确认'></form>";

        $sHtml = $sHtml."<script>document.forms['submit'].submit();</script>";

        echo $sHtml;

    }
}
  