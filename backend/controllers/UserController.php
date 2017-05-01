<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use common\config\Controller3;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UnamesController implements the CRUD actions for Unames model.
 */
class UserController extends Controller3 {

    public $mainMenu = 200;
    public $submenu = 204;

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
                //  'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreate() {
        if (Yii::$app->user->identity->is_admin != '1') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new \backend\models\SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->pic = '';
            if ($user = $model->signup($model->pic)) {
                \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('createSuccess'));
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionExport() {
        if (Yii::$app->user->identity->is_admin != '1') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $fields = array('index', 'username', 'f_name', 'l_name', 'email');
        $data = \common\models\User::find()->all();
        $this->sendAsXLS(\common\config\Options::getOptionName(Controller3::USERS) . '_file', $data, '', true, $fields);
    }

    protected function uploadImage($model, $oldImage, $colname) {

        if (\yii\web\UploadedFile::getInstance($model, $colname)) {
            $fileObj = \yii\web\UploadedFile::getInstance($model, $colname);
            $filename = "";
            $dirpath = realpath(dirname(getcwd()));
            // $res = str_replace("backend", "frontend", $dirpath);
            $filename = 'uploads/' . uniqid() . $colname . $fileObj->name;
            $uploaddir = $dirpath;
            $fileObj->saveAs($uploaddir . "/web/" . $filename);
            return $filename;
        } else {
            return $oldImage;
        }
    }

    /**
     * Lists all Unames models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
//        var_dump($searchModel);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/user/index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unames model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $view = 'view';
        $model = $this->findModel($id);

        return $this->render('/user/' . $view, ['model' => $model]);
    }

    /**
     * Updates an existing Unames model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        if (Yii::$app->user->identity->is_admin != '1') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = $this->findModel($id);
        $pic = $model->pic;

        if ($model->load(Yii::$app->request->post())) {

            $uData = Yii::$app->request->post('User');
            $model->email = isset($uData['email']) ? $uData['email'] : "";
            $model->f_name = isset($uData['f_name']) ? $uData['f_name'] : "";
            $model->l_name = isset($uData['l_name']) ? $uData['l_name'] : "";
            $model->is_admin = isset($uData['is_admin']) ? $uData['is_admin'] : "0";
            $model->is_active = isset($uData['is_active']) ? $uData['is_active'] : "1";


            if (isset($uData['pic'])) {
                $model->pic = $this->uploadImage($model, $pic, 'pic');
            }
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('updateSuccess'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', ['model' => $model,]);
    }

    public function actionDelete($id) {
        if (Yii::$app->user->identity->is_admin != '1') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = User::findOne(['id' => $id]);
        $model->delete();
        \Yii::$app->getSession()->setFlash('s_mesage', 'Business Successfully Deleted. ');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Unames model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Unames the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
