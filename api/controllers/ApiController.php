<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use frontend\models\Trip;
use frontend\controllers\LogController;

/**
 * Site controller
 */
class ApiController extends Controller {

    private $_imgsize = 50;
    private $_noOfMessages = 100;
    private $_secKey = '3O57L9399K64IU6938HCGAFA2A2AB';

    /**
     * @inheritdoc
     */
    public function actionEcho() {
        return "I am Alive";
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionGetcategories() {
        $this->validateToken();

        
        $trips = \common\models\Category::findAll(['active'=>'1']);
        $data = array();
        foreach ($trips as $value) {
            $chunk = [];
            $chunk['id'] = $value->id;
            $chunk['name'] = $value->name;
            $chunk['description'] = $value->description;
            $data[] = $chunk;
        }
        $response = array();
        $response['Message'] = "Success";
        $response['Description'] = "List of Categories";
        $response['Code'] = 1;
        $response['Count'] = count($data);
        $response['data'] = $data;

        return $response;
    }

    private function getCities() {

        $trips = \common\models\Cities::findAll(['active'=>'1']);
        $data = array();
        foreach ($trips as $value) {
            $chunk = [];
            $chunk['id'] =  $value->id;
            $chunk['name'] =  $value->name;
            $chunk['state'] =  $value->country;
            
            $data[] = $chunk;
        }
        return $data;
    }

    public function actionGetcities() {
        $this->validateToken();

        $error = false;
        $data = array();
        $meesage = "List of Cities";
        $data = $this->getCities();

        $response = array();
        $response['Message'] = $error ? "Failed" : "Success";
        $response['Description'] = $meesage;
        $response['Code'] = $error ? 2 : 1;
        $response['Count'] = count($data);
        $response['data'] = $data;

        return $response;
    }

    public function actionGetstates() {
        $this->validateToken();

        
        $trips = \common\models\Countries::findAll(['active'=>'1']);;
        $data = array();
        foreach ($trips as $value) {
             $chunk = [];
            $chunk['id'] = $value->id;
            $chunk['name'] = $value->name;
            $data[] = $chunk;
        }

        $response = array();
        $response['Message'] = "Success";
        $response['Description'] = "List of States";
        $response['Code'] = 1;
        $response['Count'] = count($data);
        $response['data'] = $data;

        return $response;
    }

    public function actionGetserviceproviderdetail() {
        $this->validateToken();

        $error = false;
        $data = array();
        $meesage = "Service Provider Detail ";
        if (isset($_GET['providerId'])) {
            $providerId = $_GET['providerId'];
            $value = \common\models\Serviceprovider::findOne($providerId);
            if ($value != null) {
                $chunck = [];

                $chunck['id'] = $value->id;
                $chunck['name'] = $value->name;
                $chunck['address'] = $value->address;
                $chunck['address2'] = $value->address2;
                $chunck['city'] = $value->city;
                $chunck['country'] = $value->country;
                $chunck['category'] = $value->category;
                $chunck['category_id'] = $value->category_id;
                $chunck['email'] = $value->email;
                $chunck['website'] = $value->website;
                $chunck['keywords'] = $value->keywords;
                $chunck['phone'] = $value->phone;
                $chunck['mobile'] = $value->mobile;
                $chunck['services'] = $value->services;


                $data = $chunck;
            } else {
                $meesage = "Invalid service provider specified.";
                $error = true;
            }
        } else {
            $meesage = "Required parameter missing : providerId.";
            $error = true;
        }

        $response = array();
        $response['Message'] = $error ? "Failed" : "Success";
        $response['Description'] = $meesage;
        $response['Code'] = $error ? 2 : 1;
        $response['Count'] = count($data);
        $response['data'] = $data;

        return $response;
    }

    public function actionGetserviceproviders() {
        $this->validateToken();

        $error = false;
        $data = array();
        $meesage = "List of Service Providers";

        $catId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;
        $city = isset($_GET['cityId']) ? $_GET['cityId'] : null;
        
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

        $where = "1=1";
        if ($catId != null) {
            $where .= " and category_id='" . $catId . "'";
        }

        if ($city != null) {
            
            $where.=" and  city_id='" . $city . "'";
        }

        $query = \common\models\Serviceprovider::find()->select(['id','name','mobile']);
        $query = $query->where($where);


        $query = $query->offset($offset)->limit($this->_noOfMessages);
        $businesses = $query->all();

        foreach ($businesses as $value) {
            $chunck = [];
            $chunck['id'] = $value->id;
            $chunck['name'] = $value->name;
            $chunck['mobile'] = $value->mobile;
            $data[] = $chunck;
        }

        $response = array();
        $response['Message'] = $error ? "Failed" : "Success";
        $response['Description'] = $meesage;
        $response['Code'] = $error ? 2 : 1;
        $response['Count'] = count($data);
        $response['data'] = $data;

        return $response;
    }

    private function base64_to_image($base64_string, $output_file) {
        $ifp = fopen(__DIR__ . '/../../frontend/web/' . $output_file, "w");
        $data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $output_file;
    }

    private function validateToken() {
        $lang = null;
        $request = \Yii::$app->request;
        $accessToken = "";
        if ($request->isGet == true) {
            if (!isset($_GET['token'])) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action(1.3).'));
            }
            $accessToken = $_GET['token'];
        } elseif ($request->isPost == true) {
            $accessToken = $request->getBodyParam('token');
            if ($accessToken == null) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action(1.4).'));
            }
        }

        if ($accessToken != $this->_secKey) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action(3).'));
        }

        return true;
    }

}
