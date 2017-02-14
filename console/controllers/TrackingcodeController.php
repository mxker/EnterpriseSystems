<?php

namespace console\controllers;

use common\libs\Kuai100;
use yii\console\Controller;

class TrackingcodeController extends Controller {

    /**
     * 从快递100订阅物流跟踪信息.当物流公司代码与快递单号为空时,从redis队列中的数据去快递100订阅物流信息;否则使用指定的号码订阅
     * @param string $express_code 物流公司代码
     * @param string $traking_code 快递单号
     * @return int 返回码
     */
    public function actionSubscribe($express_code = null, $traking_code = null) {
        if ($express_code === null || $traking_code = null) {

            //从redis中获取1000条未订阅的订单信息
            $paramsArray = \Yii::$app->redis->LRANGE('noSubscribe', 0, 999);

            if($paramsArray){
                $data = [];
                foreach($paramsArray as $key => $param){
                    $paramArray = json_decode($param, true);

                    $data['company'] = $paramArray['express_code'];
                    $data['number'] = $paramArray['tracking_code'];

                    $ret = Kuai100::App('json', $data)->subscribe();
                    $result = json_decode($ret, true);

                    //不等于200，订阅失败再次写入redis
                    if($result['returnCode'] != 200 && $result['returnCode'] != 501){
                        $re_param = [];
                        $re_param['express_code'] = $paramArray['express_code'];
                        $re_param['tracking_code'] = $paramArray['tracking_code'];
                        \Yii::$app->redis->RPUSH('noSubscribe', json_encode($re_param));
                        \Yii::$app->redis->EXPIRE('noSubscribe', 1800);//为值设置30分钟过期时间
                    }
                }
                usleep(500000); //脚本延迟0.5秒
            }else{
                echo '暂无需要订阅数据';
            }
        }else {

        }
        return 1;
    }
}