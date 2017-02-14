<?php
namespace common\moyun\channel\logisticspaper;
use Faker\Provider\Barcode;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Picqer\Barcode\BarcodeGeneratorJPG;
use frontend\models\Parcel;
use Yii;

/**
 * Created by transport.
 * 
 * @FileName : BaseLogisticspaper.php
 * @Author : fibst <ixiezhi@163.com>
 * @DateTime : 2016/11/25-11-25 16:14 
 */
abstract class BaseLogisticspaper {

    protected $pdf_obj;

    abstract protected function get_logisticspaper($parcels);

    protected function _createBarcode($text,$h,$w){

        $barcode_obj = new BarcodeGeneratorPNG();
        return '<div style="text-align: center"><div style="width: 100%;height: auto"><img src="data:image/png;base64,' . base64_encode($barcode_obj->getBarcode($text,'C128',$h,$w)) . '"></div><span>'.$text.'</span></div>';

    }

    protected function getParcel($parcel_id){
        $session = Yii::$app->session->get('member');
        $conditon =[];
        if(isset($session['member_id'])&&$session['member_id']) {
            $conditon['my_parcel.member_id'] = $session['member_id'];
        }
        $conditon['my_parcel.parcel_id'] = $parcel_id;
        $parcelModel = new Parcel();
        $parcel = $parcelModel->getParcelDetail($conditon);
        return $parcel;
    }
}