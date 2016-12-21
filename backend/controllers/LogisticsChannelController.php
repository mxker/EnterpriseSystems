<?php

namespace backend\controllers;
use \backend\components\Controller;
use backend\models\form\ChannelDomesticForm;
use backend\models\form\ChannelOverseasForm;
use backend\models\form\LogisticsChannelForm;
use common\models\ChannelDomestic;
use common\models\ChannelOverseas;
use common\models\Country;
use common\models\LogisticsChannel;
use yii\data\Pagination;

class LogisticsChannelController extends Controller {

    /**
     * 渠道列表
     * @return string
     */
    public function actionList() {
        $fields = 'lc_id,name,country_id,channel_overseas_id,channel_domestic_id,is_moyun,is_include_demestic,is_idcard,is_tariff,code';
        $model = new LogisticsChannel();
        $allList = $model::find()->select($fields);
        $pages = new Pagination(['totalCount' =>$allList->count(), 'pageSize' => '50']);
        $allList = $allList->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        //数据重组
        foreach($allList as $key => $list){
            //国家名称
            $country = Country::findOne($list['country_id']);
            $allList[$key]['country'] = $country['name'];

            //海外渠道
            $overSea = ChannelOverseas::findOne($list['channel_overseas_id']);
            $allList[$key]['overSea'] = $overSea['name'];

            //国内渠道
            $domestic = ChannelDomestic::findOne($list['channel_domestic_id']);
            $allList[$key]['domestic'] = $domestic['name'];

            //是否为陌云渠道，国内段，身份证，关税
            $allList[$key]['is_moyun'] = ($list['is_moyun'] == 1 ? '是' : '否');
            $allList[$key]['is_include_demestic'] = ($list['is_include_demestic'] == 1 ? '是' : '否');
            $allList[$key]['is_idcard'] = ($list['is_idcard'] == 1 ? '有' : '无');
            $allList[$key]['is_tariff'] = ($list['is_tariff'] == 1 ? '有' : '无');
        }
        return $this->render('list', ['model' => $model, 'list' => $allList, 'pages' => $pages]);
    }

    /**
     * 渠道删除
     * @return \yii\web\Response
     */
    public function actionDelete(){
        $request = \Yii::$app->request->post();
        if($request){
            $result = LogisticsChannel::deleteAll(['lc_id' => $request['lc_id']]);
            if($result){
                return $this->redirect(['logistics-channel/list']);
            }else{
                return $this->redirect(['site/error-500']);
            }
        }
    }


    public function actionEdit(){
        $getData = \Yii::$app->request->get();
        $model = new LogisticsChannelForm();
        $fields = '*';
        $channelInfo = $model->getOneInfo($fields, ['lc_id' => $getData['lc_id']]);

        //计费规则
        $billing_rules = json_decode($channelInfo['billing_rules'], true);

        //获取所有国家
        $country = Country::find()->select('country_id,name')->asArray()->all();
        $countrys = [];
        foreach($country as $k => $v){
            $countrys[$v['country_id']] = $v['name'];
        }

        //获取海外渠道列表
        $overSeasList = ChannelOverseasForm::find()->select('co_id,name')->asArray()->all();
        $overSeasLists = [];
        foreach($overSeasList as $k => $v){
            $overSeasLists[$v['co_id']] = $v['name'];
        }

        //获取国内渠道列表
        $domesticList = ChannelDomesticForm::find()->select('cd_id,name')->asArray()->all();
        $domesticLists = [];
        foreach($domesticList as $k => $v){
            $domesticLists[$v['cd_id']] = $v['name'];
        }

        return $this->render('edit',[
            'model' => $model,
            'channelInfo' => $channelInfo,
            'country' => $countrys,
            'overSeasList' => $overSeasLists,
            'domesticList' => $domesticLists,
            'billing_rules' => $billing_rules,
        ]);
    }

    public function actionSave(){
        $model = new LogisticsChannelForm();
        if($model->load(\Yii::$app->request->post())){

            $data = \Yii::$app->request->post();
            //lc_id存在则执行修改，反之添加
            if(isset($data['LogisticsChannelForm']['lc_id'])){
                if($model->editChannel($data['LogisticsChannelForm']['lc_id'])){
                    return $this->redirect(['logistics-channel/list']);
                }else{
                    return $this->redirect(['site/error-500']);
                }
            }else{
                if($model->addChannel()){
                    return $this->redirect(['logistics-channel/list']);
                }else{
                    return $this->redirect(['site/error-500']);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function actionAdd(){
        $model = new LogisticsChannelForm();

        //获取所有国家
        $country = Country::find()->select('country_id,name')->asArray()->all();
        $countrys = [];
        foreach($country as $k => $v){
            $countrys[$v['country_id']] = $v['name'];
        }

        //获取海外渠道列表
        $overSeasList = ChannelOverseasForm::find()->select('co_id,name')->asArray()->all();
        $overSeasLists = [];
        foreach($overSeasList as $k => $v){
            $overSeasLists[$v['co_id']] = $v['name'];
        }

        //获取国内渠道列表
        $domesticList = ChannelDomesticForm::find()->select('cd_id,name')->asArray()->all();
        $domesticLists = [];
        foreach($domesticList as $k => $v){
            $domesticLists[$v['cd_id']] = $v['name'];
        }

        return $this->render('add',['model' => $model,'country' => $countrys, 'overSeasList' => $overSeasLists, 'domesticList' => $domesticLists]);
    }

    /**
     * 异步数据验证
     * @return array
     */
    public function actionValidate () {
        $model = new LogisticsChannelForm();
        $post = \Yii::$app->request->post();

        //渠道代码不能重复
        if(isset($post['lc_id'])){
            $reuslt = $model->find()->where([
                'AND',
                ['like', 'code', $post['code'], false],
                ['<>', 'lc_id', $post['lc_id']]
            ])->asArray()->all();
        }else{
            $reuslt = $model->find()->where(['like', 'code', $post['code'], false])->asArray()->all();
        }
        if(count($reuslt) != 0){
            return 0;
        }else{
            return 1;
        }
    }
}
