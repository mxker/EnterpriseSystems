<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 15:14
 */

namespace backend\models;

use yii;
use yii\db\ActiveRecord;

class Demo extends ActiveRecord
{
//    public $username;
//    public $email;

    /**
     * 可无，对应表：默认类名和表名匹配，则无需此函数
     * @return string
     */
    public static function tableName(){
        return 'my_demo';
    }

    /**
     * 可无，验证器：主要用于校验各个字段
     * @return array
     */
    public function rules(){
        return [
//            ['id', 'integer'],
//            ['username', 'string', 'length' => [0, 100]],
              [['username', 'email'], 'required'],
              ['email', 'email'],
        ];
    }

    /**
     * 获取一条信息
     */
    public function getInfo(){

    }

    /**
     * 客户和订单通过 Order.customer_id -> id 关联建立一对多关系
     * @return yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['id' => 'id']);
    }

    public function getBigDemos($threshold = 100)
    {
        return $this->hasMany(Demo::className(), ['id' => 'id'])
            ->where('id > :threshold', [':threshold' => $threshold])
            ->orderBy('id');
    }


}