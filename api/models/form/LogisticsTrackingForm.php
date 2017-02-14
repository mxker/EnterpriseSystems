<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/26
 * Time: 16:22
 */

namespace api\models\form;

use common\models\LogisticsTracking as ALogisticTracking;

class LogisticsTrackingForm extends ALogisticTracking
{
    public $express_code;
    public $tracking_code;
    public $status_code;
    public $status_msg;
    public $data;
    public $create_at;
    public $state;
    public $state_txt;
    public $express_id;
    public $express_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_logistics_tracking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'state', 'express_id'], 'integer'],
            [['data'], 'string'],
            [['express_id', 'express_name'], 'required'],
            [['status_code', 'express_code', 'tracking_code', 'express_name'], 'string', 'max' => 50],
            [['status_msg'], 'string', 'max' => 45],
            [['state_txt'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lt_id' => '物流追踪id',
            'express_code' => '快递公司代码',
            'tracking_code' => '快递单号',
            'status_code' => '状态码',
            'status_msg' => '状态消息',
            'data' => '快递跟踪信息',
            'create_at' => '创建时间',
            'state' => '当前签收状态码',
            'state_txt' => '当前签收状态文字',
            'express_id' => '快递公司id',
            'express_name' => '公司名称',
        ];
    }

    public function addTrackings($data){
        $model = new ALogisticTracking();
        $model->express_code = $data['express_code'];
        $model->tracking_code = $data['tracking_code'];
        $model->status_code = $data['status_code'];
        $model->status_msg = $data['status_msg'];
        $model->data = $data['data'];
        $model->create_at = $data['create_at'];
        $model->state = $data['state'];
        $model->state_txt = $data['state_txt'];
        $model->express_id = $data['express_id'];
        $model->express_name = $data['express_name'];

        if($model->save()){
            return true;
        }else{
            return false;
        }
    }

    public function editTrackings($data){
        $model = ALogisticTracking::findOne(['tracking_code' => $data['tracking_code']]);
        $model->express_code = $data['express_code'];
        $model->tracking_code = $data['tracking_code'];
        $model->status_code = $data['status_code'];
        $model->status_msg = $data['status_msg'];
        $model->data = $data['data'];
        $model->create_at = $data['create_at'];
        $model->state = $data['state'];
        $model->state_txt = $data['state_txt'];
        $model->express_id = $data['express_id'];
        $model->express_name = $data['express_name'];

        if($model->save()){
            return true;
        }else{
            return false;
        }
    }

    public function updateTrackings($data){
        $model = ALogisticTracking::findOne(['tracking_code' => $data['tracking_code']]);
        $model->data = $data['data'];

        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
}