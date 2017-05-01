<?php

namespace backend\controllers;

use Yii;
use common\models\Serviceprovider;
use common\models\ServiceproviderSearch;
use common\config\Controller3;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ServiceproviderController implements the CRUD actions for Serviceprovider model.
 */
class ServiceproviderController extends Controller3 {

    public $mainMenu = 200;
    public $submenu = 203;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['export', 'import', 'index', 'update', 'view', 'delete', 'create'],
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

    public function actionImport() {

        if (Yii::$app->user->identity->is_admin != '1') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new \common\models\FileForm();

        if ($model->load(Yii::$app->request->post())) {
            set_time_limit(3000);
            \PHPExcel_Calculation::getInstance()->writeDebugLog = true;
//var_dump(Yii::$app->request->post());
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            $filePath = 'uploads/' . $model->par1 . "." . $model->file->extension;
            $model->file->saveAs($filePath);

            try {
                $inpFileType = \PHPExcel_IOFactory::identify($filePath);
                $objReader = \PHPExcel_IOFactory::createReader($inpFileType);
                $objPHPExcel = $objReader->load($filePath);
            } catch (yii\base\Exception $e) {
                die('Error');
            }
            $sheet = $objPHPExcel->getSheet(0);
            $hRow = $sheet->getHighestRow();
            $hColumn = $sheet->getHighestColumn();
            $counter = 0;
            $ErrorCounter = 0;
            $total = 0;
            $errorRows = "";
            for ($row = 1; $row <= $hRow; $row++) {
                if ($row == 1) {
                    continue;
                }
                $total ++;
                try {
                    $rowData = $sheet->rangeToArray('A' . $row . ":" . $hColumn . $row, NULL, TRUE, FALSE)[0];
                } catch (\PHPExcel_Calculation_Exception $e) {
                    \Yii::$app->getSession()->setFlash("info $row", 'Error were encountered while reading excel file.<br>' . $e->getMessage());
                    $ErrorCounter++;
                    $errorRows .= $row . ",";
                    continue;
                }

                $name = trim((String) $sheet->getCellByColumnAndRow(0, $row)->getValue());
                if ($name != "") {
                    $sp = new Serviceprovider();

                    $phone = trim((String) $sheet->getCellByColumnAndRow(2, $row)->getValue());
                    $mobile = trim((String) $sheet->getCellByColumnAndRow(1, $row)->getValue());
                    $phone = str_replace(" ", "", $phone);
                    $phone = str_replace("(", "", $phone);
                    $phone = str_replace(")", "", $phone);
                    $mobile = str_replace(" ", "", $mobile);
                    $mobile = str_replace("(", "", $mobile);
                    $mobile = str_replace(")", "", $mobile);

                    $sp->name = $name;
                    $sp->mobile = $mobile;
                    $sp->phone = $phone;
                    $sp->address = trim((String) $sheet->getCellByColumnAndRow(4, $row)->getValue());
                    $sp->address2 = trim((String) $sheet->getCellByColumnAndRow(5, $row)->getValue());
                    $sp->email = trim((String) $sheet->getCellByColumnAndRow(7, $row)->getValue());
                    $sp->website = trim((String) $sheet->getCellByColumnAndRow(8, $row)->getValue());
                    $sp->keywords = trim((String) $sheet->getCellByColumnAndRow(9, $row)->getValue());
                    $sp->services = trim((String) $sheet->getCellByColumnAndRow(10, $row)->getValue());


                    $category_id = null;
                    $city_id = null;

                    $category = strtolower(trim((String) $sheet->getCellByColumnAndRow(3, $row)->getValue()));
                    $city = strtolower(trim((String) $sheet->getCellByColumnAndRow(6, $row)->getValue()));

                    $c = \common\models\Category::find()->where("name like '%$category%'")->one();
                    if ($c != null) {
                        $category_id = $c->id;
                    }


                    $c2 = \common\models\Cities::find()->where("name like '%$city%'")->one();
                    if ($c2 != null) {
                        $city_id = $c2->id;
                    }

                    $sp->category_id = $category_id;
                    $sp->city_id = $city_id;


                    if ($sp->save()) {
                        $counter++;
                    } else {
                        $ErrorCounter++;
                        $errorRows .= $row . " , ";
                        
                    }
                }
            }
            \Yii::$app->getSession()->setFlash('success', $counter . '/' . $total . ' Service Provider(s) added/updated successfully.');

            if ($ErrorCounter > 0) {
                \Yii::$app->getSession()->setFlash('danger', $ErrorCounter . ' Error(s) were encountered while importing service provider records.<br>' .
                        "At row(s) : $errorRows ");
            }

            if ($ErrorCounter == 0)
                return $this->redirect(['index']);
        }
        return $this->render('import', [
                    'model' => $model
        ]);
    }

    /**
     * Lists all Serviceprovider models.
     * @return mixed
     */
    public function actionExport() {
        if (Yii::$app->user->identity->is_admin != '1') {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $fields = array('index', 'name', 'mobile', 'phone', 'email', 'address', 'city', 'country', 'category', 'website', 'keywords', 'services');
        $data = \common\models\Serviceprovider::find()->all();
        $this->sendAsXLS('ServiceProviders_file', $data, '', true, $fields);
    }

    public function actionIndex() {
        $searchModel = new ServiceproviderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Serviceprovider model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Serviceprovider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Serviceprovider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('createSuccess'));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Serviceprovider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('updateSuccess'));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Serviceprovider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        \Yii::$app->getSession()->setFlash('success', \common\config\Options::getUNames('deleteSuccess'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Serviceprovider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Serviceprovider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Serviceprovider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
