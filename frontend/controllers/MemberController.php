<?php

namespace frontend\controllers;
use frontend\components\Controller;
use frontend\models\form\FeedbackForm;
use frontend\models\form\MemberForm;
use frontend\models\Member;
use frontend\models\Parcel;

class MemberController extends Controller {
    public function actionHome() {
        $memberInfo = $_SESSION['member'];
        $model = new Member();
        $fields = 'username,email,mob_phone,available_predeposits,freeze_predeposits';
        $member_info = $model->find()->select($fields)->where(['member_id' => $memberInfo['member_id']])->asArray()->one();

        //问题包裹数量
        $modelIssue = new Parcel();
        $issueNum = $modelIssue->find()->where([
            'AND',
            ['member_id' => $memberInfo['member_id']],
            ['is_issue' => 1],
        ])->count();
        $member_info['issueNum'] = $issueNum;

        //在途包裹
        $normalNum = $modelIssue->find()->where([
            'AND',
            ['member_id' => $memberInfo['member_id']],
            ['is_issue' => 0],
        ])->count();
        $member_info['normalNum'] = $normalNum;

        //售后工单
        $modelFeedback = new FeedbackForm();
        $feedback = $modelFeedback->find()->where(['member_id' => $memberInfo['member_id']])->count();
        $member_info['feedback'] = $feedback;

        $modelForm = new MemberForm();
        return $this->render('home',['memberInfo' => $member_info, 'model' => $modelForm]);
    }

}
