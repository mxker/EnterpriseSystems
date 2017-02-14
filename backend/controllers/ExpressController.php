<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/23
 * Time: 15:41
 */

namespace backend\controllers;


use yii\base\Controller;

class ExpressController extends Controller
{
    public function actionCallback(){
        $getData = \Yii::$app->request->post();
        if(!isset($getData['param'])){
            exit('推送接口回调无数据');
        }

        $getDataArr = json_decode($getData['param'], TRUE);
        if (!is_array($getDataArr) || empty($getDataArr)) {
            exit('推送数据参数不对');
        }

        //数字状态转换成对应文本
        $state = $getDataArr['lastResult']['state'];
        $state_txt = str_replace([0, 1, 2, 3], ['在途中', '揽件', '疑难', '签收'], $state);
        $shipping_detail = serialize($getDataArr['lastResult']['data']);

        $udpate_result = '0';
        if ($udpate_result) {
            echo '{"result":"true", "returnCode":"200","message":"成功"}';
        } else {
            //屏蔽错误信息的代码
            echo '{"result":"true", "returnCode":"200","message":"成功"}';
        }
    }
}