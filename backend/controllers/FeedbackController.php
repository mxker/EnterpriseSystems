<?php

namespace backend\controllers;
use \backend\components\Controller;
use backend\models\form\FeedbackForm;
use common\models\FeedbackCatalog;
use common\models\Member;
use yii\data\Pagination;

class FeedbackController extends Controller {

    public function actionList() {
        //问题类型
        $types = FeedbackCatalog::find()->select('fc_id,name')->asArray()->all();

        //根据不同类型搜索
        $condition = [];
        $condition['parent_id'] = 0;
        if(\Yii::$app->request->get('type_id')){
            $type_id = \Yii::$app->request->get('type_id');
            $condition['feedback_catalog_id'] = $type_id;
        }

        $model = new FeedbackForm();
        $fields = '*';
        $allList = $model::find()->select($fields);
        $pages = new Pagination(['totalCount' =>$allList->where($condition)->count(), 'pageSize' => '50']);
        $allList = $allList->offset($pages->offset)->limit($pages->limit)->where($condition)->asArray()->all();

        foreach($allList as $key => $value){
            $allList[$key]['create_at'] = date('Y-m-d H:i', $value['create_at']);
            //问题类型
            $type = FeedbackCatalog::find()->select('name,remark')->where([
                'fc_id' => $value['feedback_catalog_id'],
            ])->asArray()->one();
            $allList[$key]['type'] = $type['name'];
        }
        return $this->render('list',['model' => $model,'list' => $allList, 'pages' => $pages, 'types' => $types]);
    }

    public function actionDelete(){
        $request = \Yii::$app->request->post();
        if($request){
            $result = FeedbackForm::deleteAll(['feedback_id' => $request['feedback_id']]);
            if($result){
                return $this->redirect(['feedback/list']);
            }else{
                return $this->redirect(['site/error-500']);
            }
        }
    }

    /**
     * 回复之前的准备数据
     * @return string
     */
    public function actionEdit()
    {
        $model = new FeedbackForm();
        //原始数据
        $data = \Yii::$app->request->get();
        $fields = '*';
        $dataInfo = $model->getOneInfo($fields, ['feedback_id' => $data['feedback_id']]);

        //问题类型
        $type = FeedbackCatalog::find()->select('name,remark')->where([
            'fc_id' => $dataInfo['feedback_catalog_id'],
            'parent_id' => 0
        ])->asArray()->one();
        $dataInfo['type'] = $type['name'].'（'.$type['remark'].'）';
        $dataInfo['create_at'] = date('Y-m-d H:i', $dataInfo['create_at']);

        //获取个人信息
        $memberInfo = Member::find()->select('username')->where(['member_id' => $dataInfo['member_id']])->asArray()->one();
        $dataInfo['user_name'] = $memberInfo['username'];

        //回复的相关内容
        $field = 'parent_id,admin_id,member_id,order_id,content,attachment,create_at';
        $contents = $model->getAllList($field,['parent_id' => $data['feedback_id']]);
        if($contents){
            foreach($contents as $key => $content){
                if($content['member_id'] == 0){
                    $contents[$key]['user_name'] = '管理员';
                }else{
                    $memberInfo = Member::find()->select('username')->where(['member_id' => $content['member_id']])->asArray()->one();
                    $contents[$key]['user_name'] = $memberInfo['username'];
                }
                $contents[$key]['create_at'] = date('Y-m-d H:i', $content['create_at']);
            }
        }
        return $this->render('edit',[
            'model' => $model,
            'dataInfo' => $dataInfo,
            'contents' => $contents
        ]);
    }

    /**
     * 回复工单
     * @return \yii\web\Response
     */
    public function actionSave(){
        $replyInfo = \Yii::$app->request->get();
        $model = new FeedbackForm();
        $result = $model->addFeedback($replyInfo);
        if($result){
            \Yii::$app->session->setFlash('success', '回复成功.');
            return $this->redirect(['feedback/list']);
        }else{
            \Yii::$app->session->setFlash('error', '回复失败.');
            return $this->redirect(['feedback/list']);
        }
    }
}
