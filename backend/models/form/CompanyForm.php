<?php
namespace backend\models\form;
use yii;
use yii\db\Exception;
use common\models\Company as BCompany;
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

    public function add($params){
        $model = new BCompany();
        $model->company_name    = $params['company_name'];
        $model->company_tel     = $params['company_tel'];
        $model->company_logo    = $params['company_logo'];
        $model->company_area    = $params['company_area'];
        $model->culture         = $params['culture'];
        $model->description     = $params['description'];
        if($model->save()){
            return true;
        }else{
            return false;
        }
    }

    public function edit($params){
        $DB = yii::$app->db;
        $transaction = $DB->beginTransaction();
        try {
            $model = BCompany::findOne($params['company_id']);
            $model->company_name    = $params['company_name'];
            $model->company_tel     = $params['company_tel'];
            $model->company_logo    = $params['company_logo'];
            $model->company_area    = $params['company_area'];
            $model->culture         = $params['culture'];
            $model->description     = $params['description'];
            if($model->save()){
                return true;
            }else{
                throw new Exception("更新失败");
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }
}