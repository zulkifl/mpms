<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class FileForm extends Model
{
    public $file;
    public $par1;
    public $par2;
    public $par3;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['file'], 'required'],
            // rememberMe must be a boolean value
            [['file'], 'file'],
            // password is validated by validatePassword()
            [['par1','par2','par3'], 'safe'],
        ];
    }
}