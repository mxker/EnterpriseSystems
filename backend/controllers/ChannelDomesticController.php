<?php

namespace backend\controllers;

use \backend\components\Controller;
use backend\models\form\ChannelDomesticForm;
use backend\models\form\TrackingCodeDomesticForm;
use yii\data\Pagination;
use yii\db\Exception;
use Yii;

class ChannelDomesticController extends Controller {

    /**
     * 国内渠道列表
     * @return string
     */
    public function actionList() {
        $model = new ChannelDomesticForm();
        $fields = '*';
        $allList = $model::find()->select($fields);
        $pages = new Pagination(['totalCount' =>$allList->count(), 'pageSize' => '50']);
        $allList = $allList->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        //查询剩余可用单号
        foreach($allList as $key => $channel){
            $codeNum = TrackingCodeDomesticForm::find()->where([
                'channel_domestic_id' => $channel['cd_id'],
                'is_used' => 0
            ])->count();

            $allList[$key]['code_num'] = $codeNum;
        }

        return $this->render('list',['model' => $model, 'list' => $allList, 'pages' => $pages]);
    }

    public function actionAdd(){
        $model = new ChannelDomesticForm();
        return $this->render('add',['model' => $model]);
    }

    /**
     * 渠道保存
     * @return \yii\web\Response
     */
    public function actionSave(){
        $model = new ChannelDomesticForm();
        if($model->load(\Yii::$app->request->post())){
            $data = \Yii::$app->request->post();

            //cd_id存在则执行修改，反之添加
            if(isset($data['ChannelDomesticForm']['cd_id'])){
                if($model->editDomestic($data['ChannelDomesticForm']['cd_id'])){
                    return $this->redirect(['channel-domestic/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }else{
                if($model->addDomestic()){
                    return $this->redirect(['channel-domestic/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }
        }
    }

    /**
     * 修改之前的准备数据
     * @return string
     */
    public function actionEdit(){
        $model = new ChannelDomesticForm();

        //原始数据
        $data = \Yii::$app->request->get();
        $fields = '*';
        $dataInfo = $model->getOneInfo($fields, ['cd_id' => $data['cd_id']]);

        return $this->render('edit',['model' => $model, 'dataInfo' => $dataInfo]);
    }

    /**
     * 渠道删除
     * @return \yii\web\Response
     */
    public function actionDelete(){
        $request = \Yii::$app->request->post();
        if($request){
            $result = ChannelDomesticForm::deleteAll(['cd_id' => $request['cd_id']]);
            if($result){
                return $this->redirect(['channel-domestic/list']);
            }else{
                return $this->redirect(['site/error-500']);
            }
        }
    }

    /**
     * 批量导入物流单号
     * @return \yii\web\Response
     * @throws Exception
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function actionImport(){
        $modelCode = new TrackingCodeDomesticForm();

        //获取渠道ID
        $code = \Yii::$app->request->post();
        $code_id = $code['code_id'];

        $file = $_FILES;//获取上传的文件实例
        $excelFile = $file ['fileUpload'] ['tmp_name'];
        $file_types = explode ( ".", $_FILES ['fileUpload'] ['name'] );
        $file_type = $file_types [count ( $file_types ) - 1];

        /*判别是不是.xls文件，判别是不是excel文件*/
        if (!(strtolower($file_type) == "xls" || strtolower($file_type) =="xlsx")) {
            throw new Exception('不是Excel文件，请重新上传');
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
        for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
            if($sheet->getCell('A'.$row) == '序号'){
                continue;
            }else {
                $parcel =[];
                $code = $sheet->getCell('B'.$row)->getValue();

                $parcel['code'] = $code;

                $parcel['channel_domestic_id'] = $code_id;
                $parcel['is_used'] = 0;
                $parcel['create_at'] = time();
                $parcelList[] = $parcel;
            }
        }

        try{
            foreach($parcelList as $p){
                $modelCode->importCode($p);
            }
        }catch (Exception $e){
            Yii::$app->session->setFlash('success', '物流号导入成功.');
        }

        return $this->redirect(['channel-domestic/list']);
    }
}
