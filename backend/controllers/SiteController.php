<?php
namespace backend\controllers;
use backend\components\Controller;
use backend\models\form\LoginForm;
use Yii;

class SiteController extends Controller {
    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => substr(str_shuffle('ABCDEFGHJKMNPQRSTUVWXY3456789'), 0, 4),
            ],

            'uploadImg' => [
                'class' => 'common\actions\UploadAction',
                'extensions' => 'jpg, jpeg, png',
                'maxSize' => 2 * 1024 * 1024,
                'savePath' => 'img' . DIRECTORY_SEPARATOR .date("Ym") . DIRECTORY_SEPARATOR . date('d'),
            ],


        ];
    }

    public function actionLogin() {
        if (!Yii::$app->authAdmin->isGuest()) {
            return $this->redirect(['admin/home']);
        }
        $this->layout = false;
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['admin/home']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->authAdmin->logout();
        return $this->redirect(['site/login']);
    }

    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception != null) {
            $this->layout = false;
            if ($exception->statusCode == 404) {
                return $this->render('error_404', ['exception' => $exception]);
            } else {
                return $this->render('error_500', ['exception' => $exception]);
            }
        } else {
            return $this->goBack();
        }
    }

}