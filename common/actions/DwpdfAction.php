<?php
namespace common\actions;

use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\helpers\Json;
use frontend\models\Parcel;
use yii\helpers\Url;

class DwpdfAction extends Action {

    private static $CATPDFMAP = array(
      'SB' => '\common\moyun\channel\logisticspaper\Macroexpressco',
    );

    public function init() {

    }

    /**
     * Runs the action.
     */
    public function run() {
        $parcel_ids = Yii::$app->request->post('parcel_id')?Yii::$app->request->post('parcel_id'):Yii::$app->request->get('parcel_id');
        if(Yii::$app->request->get('t')&&Yii::$app->request->get('t')=='json'){
            $parcel_ids = json_decode($parcel_ids,true);
        }
        try {
            if ($parcel_ids && is_array($parcel_ids)) {
                $parcel = $this->getParcelLogisticChannel($parcel_ids[0]);
                if($parcel) {
                    $pdf_obj = new $parcel['pdfCat']();
                    $pdf_obj->get_logisticspaper($parcel_ids);
                }else{
                    throw new Exception('该渠道暂未开通面单下载！');
                }
            } else {
                throw new Exception('请选择运单后下载');
            }
        }catch (Exception $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
            Yii::$app->getResponse()->redirect(Url::to(['parcel/list']), 302);
        }

    }

    public function getParcelLogisticChannel($parcel_id){
        $session = Yii::$app->session->get('member');
        $conditon =[];
        if(isset($session['member_id'])&&$session['member_id']) {
            $conditon['my_parcel.member_id'] = $session['member_id'];
        }
        $conditon['my_parcel.parcel_id'] = $parcel_id;
        $parcelModel = new Parcel();
        $parcel = $parcelModel->getParcelDetail($conditon);
        if(array_key_exists($parcel['logisticsChannel']['code'],self::$CATPDFMAP)) {
            $parcel['pdfCat'] = self::$CATPDFMAP[$parcel['logisticsChannel']['code']];
            return $parcel;
        }else{
            return false;
        }
    }

}