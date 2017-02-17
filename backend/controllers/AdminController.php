<?php

namespace backend\controllers;
use backend\components\Controller;
use backend\models\form\CompanyForm;

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
    	$model = new CompanyForm();
        return $this->render('info',['model' => $model]);
    }
}
