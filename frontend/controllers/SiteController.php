<?php
namespace frontend\controllers;
use frontend\components\Controller;
use frontend\models\form\LoginForm;
use frontend\models\form\RegisterForm;
use common\models\LogisticsTracking;
use Yii;

class SiteController extends Controller {
    public function init(){
        $this->layout='@app/views/layouts/main.php';
    }
    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 90,
                'height' => 35,
            ],
            'uploadImg' => [
                'class' => 'common\actions\UploadAction',
                'extensions' => 'jpg, jpeg, png',
                'maxSize' => 2 * 1024 * 1024,
                'savePath' => 'img' . DIRECTORY_SEPARATOR .date("Ym") . DIRECTORY_SEPARATOR . date('d'),
            ],
        ];
    }

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionLogin() {
        if (!Yii::$app->authMember->isGuest()) {
            return $this->redirect(['member/home']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['member/home']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->authMember->logout();
        return $this->redirect(['site/index']);
    }

    public function actionRegister() {
        $model = new RegisterForm;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->signup()) {
                return $this->redirect(['member/home']);
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionSearch() {
        if (Yii::$app->request->isAjax) {
            $ret = [];
            $data = Yii::$app->request->post();
            if($data['tracking_code_moyun']){
                $ltModel = new LogisticsTracking();
                $message = $ltModel->find()->where(['tracking_code'=>$data['tracking_code_moyun']])->asArray()->one();
                if($message) {
                    if($message['overseas_data']||$message['data']) {
                        $message['data'] = $message['data'] ? unserialize($message['data']) : [];
                        $message['overseas_data'] = $message['overseas_data'] ? unserialize($message['overseas_data']) : [];
                        $message['data'] = array_merge($message['data'],$message['overseas_data']);
                        $ret['message'] = 'success';
                        $ret['data'] = $message['data'];
                        $ret['overseas_data'] = $message['overseas_data'];
                        $ret['code'] = 200;
                    }else{
                        $ret['message'] = '暂无信息！';
                        $ret['code'] = 100;
                    }
                }else{
                    $ret['message'] = '暂无信息！';
                    $ret['code'] = 100;
                }
            }else{
                $ret['message'] = 'fail';
                $ret['code'] = 100;
            }
            return json_encode($ret);
        }
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