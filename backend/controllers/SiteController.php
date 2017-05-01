<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Business;
use common\models\BusinessSearch;
use common\models\Franchise;
use common\models\FranchiseSearch;
use common\models\Cities;
use common\models\User;
use yii\web\UnauthorizedHttpException;
use common\models\CommunityComments;
use common\models\CommunityCommentsSearch;

/**
 * Site controller
 */
class SiteController extends \common\config\Controller3 {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','requestpasswordreset'],
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

    public function actionRequestpasswordreset() {
        $model = new \backend\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                \Yii::$app->getSession()->setFlash('s_mesage', Yii::t('app', 'Request for password submitted successfully. Please check your email.'));
                // return $this->redirect(Yii::$app->request->referrer);
                return $this->goHome();
            } else {
                \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
            }
        }
        return $this->render('requestPasswordResetToken', ['model' => $model,]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionIndex() {
        if (!\Yii::$app->user->isGuest) {
            $user = User::findByUsername(\Yii::$app->user->identity->username);
//            if (!$user->isAdmin) {
//                throw new UnauthorizedHttpException(Yii::t('app', 'Authorization Error!, you are not authorized to perform this action.'));
//            }
        }
        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            $user = User::findByUsername(\Yii::$app->user->identity->username);
//            if (!$user->isAdmin) {
//                throw new UnauthorizedHttpException(Yii::t('app', 'Authorization Error!, you are not authorized to perform this action.'));
//            }
            return $this->goHome();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = User::findByUsername(\Yii::$app->user->identity->username);
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

    public function actionRequestpassword() {

        return $this->render('reset_password_form');
    }

    public function actionRest_pass() {

        $email = Yii::$app->request->post('email');
        if ($email == null || $email == '') {
            \Yii::$app->getSession()->setFlash('s_error', 'Email Required. ');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $user = User::findOne(['email' => $email, 'is_admin' => 1]);
        if ($user != null) {
            $to = $email;
            $subject = "Password reset for Admin ";
            $token = $user['id'];

            $message = "
				<html>
				<head>
				<title>Password Reset</title>
				</head>
				<body>
				<p>Dear " . $user['username'] . ",
				<br>
				Click on below link to reset password. 
				</p>
				<p><a href=" . Yii::$app->urlManager->createAbsoluteUrl(['/site/reset-password', 'token' => base64_encode($token)]) . ">Reset Password</a></p>
				
				</body> 
				</html> 
				";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: ' . Yii::$app->params['name'] . "\r\n";

            mail($to, $subject, $message, $headers);

            \Yii::$app->getSession()->setFlash('s_mesage', 'Request for password submitted successfuly.Please check your email. ');
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            \Yii::$app->getSession()->setFlash('s_error', 'Sorry, we are unable to reset password for email provided. ');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
