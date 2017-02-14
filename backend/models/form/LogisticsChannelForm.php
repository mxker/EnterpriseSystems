<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/18
 * Time: 10:24
 */

namespace backend\models\form;
use common\models\LogisticsChannel as BLogisticsChannel;
use common\models\LogisticsChannel;

class LogisticsChannelForm extends BLogisticsChannel
{
    public $lc_id;
    public $name;
    public $country_id;
    public $channel_overseas_id;
    public $channel_domestic_id;
    public $is_moyun;
    public $is_include_demestic;
    public $is_idcard;
    public $is_tariff;
    public $code;
    public $rule;

    public $start_weight;//首重
    public $start_fee;//起步费用
    public $first_weight;//第一阶梯重量
    public $first_weight_unit;//第一阶梯续重计重单位
    public $first_fee;//第一阶梯费用
    public $second_weight;//第二阶梯重量
    public $second_weight_unit;//第二阶梯续重计重单位
    public $second_fee;//第二阶梯费用

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'country_id', 'channel_overseas_id', 'channel_domestic_id', 'code', 'start_weight', 'start_fee', 'first_weight', 'first_weight_unit', 'first_fee', 'second_weight', 'second_weight_unit', 'second_fee', 'is_moyun', 'is_include_demestic', 'is_idcard', 'is_tariff'], 'required'],
            [['country_id', 'channel_overseas_id', 'channel_domestic_id', 'is_moyun', 'is_include_demestic', 'is_idcard', 'is_tariff'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'lc_id' => '',
            'name' => '渠道名称',
            'country_id' => '国家',
            'channel_overseas_id' => '海外渠道',
            'channel_domestic_id' => '国内渠道',
            'is_moyun' => '陌云渠道',
            'is_include_demestic' => '国内段',
            'is_idcard' => '身份证',
            'is_tariff' => '关税',
            'code' => '渠道代码',

            // 计费规则
            'start_weight' => '首重',
            'start_fee' => '起步费用',
            'first_weight' => '第一阶梯重量',
            'first_weight_unit' => '第一阶梯续重计重单位',
            'first_fee' => '第一阶梯费用',
            'second_weight' => '第二阶梯重量',
            'second_weight_unit' => '第二阶梯续重计重单位',
            'second_fee' => '第二阶梯费用',
        ];
    }

    public function getAllList($fields, $condition = null){
        return $this->find()->select($fields)->where($condition)->asArray()->all();
    }

    public function getOneInfo($fields, $condition = array()){
        return $this->find()->select($fields)->where($condition)->asArray()->one();
    }

    public function addChannel(){
        $model = new LogisticsChannel();
        $model->name = $this->name;
        $model->country_id = $this->country_id;
        $model->channel_overseas_id = $this->channel_overseas_id;
        $model->channel_domestic_id = $this->channel_domestic_id;
        $model->is_moyun = $this->is_moyun;
        $model->is_include_demestic = $this->is_include_demestic;
        $model->is_idcard = $this->is_idcard;
        $model->is_tariff = $this->is_tariff;
        $model->code = $this->code;

        //计费规则json转换
        $rules_array = [];
        $rules_array['start_weight'] = $this->start_weight;
        $rules_array['start_fee'] = $this->start_fee;
        $rules_array['first_weight'] = $this->first_weight;
        $rules_array['first_weight_unit'] = $this->first_weight_unit;
        $rules_array['first_fee'] = $this->first_fee;
        $rules_array['second_weight'] = $this->second_weight;
        $rules_array['second_weight_unit'] = $this->second_weight_unit;
        $rules_array['second_fee'] = $this->second_fee;

        $model->billing_rules = json_encode($rules_array);

        if($model->save()){
            return true;
        }else{
            return false;
        }
    }

    public function editChannel($id){
        $model = BLogisticsChannel::findOne($id);
        $model->name = $this->name;
        $model->country_id = $this->country_id;
        $model->channel_overseas_id = $this->channel_overseas_id;
        $model->channel_domestic_id = $this->channel_domestic_id;
        $model->is_moyun = $this->is_moyun;
        $model->is_include_demestic = $this->is_include_demestic;
        $model->is_idcard = $this->is_idcard;
        $model->is_tariff = $this->is_tariff;
        $model->code = $this->code;

        //计费规则json转换
        $rules_array = [];
        $rules_array['start_weight'] = $this->start_weight;
        $rules_array['start_fee'] = $this->start_fee;
        $rules_array['first_weight'] = $this->first_weight;
        $rules_array['first_weight_unit'] = $this->first_weight_unit;
        $rules_array['first_fee'] = $this->first_fee;
        $rules_array['second_weight'] = $this->second_weight;
        $rules_array['second_weight_unit'] = $this->second_weight_unit;
        $rules_array['second_fee'] = $this->second_fee;

        $model->billing_rules = json_encode($rules_array);

        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
}