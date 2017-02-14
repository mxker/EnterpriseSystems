<?php

namespace backend\controllers;

use backend\models\form\StorehouseForm;
use common\models\Country;
use yii\data\Pagination;

class StorehouseController extends \yii\web\Controller
{
    public function actionList(){
        $model = new StorehouseForm();
        $fields = 'storehouse_id,country_id,name,create_at,addr_sender';
        $allList = $model::find()->select($fields);
        $pages = new Pagination(['totalCount' =>$allList->count(), 'pageSize' => '50']);
        $allList = $allList->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        //数据重组
        foreach($allList as $key => $list){
            $allList[$key]['create_at'] = date('Y-m-d H:i', $list['create_at']);
            $senderArr = unserialize($list['addr_sender']);
            $allList[$key]['addr_sender'] = $senderArr['prov'].' '.$senderArr['city'].' '.$senderArr['county'].' '.$senderArr['adress'];

            //国家名称
            $country = Country::findOne($list['country_id']);
            $allList[$key]['country'] = $country['name'];
        }

        return $this->render('list', ['model' => $model, 'list' => $allList, 'pages' => $pages]);
    }

    public function actionAdd(){
        //获取所有国家
        $country = Country::find()->select('country_id,name')->asArray()->all();

        //数组重组
        foreach($country as $k => $v){
            $countrys[$v['country_id']] = $v['name'];
        }

        $model = new StorehouseForm();
        return $this->render('add', ['model' => $model, 'country' => $countrys]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSave(){
        $model = new StorehouseForm();
        if($model->load(\Yii::$app->request->post())){
            $data = \Yii::$app->request->post();

            //storehouse_id存在则执行修改，反之添加
            if(isset($data['StorehouseForm']['storehouse_id'])){
                if($model->editStorehouse($data['StorehouseForm']['storehouse_id'])){
                    return $this->redirect(['storehouse/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }else{
                if($model->addStorehouse()){
                    return $this->redirect(['storehouse/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }
        }
    }

    public function actionDelete(){
        $request = \Yii::$app->request->post();
        if($request){
            $result = StorehouseForm::deleteAll(['storehouse_id' => $request['storehouse_id']]);
            if($result){
                return $this->redirect(['storehouse/list']);
            }else{
                return $this->redirect(['site/error-500']);
            }
        }
        return $this->render('delete');
    }

    public function actionEdit(){
        //获取所有国家
        $country = Country::find()->select('country_id,name')->asArray()->all();

        $countrys = [];
        //数组重组
        foreach($country as $k => $v){
            $countrys[$v['country_id']] = $v['name'];
        }

        $model = new StorehouseForm();

        //原始数据
        $data = \Yii::$app->request->get();
        $fields = '*';
        $dataInfo = $model->getOneInfo($fields, ['storehouse_id' => $data['storehouse_id']]);

        //地址信息
        $addrInfo = unserialize($dataInfo['addr_sender']);

        return $this->render('edit',['model' => $model, 'dataInfo' => $dataInfo, 'country' => $countrys, 'addrInfo' => $addrInfo]);
    }

}
