<?php
namespace common\actions;

use Yii;
use yii\base\Action;
use common\models\PdLog;
use common\libs\Mypay;
use common\models\Member;

class PayNotifyAction extends Action {
    public function init() {

    }

    function run(){
        $ordersn = $_POST['out_trade_no']; //系统支付流水
        $pdlogModel = new PdLog();
        $request = Yii::$app->request;
        $pdlog = $pdlogModel->find()->where(['ordersn'=>$ordersn])->one();
        if($pdlog->pay_status==1){
            echo 'success';
        }else {
            $pdlog->pay_status = 1;
            if ($pdlog->save()) {
                if($pdlog->pl_type==1){
                    $memberModel = new Member();
                    $member=$memberModel->find()->where(['member_id'=>$pdlog->member_id])->one();
                    $member->available_predeposits += floatval($pdlog->av_amount);
                    if($member->save()){
                        echo 'success';
                    }
                }
            }
        }
    }
}