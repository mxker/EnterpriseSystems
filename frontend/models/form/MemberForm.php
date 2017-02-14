<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/10
 * Time: 20:32
 */

namespace frontend\models\form;

use Yii;
use frontend\models\Member;

class MemberForm extends Member
{
    public $username;
    public $email;
    public $mob_phone;

    public function rules(){
        return [
            [['username', 'email', 'mob_phone'], 'required']
        ];
    }

    public function attributeLabels(){
        return [
            'username' => '用户名',
            'email'    => '邮箱',
            'mob_phone'=> '手机号码',
        ];
    }

    public function editMember(){
        $model = Member::findOne($_SESSION['member']['member_id']);
        $model->username = $this->username;
        $model->email    = $this->email;
        $model->mob_phone= $this->mob_phone;

        if($model->save()){
            return true;
        }
    }
}