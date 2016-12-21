<?php

namespace backend\controllers;
use \backend\components\Controller;
use backend\models\form\ChannelOverseasForm;
use common\models\Country;
use yii\data\Pagination;

class ChannelOverseasController extends Controller {

    /**
     * 渠道列表
     * @return string
     */
    public function actionList() {
        $model = new ChannelOverseasForm();
        $fields = '*';
        $allList = $model::find()->select($fields);
        $pages = new Pagination(['totalCount' =>$allList->count(), 'pageSize' => '50']);
        $allList = $allList->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        foreach($allList as $key => $list){
            //国家名称
            $country = Country::findOne($list['country_id']);
            $allList[$key]['country'] = $country['name'];
        }

        return $this->render('list',['model' => $model, 'list' => $allList, 'pages' => $pages]);
    }

    /**
     * 渠道删除
     * @return \yii\web\Response
     */
    public function actionDelete(){
        $request = \Yii::$app->request->post();
        if($request){
            $result = ChannelOverseasForm::deleteAll(['co_id' => $request['co_id']]);
            if($result){
                return $this->redirect(['channel-overseas/list']);
            }else{
                return $this->redirect(['site/error-500']);
            }
        }
    }

    /**
     * 渠道添加
     * @return string
     */
    public function actionAdd(){
        //获取所有国家
        $country = Country::find()->select('country_id,name')->asArray()->all();

        //数组重组
        foreach($country as $k => $v){
            $countrys[$v['country_id']] = $v['name'];
        }

        $model = new ChannelOverseasForm();
        return $this->render('add',['model' => $model,'country' => $countrys]);
    }

    /**
     * 渠道保存
     * @return \yii\web\Response
     */
    public function actionSave(){
        $model = new ChannelOverseasForm();
        if($model->load(\Yii::$app->request->post())){
            $data = \Yii::$app->request->post();

            //co_id存在则执行修改，反之添加
            if(isset($data['ChannelOverseasForm']['co_id'])){
                if($model->editChannel($data['ChannelOverseasForm']['co_id'])){
                    return $this->redirect(['channel-overseas/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }else{
                if($model->addChannel()){
                    return $this->redirect(['channel-overseas/list']);
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
        //获取所有国家
        $country = Country::find()->select('country_id,name')->asArray()->all();

        $countrys = [];
        //数组重组
        foreach($country as $k => $v){
            $countrys[$v['country_id']] = $v['name'];
        }

        $model = new ChannelOverseasForm();

        //原始数据
        $data = \Yii::$app->request->get();
        $fields = '*';
        $dataInfo = $model->getOneInfo($fields, ['co_id' => $data['co_id']]);

        return $this->render('edit',['model' => $model,'country' => $countrys, 'dataInfo' => $dataInfo]);
    }
}
