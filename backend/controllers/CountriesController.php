<?php

namespace backend\controllers;

use Yii;
use common\models\Countries;
use common\models\CountriesSearch;
use common\config\Controller3;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CountriesController implements the CRUD actions for Countries model.
 */
class CountriesController extends Controller3 {

    public $mainMenu = 200;
    public $submenu = 202;

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
        $fields = array('index', 'name', 'city');
        $data = \common\models\Countries::find()->all();
        $this->sendAsXLS(\common\config\Options::getOptionName(Controller3::COUNTRY) . '_file', $data, '', true, $fields);
    }

    /**
     * Lists all Countries models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CountriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Countries model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Countries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Countries();
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
     * Updates an existing Countries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
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
     * Deletes an existing Countries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        \common\models\Cities::deleteAll(['country_id' => $id]);
        $this->findModel($id)->delete();
        \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('deleteSuccess'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Countries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Countries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Countries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
