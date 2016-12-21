<?php

namespace backend\controllers;
use backend\components\Controller;
use backend\models\Parcel;
use backend\models\ParcelBatch;
use common\models\Country;
use backend\models\form\ChannelDomesticForm;
use common\models\Storehouse;
use common\models\LogisticsChannel;
use common\models\ImportCatalog;
use common\models\StorehouseStatus;
use backend\models\ParcelOverseasStatus;
use common\models\AddrSender;
use common\models\AddrReciver;
use common\models\ParcelCommon;
use yii\data\Pagination;
use Yii;
use yii\db\Exception;
use common\models\ParcelIssue;
use common\models\BatchImport;

class ParcelController extends Controller {
    public function actions() {
        return [
            'dwpdf' => [
                'class' => 'common\actions\DwpdfAction',
            ],
            'export_excel' => [
                'class' => 'common\actions\ExportExcelAction',
            ],
        ];
    }

    public function actionIn() {
        return $this->render('in');
    }

    public function actionList() {
        $ParcelModel = new Parcel();
        $conditon =[];
        $conditon2=[];
        $shipping_status = Yii::$app->request->get('shipping_status')?Yii::$app->request->get('shipping_status'):0;
        $parcel_status = Yii::$app->request->get('parcel_status')?Yii::$app->request->get('parcel_status'):0;
        if(Yii::$app->request->get('code')){
            $conditon['my_parcel_batch.code'] = Yii::$app->request->get('code');
        }
        if($shipping_status!=70) {
            if(Yii::$app->request->get('tracking_code_moyun')){
                $conditon['my_parcel.tracking_code_moyun'] = Yii::$app->request->get('tracking_code_moyun');
            }
            if(Yii::$app->request->get('goods_name')) {
                $conditon2 = ['like','my_parcel.goods_name', Yii::$app->request->get('goods_name')]; //name LIKE '%tester%'
            }
            if($parcel_status>0||$shipping_status>0) {
                if($parcel_status>0){
                    $conditon['my_parcel.parcel_status'] = $parcel_status;
                }
                if($shipping_status>0) {
                    $conditon['my_parcel.shipping_status'] = $shipping_status;
                }
                $state = 1;
            }else{
                $state = 0;
            }
            $data = $ParcelModel::find();
            $pages = new Pagination(['totalCount' =>$data->joinWith('parcelGoods')->joinWith('parcelCommon')->joinWith('parcelBatch')->joinWith('logisticsChannel')->joinWith('storehouse')->where($conditon)->andwhere($conditon2)->count(), 'pageSize' => '50']);    //实例化分页类,带上参数(总条数,每页显示条数)
            $list = $ParcelModel->getParcelList('*',$conditon,$pages,$conditon2);
            foreach($list as &$li){
                $li['addrReceiver'] = unserialize($li['receiver_info']);
                $li['addrSender'] = unserialize($li['sender_info']);
            }
        }else{
            $BatchImportModel = new BatchImport();
            $data = $BatchImportModel::find();
            //时间搜索的特殊处理
            if (Yii::$app->request->get('start_time') && Yii::$app->request->get('end_time')) {
                $start_time = strtotime(Yii::$app->request->get('start_time'));
                $end_time = strtotime(Yii::$app->request->get('end_time'));
                $pages = new Pagination(['totalCount' => $data->where([
                    'AND',
                    $conditon,
                    ['between', 'create_at', $start_time, $end_time],
                ])->count(), 'pageSize' => '50']);    //实例化分页类,带上参数(总条数,每页显示条数)
                $conditon = ['AND', $conditon, ['between', 'create_at', $start_time, $end_time]];
            } else {
                $pages = new Pagination(['totalCount' => $data->where($conditon)->count(), 'pageSize' => '50']);    //实例化分页类,带上参数(总条数,每页显示条数)
            }
            $list = $BatchImportModel->find()->where($conditon)->offset($pages->offset)->limit($pages->limit)->orderBy('create_at desc')->asArray()->all();
//            foreach($list as &$l){
//                $l['parcel_ids'] = json_decode($l['parcel_ids'],true);
//            }
            $state = 1;
        }
        return $this->render('list',[
            'model' => $ParcelModel,
            'pages' => $pages,
            'list' =>$list,
            'shipping_status' =>$shipping_status,
            'parcel_status' =>$parcel_status,
            'state' =>$state,
        ]);
    }

    public function actionDel(){
        $parcelModel = new Parcel();
        if(Yii::$app->request->get('id')){
            $result = $parcelModel->deleteParcel(Yii::$app->request->get('id'));
            if($result){
                Yii::$app->session->setFlash('success', '删除成功.');
            }else{
                Yii::$app->session->setFlash('error', '删除失败.');

            }
            echo"<script>history.go(-1);</script>";
        }else{
            throw new \yii\base\Exception('参数错误!');
        }
    }

    public function actionEdit(){
        $parcelModel = new Parcel();
        if(Yii::$app->request->post()){
            if($parcelModel->saveParcel(Yii::$app->request->post())){
                Yii::$app->session->setFlash('success', '修改成功.');
            }else{
                Yii::$app->session->setFlash('error', '修改失败.');
            }
            echo"<script>history.go(-1);</script>";
        }
        if(Yii::$app->request->get('id')){
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
            $model = new ChannelDomesticForm();
            $channelDomestic = $model::find()->select('*')->asArray()->all();
            $parcelOverseasStatusModel = new ParcelOverseasStatus();
            $parcelOverseasStatus = $parcelOverseasStatusModel->find()->asArray()->all();
            $logisticsChannelModel = new LogisticsChannel();
            $logistics_channel = $logisticsChannelModel->find()->asArray()->all();
            //商品分类列表
            $catalogModel = new ImportCatalog();
            $catalogFirst = $catalogModel->getFirstCataLog();
            //获取默认显示的第一个第二级
            $catalogSecondOne = $this->getThirdCataList($catalogFirst[0]['ic_id']);
            $fileModel = new \yii\base\DynamicModel(['file']);
            $parcel = $parcelModel->getParcelAll(['my_parcel.parcel_id'=>Yii::$app->request->get('id')]);
            $parcel['addrReceiver'] = unserialize($parcel['receiver_info']);
            $parcel['addrSender'] = unserialize($parcel['sender_info']);
        }else{
            throw new \yii\base\Exception('参数错误!');
        }
        return $this->render('edit',['parcel'=>$parcel,'channelDomestic'=>$channelDomestic,'fileModel'=>$fileModel,'catalogFirst'=>$catalogFirst,'catalogSecondOne'=>$catalogSecondOne,'logistics_channel'=>$logistics_channel,'country'=>$country,'parcelOverseasStatus'=>$parcelOverseasStatus]);
    }

    //获取第一级分类后面的子元素
    public function getThirdCataList($fi_ic_id){
        $catalogModel = new ImportCatalog();
        $catalogSecondOne = $catalogModel->find()->where(['parent_id'=>$fi_ic_id])->asArray()->all();
        foreach($catalogSecondOne as $key=>$catase){
            $catalogThird = $catalogModel->find()->where(['parent_id'=>$catase['ic_id']])->asArray()->all();
            if($catalogThird) {
                $catalogSecondOne[$key]['thirdList'] = $catalogThird;
            }else{
                $catalogSecondOne[$key]['thirdList'] = array('0'=>$catase);
            }
        }
        return $catalogSecondOne;
    }

    public function actionGettclist(){
        if (Yii::$app->request->isAjax) {
            $ret = [];
            $data = Yii::$app->request->post();
            if($data['ic_id']){
                $catalogSecondOne = $this->getThirdCataList($data['ic_id']);
                $ret['message'] = 'success';
                $ret['data'] = $catalogSecondOne;
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;

            }
            return json_encode($ret);
        }
    }

    public function actionOut() {
        $storeHouseModel = new Storehouse();
        $storeHouse = $storeHouseModel->find()->asArray()->all();
        return $this->render('out',['storehouses'=>$storeHouse]);
    }

    public function actionGetParcleByWaybill(){
        if (Yii::$app->request->isAjax) {
            $parcelModel = new Parcel();
            $ret = [];
            $data = Yii::$app->request->post();
            $con['my_parcel.tracking_code_moyun'] = $data['waybill'];
            $parcel = $parcelModel->getParcel($con);
            if($parcel){
                if($parcel['shipping_status']==10) {
                    $ret['message'] = 'success';
                    $ret['data'] = $parcel;
                    $ret['code'] = 200;
                }else{
                    $ret['message'] = '该包裹已入库';
                    $ret['code'] = 100;
                }
            }else{
                $ret['message'] = '该包裹不存在';
                $ret['code'] = 100;

            }
            return json_encode($ret);
        }
    }

    public function actionUpdateParcleWeight(){
        if (Yii::$app->request->isAjax) {
            $parcelModel = new Parcel();
            $ret = [];
            $data = Yii::$app->request->post();
            $shipping_price = $this->getShippingPrice($data['parcel_id'],$data['weight_p']);
            if(is_array($shipping_price)){
                $ret['message'] = $shipping_price['msg'];
                $ret['code'] = 100;
                return json_encode($ret);
            }
            $con['parcel_id'] = $data['parcel_id'];
            $con['shipping_status'] = 10;
            $pam['weight_p'] = $data['weight_p'];
            $pam['shipping_status'] = 20;
            $pam['in_at'] = time();
            $pam['shipping_price'] = $shipping_price;
            $parcel = $parcelModel->updateParcel($con,$pam);
            if($parcel){
                $ret['message'] = 'success';
                $ret['data'] = $parcel;
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;

            }
            return json_encode($ret);
        }
    }

    public function actionUpdateParcleIssue(){
        if (Yii::$app->request->isAjax) {
            $parcelModel = new Parcel();
            $parcelIssue = new ParcelIssue();
            $data = Yii::$app->request->post();
            $ret = [];
            if($data['is_issue']==0){
                $con['parcel_id'] = $data['parcel_id'];
                $pam['parcel_issue_id'] = 0;
                $pam['is_issue'] = 0;
                $pam['issue_remark'] = '';
                $pam['issue_at'] = 0;
                $parcel = $parcelModel->updateParcel($con,$pam);
           }else{
                $parcelIssue ->remark = $data['issue_remark'];
                $parcelIssue ->save();
                $con['parcel_id'] = $data['parcel_id'];
                $pam['parcel_issue_id'] = $parcelIssue->pi_id;
                $pam['issue_remark'] = $data['issue_remark'];
                $pam['issue_at'] = time();
                $pam['is_issue'] = 1;
                $parcel = $parcelModel->updateParcel($con,$pam);
            }
            if($parcel){
                $ret['message'] = 'success';
                $ret['data'] = $parcel;
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;

            }
            return json_encode($ret);
        }
    }

    public function getShippingPrice($parcel_id,$weight){
        $parcelModel = new Parcel();
        $parcelWeight = $parcelModel->getParcelWeight($parcel_id);
        $rules = json_decode($parcelWeight['billing_rules'],true);
        if(!$rules){
            return ['msg'=>'请先设置好该渠道运费计算变量','code'=>'fail'];
        }
        $rules['first_weight_unit'] = $rules['first_weight_unit']==0?1:$rules['first_weight_unit'];
        $rules['second_weight_unit'] = $rules['second_weight_unit']==0?1:$rules['second_weight_unit'];
        $shipping_price=0;
        switch ($weight)
        {
            case $weight<=$rules['start_weight']:
                $shipping_price = $rules['start_fee'];
                break;
            case $rules['start_weight']<$weight&&$weight<=$rules['first_weight']:
                $shipping_price = floatval($rules['start_fee']) + (($weight-$rules['start_weight'])/$rules['first_weight_unit'])*$rules['first_fee'];
                break;
            case $rules['first_weight']<$weight&&$weight<=$rules['second_weight']:
                $shipping_price = floatval($rules['start_fee']) + (($rules['first_weight']-$rules['start_weight'])/$rules['first_weight_unit'])*$rules['first_fee']+(($weight-$rules['first_weight'])/$rules['second_weight_unit'])*$rules['second_fee'];
            default:
               $shipping_price = floatval($rules['start_fee']) + (($rules['first_weight']-$rules['start_weight'])/$rules['first_weight_unit'])*$rules['first_fee']+(($weight-$rules['first_weight'])/$rules['second_weight_unit'])*$rules['second_fee'];
            //$shipping_price=-1; //表示超过最大重量

        }
       return $shipping_price;
    }

    public function actionGetParcleBatchList(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $parcelBatchModel = new ParcelBatch();
            $parcelBatchList = $parcelBatchModel->getParcelBatchList();
            if($parcelBatchList){
                $ret['message'] = 'success';
                $ret['data'] = $parcelBatchList;
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;

            }
            return json_encode($ret);
        }
    }

    public function actionAddParcelBatch(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $parcelBatchModel = new ParcelBatch();
            $ex =  $parcelBatchModel->find()->where($data)->one();
            if(!$ex) {
                $data['create_at'] = time();
                $parcelBatchList = $parcelBatchModel->addParclBacth($data);
                if ($parcelBatchList) {
                    $ret['message'] = 'success';
                    $ret['data'] = $parcelBatchList;
                    $ret['code'] = 200;
                } else {
                    $ret['message'] = '添加失败';
                    $ret['code'] = 100;

                }
            }else{
                $ret['message'] = '该批次号已经存在';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }

    }

    public function actionParcelOut(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $parcelModel = new Parcel();
            //查找该批次是否存在同一收货人
            $ex =  $parcelModel->find()->joinWith('parcelCommon')->where(['tracking_code_moyun'=>$data['tracking_code_moyun']])->one();
            $ret=[];
            if($ex) {
                if(isset($data['type'])&&$data['type'] != 'add'){
                    if ($ex->shipping_status > 10) {
                        $sql = "update my_parcel set parcel_batch_id = 0 where parcel_batch_id = {$data['parcel_batch_id']}";
                        $effectRows = Yii::$app->db->createCommand($sql)->execute();
                        $ex->shipping_status = 30;
                        $ex->parcel_batch_id = $data['parcel_batch_id'];
                        $ex->out_at = time();
                        if ($ex->save()) {
                            $ret['message'] = 'success';
                            $ret['data'] = $ex->toArray();
                            $ret['code'] = 200;
                        } else {
                            $ret['message'] = '添加失败';
                            $ret['code'] = 100;
                        }
                    } else {
                        $ret['message'] = '该运单号还未入库';
                        $ret['code'] = 100;
                    }


                }else {
                    $exarray = $parcelModel->find()->joinWith('parcelCommon')->where(['tracking_code_moyun' => $data['tracking_code_moyun']])->asArray()->one();;
                    if (!empty($exarray) && is_array($exarray)) {
                        $is_receiver = $parcelModel->find()->joinWith('parcelCommon')->where(['my_parcel.parcel_batch_id'=>$data['parcel_batch_id'],'my_parcel_common.r_true_name' => $exarray['parcelCommon']['r_true_name'], 'my_parcel_common.r_idcardnum' => $exarray['parcelCommon']['r_idcardnum']])->andWhere(['<>', 'my_parcel.tracking_code_moyun', $data['tracking_code_moyun']])->one();
                        if ($is_receiver) {
                            $re = $ex->toArray();
                            $re['parcel_batch_id'] = $data['parcel_batch_id'];
                            $ret['message']['p'] = '重复收货人:'.$exarray['parcelCommon']['r_true_name'];
                            $ret['message']['n'] = '运单号:'.$is_receiver->tracking_code_moyun;
                            $ret['data'] = $re;
                            $ret['code'] = 400;
                            return json_encode($ret);
                        }
                    }
                    if ($ex->parcel_batch_id && $data['type'] == 'add') {
                        $re = $ex->toArray();
                        $re['parcel_batch_id'] = $data['parcel_batch_id'];
                        $ret['message'] = '该运单号已经绑定批次';
                        $ret['data'] = $re;
                        $ret['code'] = 300;
                    } else {

                        if ($ex->shipping_status > 10) {
                            $ex->shipping_status = 30;
                            $ex->parcel_batch_id = $data['parcel_batch_id'];
                            $ex->out_at = time();
                            if ($ex->save()) {
                                $ret['message'] = 'success';
                                $ret['data'] = $ex->toArray();
                                $ret['code'] = 200;
                            } else {
                                $ret['message'] = '添加失败';
                                $ret['code'] = 100;
                            }
                        } else {
                            $ret['message'] = '该运单号还未入库';
                            $ret['code'] = 100;
                        }
                    }
                }
            }else{
                $ret['message'] = '该运单号不存在';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }
    }

    public function actionGetSenderAddress(){
        if (Yii::$app->request->isAjax) {
            $ret = [];
            $data = Yii::$app->request->post();
            if($data['parcel_id']){
                $parcelCommonModel = new ParcelCommon();
                $parcelCommon = $parcelCommonModel->find()->where(['parcel_id'=>$data['parcel_id']])->asArray()->one();
                $ret['message'] = 'success';
                $ret['data'] = unserialize($parcelCommon['sender_info']);
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }

    }

    public function actionGetReceiverAddress(){
        if (Yii::$app->request->isAjax) {
            $ret = [];
            $data = Yii::$app->request->post();
            if($data['parcel_id']){
                $parcelCommonModel = new ParcelCommon();
                $parcelCommon = $parcelCommonModel->find()->where(['parcel_id'=>$data['parcel_id']])->asArray()->one();
                $ret['message'] = 'success';
                $ret['data'] = unserialize($parcelCommon['receiver_info']);
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }

    }

    public function actionModifyAddress(){
        if (Yii::$app->request->isAjax) {
            $ret = [];
            $data = Yii::$app->request->post();
            $parcelCommonModel = new ParcelCommon();
            $addrReciver['area_info'] = $data['area_info'];
            $addrReciver['adress'] = $data['adress'];
            $addrReciver['postcode'] = $data['postcode'];
            $addrReciver['true_name'] = $data['true_name'];
            $addrReciver['mob_phone'] = $data['mob_phone'];
            $addrReciver['idcard_number'] = $data['idcard_number'];
            $addrReciver['idcard_photo'] = $data['idcard'];
            $r_true_name = isset($data['addrReceiver']['true_name'])?$data['addrReceiver']['true_name']:'';
            $r_idcardnum = isset($data['addrReceiver']['idcard_number'])?$data['addrReceiver']['idcard_number']:'';
            if($parcelCommonModel ->updateAll(['receiver_info'=>serialize($addrReciver),'r_true_name'=>$r_true_name,'r_idcardnum'=>$r_idcardnum],['parcel_id'=>$data['parcel_id']])){
                $ret['message'] = 'success';
                $ret['data'] = $data;
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }

    }
    public function actionModifySendAddress(){
        if (Yii::$app->request->isAjax) {
            $countryModel = new Country();
            $ret = [];
            $data = Yii::$app->request->post();
            $parcelCommonModel = new ParcelCommon();
            $country = $countryModel -> find()->where(['country_id'=>$data['country_id']])->one();
            $AddrSender['city'] = $data['city'];
            $AddrSender['adress'] = $data['adress'];
            $AddrSender['postcode'] = $data['postcode'];
            $AddrSender['name'] = $data['name'];
            $AddrSender['mob_phone'] = $data['mob_phone'];
            if($country) {
                $AddrSender['country_id'] = $data['country_id'];
                $AddrSender['country'] = $country['name'];
            }

            if($parcelCommonModel ->updateAll(['sender_info'=>serialize($AddrSender)],['parcel_id'=>$data['parcel_id']])){
                $ret['message'] = 'success';
                $ret['data'] = $data;
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }

    }

    public function actionGetHouseOverstate(){
        if (Yii::$app->request->isAjax) {
            $sModel = new StorehouseStatus();
            $ret = [];
            $data = Yii::$app->request->post();
            if($data['sid']){
                $data = $sModel->getStorehouseStatus($data['sid']);
                $ret['message'] = 'success';
                $ret['data'] = $data;
                $ret['code'] = 200;
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }
    }

    public function actionImportIn(){
        $parcelModel = new Parcel();
        $file = $_FILES;//获取上传的文件实例
        $excelFile = $_FILES ['fileUpload'] ['tmp_name'];
        $file_types = explode ( ".", $_FILES ['fileUpload'] ['name'] );
        $file_type = $file_types [count ( $file_types ) - 1];
        /*判别是不是.xls文件，判别是不是excel文件*/
        if (!(strtolower($file_type)=="xls"||strtolower($file_type) =="xlsx"))
        {
            throw new Exception('不是Excel文件，重新上传');
        }
        if($file_type=="xls") {
            $reader = \PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
        }else{
            $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        }
        $PHPExcel = $reader->load($excelFile); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $end_index = \PHPExcel_Cell::columnIndexFromString($highestColumm);
        $parcelList =[];
        /** 循环读取每个单元格的数据 */
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try{
            for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
                if($sheet->getCell('A'.$row)=='陌云运单号'){
                    continue;
                }else {
                    $parcel =[];
                    $goods =[];
                    $tracking_code_moyun =trim($sheet->getCell('A'.$row)->getValue());
                    $weight_p = trim($sheet->getCell('B'.$row)->getValue());
                    $parcel = $parcelModel->find()->where(['tracking_code_moyun'=>$tracking_code_moyun])->one();

                   if($parcel) {
                       if($parcel->shipping_status==10) {
                           $shipping_price = $this->getShippingPrice($parcel->parcel_id, $weight_p);
                           if (is_array($shipping_price)) {
                               throw new Exception('运费计算失败');
                               break;
                           } else {
                               $parcel->weight_p = $weight_p;
                               $parcel->shipping_status = 20;
                               $parcel->in_at = time();
                               $parcel->shipping_price = $shipping_price;
                               if (!$parcel->save()) {
                                   throw new Exception('批量入库失败');
                                   break;
                               }
                           }
                       }else{
                           throw new Exception('第'.$row.'行运单已入库');
                           break;
                       }

                    }else{
                       throw new Exception('第'.$row.'行运单号不存在');
                       break;

                   }
                }
            }
            $transaction->commit();
            Yii::$app->session->setFlash('success', '批量入库成功.');
        }catch (Exception $e){
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        echo"<script>history.go(-1);</script>";
    }

}
