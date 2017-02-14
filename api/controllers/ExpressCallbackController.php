<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/24
 * Time: 17:10
 */

namespace api\controllers;

use api\models\form\ExpressForm;
use api\models\form\LogisticsTrackingForm;
use common\models\Parcel;
use Yii;
use yii\web\Controller;
use yii\helpers\Json;

class ExpressCallbackController extends Controller
{
    public function actionCallback(){
        $paramJson = Yii::$app->request->post('param');
        
        if(!isset($paramJson)){
            return Json::encode('推送接口无数据');
        }

        $paramArray = json_decode($paramJson, TRUE);
        if (!is_array($paramArray) || empty($paramArray)) {
            return Json::encode('推送数据参数不对');
        }

        $status_code = $paramArray['status'];
        $status_msg = str_replace(array('polling', 'shutdown', 'abort', 'updateall'), array('在途中', '揽件', '疑难', '签收'), $status_code);

        $state = $paramArray['lastResult']['state'];
        $state_txt = str_replace(array(0, 1, 2, 3), array('监控中', '结束', '中止', '重新推送'), $state);

        $shipping_detail = serialize($paramArray['lastResult']['data']);

        if (empty($paramArray['lastResult']['nu']) || empty($paramArray['lastResult']['com'])) {
            return Json::encode('推送信息不完整');
        }

        //通过快递公司code查询快递公司信息
        $fields = 'id,e_name';
        $expressInfo = ExpressForm::find()->select($fields)->where([
            'e_code' => $paramArray['lastResult']['com']
        ])->asArray()->one();

        //组装需要数据
        $data = [];
        $data['tracking_code'] = $paramArray['lastResult']['nu'];
        $data['express_code'] = $paramArray['lastResult']['com'];
        $data['status_code'] = $status_code;
        $data['status_msg'] = $status_msg;
        $data['state'] = $state;
        $data['state_txt'] = $state_txt;
        $data['data'] = $shipping_detail;
        $data['create_at'] = time();
        $data['express_id'] = $expressInfo['id'];
        $data['express_name'] = $expressInfo['e_name'];


        $model = LogisticsTrackingForm::findOne([
            'tracking_code' => $paramArray['lastResult']['nu'],
        ]);

        //存在国内物流端信息就更新，不存在则添加
        if($model){
            $model->editTrackings($data);
        }else{
            $model=  new LogisticsTrackingForm();
            $model->addTrackings($data);
        }

        //同时更新整个包裹的整个物流信息
        $moyun_tracking = Parcel::find()->select('tracking_code_moyun')->where([
            'express_code_domestic' => $paramArray['lastResult']['com'],
            'tracking_code_domestic' => $paramArray['lastResult']['nu'],
        ])->asArray()->one();

        $model_update = LogisticsTrackingForm::findOne([
            'tracking_code' => $moyun_tracking['tracking_code_moyun'],
        ]);
        if($model_update){
            $data = [];
            $data['tracking_code'] = $moyun_tracking['tracking_code_moyun'];
            $data['data'] = $shipping_detail;
            $model_update->updateTrackings($data);
        }

        $success = [];
        $success['result'] = true;
        $success['returnCode'] = 200;
        $success['message'] = '成功';

        return Json::encode($success);
    }
}