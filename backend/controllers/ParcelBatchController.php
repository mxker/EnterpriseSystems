<?php

namespace backend\controllers;
use \backend\components\Controller;
use backend\models\Parcel;
use \backend\models\ParcelBatch;
use \backend\models\ParcelOverseasStatus;
use \backend\models\Storehouse;
use \common\models\Country;
use \common\models\LogisticsChannel;
use common\models\LogisticsTracking;
use common\models\ChannelDomestic;
use yii\data\Pagination;
use Yii;

class ParcelBatchController extends Controller {
    public function actionAdd() {
        return $this->render('add');
    }

    public function actionDel() {
        return $this->render('del');
    }

    public function actionEdit() {
        $parcelModel = new Parcel();
        $pacelBatchModel = new ParcelBatch();
        $parcelOverseasStatusModel = new ParcelOverseasStatus();
        $parcelOverseasStatus = $parcelOverseasStatusModel->find()->asArray()->all();
        $storeHouseModel = new Storehouse();
        $countryModel = new Country();
        $country = $countryModel->find()->asArray()->all();
        if($country) {
            foreach ($country as $key => &$val) {
                $storeHouse = $storeHouseModel->find()->where(['country_id' => $val['country_id']])->asArray()->all();
                if ($storeHouse) {
                    $val['storehouse'] = $storeHouse;
                } else {
                    unset($country[$key]);
                }
            }
        }
        $pb_id = Yii::$app->request->get('pb_id')?Yii::$app->request->get('pb_id'):Yii::$app->request->post('pb_id');
        $parcelBitch = $pacelBatchModel->getParcelBitch($pb_id);
        $parcels =  $parcelModel->find()->select('parcel_id,tracking_code_moyun,logistics_channel_id')->where(['parcel_batch_id'=>$pb_id])->asArray()->all();
        if($data = Yii::$app->request->post()){
            unset($data['_csrf']);
            foreach($data as $k=>$d){
                $parcelBitch ->$k = $d;
            }
            if($parcelBitch->save()){
                foreach($parcels as $parcel) {
                    if ($data['parcel_overseas_status_id']) {
                        $parcelModel->updateAll(['parcel_overseas_status_id'=>$data['parcel_overseas_status_id']],['parcel_id'=>$parcel['parcel_id']]);
                        $parcelOverseasStatusText = $parcelOverseasStatusModel->find()->where(['pos_id'=>$data['parcel_overseas_status_id']])->asArray()->one();
                        $overseas_data = array('context' => $parcelOverseasStatusText['name'], 'time' => date('Y-m-d H:i:s',time()),'ftime'=>date('Y-m-d H:i:s',time()));
                    }
                    $ltModel = new LogisticsTracking();
                    //$cdModel = new ChannelDomestic();
                    //$lcModel        = new LogisticsChannel();
                    $ltObj = $ltModel->find()->where(['tracking_code'=>$parcel['tracking_code_moyun']])->one();
                    //$lc = $lcModel->find()->where(['lc_id'=>$parcel['logistics_channel_id']])->asArray()->one();
                    //$cd = $cdModel->find()->where(['cd_id'=>$lc['channel_domestic_id']])->asArray()->one();
                    if($ltObj){
                        $now = unserialize($ltObj->overseas_data);
                        $now[] = $overseas_data;
                        $ltObj->overseas_data = serialize($now);
                    }else{
                        unset($ltObj);
                        $ltObj = new LogisticsTracking();
                        $ltObj->express_id =0;
                        $ltObj->express_name ='SuperB-Grace';
                        $ltObj->tracking_code = $parcel['tracking_code_moyun'];
                        $ltObj->express_code = 'SG';
                        $ltObj->create_at = time();
                        $ltObj->overseas_data = serialize(array($overseas_data));
                    }
                    $ltObj->save();
                }
                Yii::$app->session->setFlash('success', '修改成功.');
            }else{
                Yii::$app->session->setFlash('error', '修改失败.');
            }
            return $this->redirect(['parcel-batch/list']);
        }
        return $this->render('edit',['parcelBitch'=>$parcelBitch->toArray(),'parcels'=>$parcels,'country'=>$country,'parcelOverseasStatus'=>$parcelOverseasStatus]);
    }

    public function actionList() {
        $parcelBatchModel = new ParcelBatch();
        $conditon = [];
        if(Yii::$app->request->get('code')){
            $conditon['my_parcel_batch.code'] = Yii::$app->request->get('code');
        }
        $data = $parcelBatchModel::find();
        $pages = new Pagination(['totalCount' =>$data->where($conditon)->count(), 'pageSize' => '50']);    //实例化分页类,带上参数(总条数,每页显示条数)
        $batchlist =  $parcelBatchModel->getParcelBatchListist('*',$conditon,$pages);
        return $this->render('list',['list'=>$batchlist,'pages'=>$pages]);
    }


}
