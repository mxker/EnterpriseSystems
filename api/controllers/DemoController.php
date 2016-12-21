<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/2
 * Time: 17:23
 */

namespace api\controllers;

use api\models\form\LogisticsTrackingForm;
use common\models\Parcel;
use yii\web\Controller;

class DemoController extends Controller
{
    public function actionDemo(){

        $moyun_tracking = Parcel::find()->select('tracking_code_moyun')->where([
            'express_code_domestic' => 'yunda',
            'tracking_code_domestic' => '1601011618113',
        ])->asArray()->one();

        $model_update = LogisticsTrackingForm::findOne([
            'tracking_code' => $moyun_tracking['tracking_code_moyun'],
        ]);

        if($model_update){
            $data = [];
            $data['tracking_code'] = $moyun_tracking['tracking_code_moyun'];
            $data['data'] = 'ggg';
            $res = $model_update->updateTrackings($data);

            return $res;
        }
    }
}