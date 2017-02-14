<?php
namespace api\controllers\trackingcode;

use api\components\Action;
use common\models\LogisticsTracking;
use Yii;
use yii\helpers\Json;

class GetTrackingAction extends Action {
    public $express_code;
    public $tracking_code;

    public function run() {
        $request = Yii::$app->request;
        $params = $request->post();

        $fields = 'create_at,express_code,express_name,status_msg,state,state_txt,tracking_code,data,overseas_data';
        $getAlreadyData = LogisticsTracking::find()->select($fields)->where([
            'AND',
            ['express_code' => $params['express_code']],
            ['tracking_code' => $params['tracking_code']],
        ])->asArray()->one();

        if ($getAlreadyData) {
            //存在返回相关的物流信息
            $this->return_data['create_at'] = date('Y-m-d H:i:s', $getAlreadyData['create_at']);
            $this->return_data['express_code'] = $getAlreadyData['express_code'];
            $this->return_data['express_name'] = $getAlreadyData['express_name'];
            $this->return_data['status_msg'] = $getAlreadyData['status_msg'];
            $this->return_data['state'] = $getAlreadyData['state'];
            $this->return_data['state_txt'] = $getAlreadyData['state_txt'];
            $this->return_data['tracking_code'] = $getAlreadyData['tracking_code'];

            //合并国内段和国外段物流信息
            if($getAlreadyData['overseas_data']){
                $overseas_data = unserialize($getAlreadyData['overseas_data']);
            }else{
                $overseas_data = [];
            }
            if($getAlreadyData['data']){
                $domestic_data = unserialize($getAlreadyData['data']);
            }else{
                $domestic_data = [];
            }
            $data = array_merge($overseas_data, $domestic_data);
            $this->return_data['data'] = serialize($data);

        }else{
            //判断是否为陌云自身单号，不是便参与订阅
            $isMoyun = stristr($params['tracking_code'], 'SG');
            if(!$isMoyun){
                //将未订阅数据存入redis
                $param = [];
                $param['express_code'] = $params['express_code'];
                $param['tracking_code'] = $params['tracking_code'];

                Yii::$app->redis->RPUSH('noSubscribe', json_encode($param));
                Yii::$app->redis->EXPIRE('noSubscribe', 1800);//为值设置30分钟过期时间
            }

            $this->return_data['create_at'] = date('Y-m-d H:i:s', time());
            $this->return_data['express_code'] = '';
            $this->return_data['express_name'] = '';
            $this->return_data['status_msg'] = '';
            $this->return_data['state'] = '';
            $this->return_data['state_txt'] = '';
            $this->return_data['tracking_code'] = '';
            $this->return_data['data'] = '';
        }

        return Json::encode($this->return_data);
    }
}