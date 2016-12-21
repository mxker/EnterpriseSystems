<?php

namespace api\controllers;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class InterfaceController extends Controller {
    public function actions() {
        return [
            'notifySubscribeTracking' => 'api\controllers\trackingcode\NotifySubscribeTrackingAction', //通知订阅快递信息
            'getTrackingInfo' => 'api\controllers\trackingcode\GetTrackingAction', //查询快递信息
        ];
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        if ($this->action->id != 'index' && !defined('MY_INTERFACE')) {
            die(Json::encode(['code' => '501', 'desc' => '非法请求接口']));
        }

        return true;
    }

    public function actionIndex() {
        define('MY_INTERFACE', TRUE);
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return Json::encode(['code' => '502', 'desc' => '请求方法错误']);
        } else if (!in_array($request->post('method'), array_keys($this->actions()))) {
            return Json::encode(['code' => '404', 'desc' => '接口名错误']);
        }
        return $this->runAction($request->post('method'), $request->post());
    }

}
