<?php

namespace backend\controllers;

use api\models\form\ExpressForm;
use api\models\form\LogisticsTrackingForm;
use common\models\Express;
use Yii;
use backend\Models\Admin;
use backend\Models\DemoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DemoController implements the CRUD actions for Admin model.
 */
class DemoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDemo(){
        $model = LogisticsTrackingForm::findOne([
            'tracking_code' => 'SG000000152',
        ]);

        //存在更新，不存在则添加
        if(!$model){
            $model=  new LogisticsTrackingForm();
            $model->tracking_code = 'SG00000015266';
        }
        $model->express_code = 'SF';
        $model->status_code = '2';
        $model->status_msg = '揽件';
        $model->state = '2';
        $model->state_txt = '已揽收';
        $model->data = 'shishijiuhao';
        $model->create_at = time();

        //通过快递公司code查询快递公司信息
        $fields = 'id,e_name';
        $expressInfo = ExpressForm::find()->select($fields)->where([
            'e_code' => 'nsf'
        ])->asArray()->one();

        $model->express_id = $expressInfo['id'];
        $model->express_name = $expressInfo['e_name'];

        $success = [];
        $success['result'] = true;
        $success['returnCode'] = 200;
        $success['message'] = '成功';
        if ($model->save()) {
            echo 'success';
        } else {
            echo 'false';
        }
    }
}
