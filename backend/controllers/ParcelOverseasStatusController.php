<?php

namespace backend\controllers;
use \backend\components\Controller;
use backend\models\form\ParcelOverseasStatusForm;
use backend\models\form\StorehouseForm;
use backend\models\form\StorehouseStatusForm;
use yii\data\Pagination;

class ParcelOverseasStatusController extends Controller {

    public function actionList() {
        $model = new ParcelOverseasStatusForm();
        $fields = '*';
        $allList = $model::find()->select($fields);
        $pages = new Pagination(['totalCount' =>$allList->count(), 'pageSize' => '50']);
        $allList = $allList->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        //重组隶属仓库
        foreach($allList as $key => $info){
            $storehouses = StorehouseStatusForm::find()->where(['pos_id' => $info['pos_id']])->asArray()->all();
            $storehouseArray = array_column($storehouses,'s_id');
            $storehouse = [];
            foreach($storehouseArray as $k => $v){
                $storeName = StorehouseForm::find()->where(['storehouse_id' => $v])->asArray()->one();
                $storehouse[$k] = $storeName['name'];
            }
            $allList[$key]['storehouse'] = implode(' | ', $storehouse);
        }

        return $this->render('list',['model' => $model, 'list' => $allList, 'pages' => $pages]);
    }

    /**
     * @return string
     */
    public function actionAdd(){
        $model = new ParcelOverseasStatusForm();
        //获取仓库列表
        $fields = 'storehouse_id,name';
        $list = StorehouseForm::find()->select($fields)->asArray()->all();

        $lists = [];
        //数组重组
        foreach($list as $k => $v){
            $lists[$v['storehouse_id']] = $v['name'];
        }

        return $this->render('add',['model' => $model, 'lists' => $lists]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSave(){
        $model = new ParcelOverseasStatusForm();
        if($model->load(\Yii::$app->request->post())){
            $data = \Yii::$app->request->post();
            $storehouses = $data['ParcelOverseasStatusForm']['belong_storehouse'];

            //co_id存在则执行修改，反之添加
            if(isset($data['ParcelOverseasStatusForm']['pos_id'])){
                if($model->editStatus($data['ParcelOverseasStatusForm']['pos_id'])){
                    $modelStorehouseStatus = new StorehouseStatusForm();
                    $modelStorehouseStatus::deleteAll(['pos_id' => $data['ParcelOverseasStatusForm']['pos_id']]);
                    foreach($storehouses as $key => $storehouse){
                        $modelStorehouseStatus->addStorehouseStatus(['s_id' => $storehouse, 'pos_id' => $data['ParcelOverseasStatusForm']['pos_id']]);
                    }
                    return $this->redirect(['parcel-overseas-status/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }else{
                $pos_id = $model->addStatus();
                if($pos_id){
                    foreach($storehouses as $key => $storehouse){
                        $modelStorehouseStatus = new StorehouseStatusForm();
                        $modelStorehouseStatus->addStorehouseStatus(['s_id' => $storehouse, 'pos_id' => $pos_id]);
                    }

                    return $this->redirect(['parcel-overseas-status/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDelete(){
        $request = \Yii::$app->request->post();
        if($request){
            $result = ParcelOverseasStatusForm::deleteAll(['pos_id' => $request['pos_id']]);
            StorehouseStatusForm::deleteAll(['pos_id' => $request['pos_id']]);
            if($result){
                return $this->redirect(['parcel-overseas-status/list']);
            }else{
                return $this->redirect(['site/error-500']);
            }
        }
    }

    /**
     * @return string
     */
    public function actionEdit(){
        $model = new ParcelOverseasStatusForm();

        //获取仓库列表
        $fields = 'storehouse_id,name';
        $list = StorehouseForm::find()->select($fields)->asArray()->all();
        $lists = [];
        foreach($list as $k => $v){
            $lists[$v['storehouse_id']] = $v['name'];
        }

        //原始数据
        $data = \Yii::$app->request->get();
        $fields = '*';
        $dataInfo = $model->getOneInfo($fields, ['pos_id' => $data['pos_id']]);

        $storehouses = StorehouseStatusForm::find()->where(['pos_id' => $data['pos_id']])->asArray()->all();
        $storeArr = array_column($storehouses,'s_id');

        return $this->render('edit',[
            'model' => $model,
            'dataInfo' => $dataInfo,
            'lists' => $lists,
            'sotrehouseId' => $storeArr
        ]);
    }
}
