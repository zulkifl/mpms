<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model {

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Message'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email) {
        $message = $html;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= "From: $this->name <$this->email>" . "\r\n";
        $headers .= "Reply-To: $this->email" . "\r\n";

        return    mail($email, $this->subject, $this->body, $headers);
//        return Yii::$app->mailer->compose()
//                        ->setTo($email)
//                        ->setFrom([$this->email => $this->name])
//                        ->setSubject($this->subject)
//                        ->setTextBody($this->body)
//                        ->send();
    }

}