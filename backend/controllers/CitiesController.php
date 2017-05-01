<?php

namespace backend\controllers;

use Yii;
use common\models\Cities;
use common\models\CitiesSearch;
use common\config\Controller3;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Countries;
use yii\filters\AccessControl;

/**
 * CitiesController implements the CRUD actions for Cities model.
 */
class CitiesController extends Controller3 {

    public $mainMenu = 200;
    public $submenu = 205;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['export', 'index', 'update', 'view', 'delete', 'create'],
                        
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionExport() {
        if (Yii::$app->user->identity->is_admin != '1') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $fields = array('index', 'name');
        $data = \common\models\Cities::find()->all();
        $this->sendAsXLS(\common\config\Options::getOptionName(Controller3::CITY) . '_file', $data, '', true, $fields);
    }

    /**
     * Lists all Cities models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cities model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Cities();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('createSuccess'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
                    'model' => $model
        ]);
    }

    /**
     * Updates an existing Cities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('updateSuccess'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
                    'model' => $model
        ]);
    }

    /**
     * Deletes an existing Cities model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Cities::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
