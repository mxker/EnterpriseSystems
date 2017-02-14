<?php

namespace backend\controllers;

use backend\models\form\CountryForm;
use yii\data\Pagination;

class CountryController extends \yii\web\Controller
{
    public function actionAdd(){
        $model = new CountryForm();
        return $this->render('add', ['model' => $model]);
    }

    public function actionEdit()
    {
        $model = new CountryForm();
        //原始数据
        $data = \Yii::$app->request->get();
        $fields = '*';
        $dataInfo = $model->getOneInfo($fields, ['country_id' => $data['country_id']]);

        return $this->render('edit',['model' => $model, 'dataInfo' => $dataInfo]);
    }

    public function actionList(){
        $model = new CountryForm();
        $fields = 'country_id,name,money_name';
        $allList = $model::find()->select($fields);
        $pages = new Pagination(['totalCount' =>$allList->count(), 'pageSize' => '50']);
        $allList = $allList->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->render('list', ['model' => $model, 'list' => $allList, 'pages' => $pages]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSave(){
        $model = new CountryForm();
        if($model->load(\Yii::$app->request->post())){
            $data = \Yii::$app->request->post();

            //storehouse_id存在则执行修改，反之添加
            if(isset($data['CountryForm']['country_id'])){
                if($model->editCountry($data['CountryForm']['country_id'])){
                    return $this->redirect(['country/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }else{
                if($model->addCountry()){
                    return $this->redirect(['country/list']);
                }else{
                    return $this->redirect(['site/error-404']);
                }
            }
        }
    }

    public function actionDelete(){
        $request = \Yii::$app->request->post();
        if($request){
            $result = CountryForm::deleteAll(['country_id' => $request['country_id']]);
            if($result){
                return $this->redirect(['country/list']);
            }else{
                return $this->redirect(['site/error-500']);
            }
        }
        return $this->render('delete');
    }
}
