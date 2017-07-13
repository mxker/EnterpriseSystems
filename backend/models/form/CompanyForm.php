<?php
namespace backend\models\form;
use yii;
use common\models\company as BCompany;
/**
* 公司基本模型
*/
class CompanyForm extends BCompany{
	public $company_id;
	public $company_name;
	public $company_logo;
	public $company_tel;
	public $company_area;
	public $culture;
	public $description;

	/**
	 * 获取所有的公司信息
	 * @param  [type] $fields    [description]
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getAllList($fields, $condition = null){
        return $this->find()->select($fields)->where($condition)->asArray()->all();
    }

    /**
     * 获取一条公司的信息
     * @param  [type] $fields    [description]
     * @param  array  $condition [description]
     * @return [type]            [description]
     */
    public function getOneInfo($fields, $condition = array()){
        return $this->find()->select($fields)->where($condition)->asArray()->one();
    }

    public function addChannel(){
//        $model = new LogisticsChannel();
        $model->name = $this->name;
        $model->country_id = $this->country_id;

        if($model->save()){
            return true;
        }else{
            return false;
        }
    }

    public function editChannel($id){
        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
}