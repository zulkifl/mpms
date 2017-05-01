<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => \Yii::t('app','There is no user with such email.')
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => \Yii::t('app', 'Email'),
            ];
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    // 'status' => User::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }
            if ($user->save()) {


                $to = $this->email;
                $subject = "Password reset for " . \Yii::$app->name;

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
				<p><a href=".Yii::$app->urlManager->createAbsoluteUrl(['/site/reset-password', 'token'=>$user['password_reset_token']]) . ">Reset Password</a></p>
				
				</body>
				</html>
				";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: admin' . "\r\n";

                mail($to, $subject, $message, $headers);
                return '1';
           
            }
        }

        return false;
    }

}
