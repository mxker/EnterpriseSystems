<?php

namespace api\controllers\trackingcode;

use api\components\Action;
use api\models\form\LogisticsTrackingForm;
use yii\helpers\Json;

class NotifySubscribeTrackingAction extends Action
{
    /**
     * 快递单号
     * @var array[['express_code' => string, 'tracking_code' => string], ['express_code' => string, 'tracking_code' => string], ...]
     */
    public $codes;

    public function run()
    {
        if (\Yii::$app->request->post()) {

            $this->codes = json_decode(\Yii::$app->request->post('codes'),true);

            if (is_array($this->codes)) {
                foreach ($this->codes as $key => $code) {

                    if(is_array($code)){
                        //判断是否为陌云自身单号
                        $isMoyun = stristr($code['tracking_code'], 'SG');

                        //判断是否存在物流信息
                        $fields = 'create_at,express_code,express_name,status_msg,state,state_txt,tracking_code,data';
                        $getAlreadyData = LogisticsTrackingForm::find()->select($fields)->where([
                            'AND',
                            ['express_code' => $code['express_code']],
                            ['tracking_code' => $code['tracking_code']],
                        ])->asArray()->one();

                        //不是陌云单号和不存在物流，便订阅
                        if (!$isMoyun && !$getAlreadyData) {
                            $param = [];
                            $param['express_code'] = $code['express_code'];
                            $param['tracking_code'] = $code['tracking_code'];

                            \Yii::$app->redis->RPUSH('noSubscribe', json_encode($param));
                            \Yii::$app->redis->EXPIRE('noSubscribe', 1800);//为值设置30分钟过期时间
                        }
                    }else{
                        $this->return_data['code'] = 400;
                        $this->return_data['desc'] = 'false';
                        $this->return_data['message'] = '参数错误';

                        exit(json_encode($this->return_data));
                    }
                }

                return Json::encode($this->return_data);

            } else {
                $this->return_data['code'] = 400;
                $this->return_data['desc'] = 'false';
                $this->return_data['message'] = '参数错误';

                return Json::encode($this->return_data);
            }
        }
    }
}