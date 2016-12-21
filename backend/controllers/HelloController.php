<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/2
 * Time: 11:43
 */

namespace backend\controllers;


use backend\models\Admin;
use backend\models\Demo;
use backend\models\Hello;
use backend\models\Test;
use yii\base\Model;
use yii\db\Exception;
use yii\db\Query;
use yii\db\Command;
use yii\web\Controller;

class HelloController extends Controller
{
//    public $layout = 'main1';// 布局的自定义选择

    /**
     * 独立操作
     * @inheritdoc
     */
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    //默认方法
    public $defaultAction = 'say';

    public function actionSay(){
        $model = new Demo();
        return $this->render('say', ['model' => $model]);
    }

    public function actionDemo(){
        $model = new Demo();
//        $model = new \backend\models\Hello;
//        echo $model->subject[0];
//        echo $model->attributeLabels('name');

//        $modelDemo = new Demo;
//        echo $modelAdmin->name;
//        $modelDemo->scenario = ['register'];

//        $string = ['1','2'];
//        $result = $modelDemo->toArray($string);

        //获取请求数据
        $req = \Yii::$app->request;
        $result = $req->post();
        $model->username = $result['Demo']['username'];
        $model->email = $result['Demo']['email'];

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $res = $model->save();
            echo $res;
        }else{
            echo '验证失败';
        }
    }

    /**
     * 数据库CRUD---原始方法
     */
    public function actionData(){
        //查询
//        $sql = 'select * from my_demo WHERE 1';
//        $res = Demo::findBySql($sql)->all();

        //增加
        $array = array(
            'username' => '666',
            'email' => '666@163.com',
            'password_hash' => '27b7cb4ef36f066c94b8e093156aebec',
            'salt' => 'Rz4gAf',
        );
        $res = \yii::$app->db->createCommand()->insert('my_demo',$array)->execute();

        //更新
//        $res = \yii::$app->db->createCommand()->update('my_demo',['email' => 'mxk_crazy@163.com'], ['username' => 'mxker'])->execute();

        //删除
//        $res = \yii::$app->db->createCommand()->delete('my_demo', ['username' => 'demo'])->execute();

        var_dump($res);
    }

    /**
     * 数据库CRUD---框架结构
     */
    public function actionCrud(){
        $model = new Demo();
//        $model->tableName('my_demo');
//        $array = ['username' => 'demo', 'email' => '222@163.com'];
//        $model->validate($array);
//        if($model->hasErrors()){
//            echo '数据不合法';
//            die;
//        }
//        $res = $model->save($array);

        //查询
//        $res = $model::find()->where(['username' => 'mxker'])->all();
//        $res = $model::find()->where(['like', 'username', 'mxk'])->all();
//        $res = $model::find()->where(['between', 'id', 1,2])->all();

        // 查询的使用 obj->array
//        $res = $model::find()->where(['between', 'id', 1,2])->asArray()->all();

//        $command = \yii::$app->db->createCommand('SELECT username FROM my_demo');
//        $result = $command->queryColumn();

// INSERT 一次插入多行
//        $res = \yii::$app->db->createCommand()->batchInsert('my_demo', ['username', 'email'], [
//            ['Tom', 'Tom@163.com'],
//            ['Jane', 'Jane@163.com'],
//            ['Linda', 'Linda@163.com'],
//        ])->execute();


        //指定字段查询，并转换成数组
//        $res = $model::find()->where(['username' => 'mxker'])->select(['username','email'])->asArray()->one();

        //查询出来做删除
//        $res = $model::find()->where(['like', 'email', '@163.com'])->all();
//        $result = $res[3]->delete();

        //直接删除
//        $result = $model::deleteAll('id>:id', [':id' => 9]);

        //事务查询
//        $transaction = \yii::$app->db->beginTransaction();
//        try{
//            $command = \yii::$app->db->createCommand('SELECT username FROM my_demo');
//            $res = $command->queryColumn();
//            $transaction->commit();
//        } catch(Exception $e){
//            $transaction->rollBack();
//        }

        // 创建表
//        $res = \yii::$app->db->createCommand()->createTable('post',
//            [    'id' => 'pk',
//                'title' => 'string',
//                'text' => 'text',]);

        $model = new Query();
        $res = $model->select(['username', 'email'])->from('my_demo')->where(['like', 'username', 'mxker'])->one();
        var_dump($res);
    }

    /**
     * 数据库CRUD---AR
     */
    public function actionAr(){
        //插入数据
        $model = new Demo();
//        $model->username = 'ma';
//        $model->email = 'maxikun@163.com';
//        $res = $model->save();

        //查询ID为9的数据
//        $res = Demo::findOne(9);
        $res = Demo::find([9,['name' => 'Tom']])->select(['username', 'email'])->asArray()->one();

        //关联表操作
//        $customer = Demo::findOne(1);
//        $test = new Test();
//        $test->username = 100;
//        $res = $customer->link('test', $test);

//        $res = $model->getTests(8)->All();
//        $res = $model->getBigDemos(14)->All();

//        // 删除已有客户记录
//        $customer = Demo::findOne(14);
//        $customer->delete();
//
//        // 更新现有客户记录
//        $customer = Demo::findOne(14);
//        $customer->email = 'james@example.com';
//        $customer->save();  // 等同于 $customer->update();
//
//        // 所有客户的created_at（时间）字段加1：
//        Demo::updateAllCounters(['created_at' => 1]);

        //简单的链接查询
//        $res = Demo::find()->innerJoinWith('tests', false)->all();



        var_dump($res);

    }
}