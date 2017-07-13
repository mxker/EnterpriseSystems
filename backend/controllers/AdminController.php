<?php

namespace backend\controllers;
use backend\components\Controller;
use backend\models\form\CompanyForm;
use common\models\Company;
use yii\db\Exception;

class AdminController extends Controller {
	/**
	 * 后台首页
	 * @return [type] [description]
	 */
    public function actionHome() {
        return $this->render('home');
    }

    /**
     * 公司基本信息
     * @return [type] [description]
     */
    public function actionInfo() {
        $companyId = 1;
    	$model = new CompanyForm;

        $companyInfo = CompanyForm::find()->where(['company_id' => $companyId])->asArray()->one();
        return $this->render('info',['model' => $model, 'companyInfo' => $companyInfo]);
    }

    /**
     * 渠道保存
     * @return \yii\web\Response
     */
    public function actionSave(){
        $model = new CompanyForm();
        if($model->load(\Yii::$app->request->post())){
            $data = \Yii::$app->request->post();
            $params = $data['CompanyForm'];

            //更新或者添加
            if(!empty($params['company_id'])){
                $model = Company::findOne($params['company_id']);
                $model->company_name    = $params['company_name'];
                $model->company_tel     = $params['company_tel'];
                $model->company_logo    = $params['company_logo'];
                $model->company_area    = $params['company_area'];
                $model->culture         = $params['culture'];
                $model->description     = $params['description'];
                if($model->save()){
                    return $this->redirect(['admin/info']);
                }else{
                    throw new Exception('更新失败');
                }
            
            }else{

                if($model->add($params)){
                    return $this->redirect(['admin/info']);
                }else{
                    throw new Exception('添加失败');
                }
            }
        }
    }
}
