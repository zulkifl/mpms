<?php

namespace api\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'viewapi'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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

    public function actionLogout() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionLogin() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;

        if (!\Yii::$app->user->isGuest) {
            $user = \common\models\User::findByUsername(\Yii::$app->user->identity->username);
            if (!$user->isAdmin) {
                throw new UnauthorizedHttpException(Yii::t('app', 'Authorization Error!, you are not authorized to perform this action.'));
            }
            return $this->goHome();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = \common\models\User::findByUsername(\Yii::$app->user->identity->username);
            if (!$user->isAdmin) {
                throw new UnauthorizedHttpException(Yii::t('app', 'Authorization Error!, you are not authorized to perform this action.'));
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIndex() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->render('index');
    }

    public function actionViewapi($id, $type) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        if ($type == 'get')
            $model = \api\models\apis::apigetlist()[$id];
        else
            $model = \api\models\apis::apipostlist()[$id];
        return $this->render('view', ['model' => $model]);
    }

}
