<?php
/**
 * @link https://github.com/himiklab/yii2-ckeditor-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\ckeditor;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * WYSIWYG HTML input widget for Yii2.
 * Using as field in ActiveForm:
 *
 * ```php
 * echo $form->field($model, 'text')->widget(CKEditor::className(), [
 *      'editorOptions' => ['height' => '500px']
 * ]);
 * ```
 *
 * Using inline:
 *
 * ```php
 * echo CKEditor::widget([
 *      'name' => 'comment',
 *      'value' => 'Please write your comment',
 *      'editorOptions' => ['height' => '500px'],
 *      'useBrowserSpellChecker' => true
 * ]);
 * ```
 *
 * @author HimikLab
 * @package himiklab\ckeditor
 */
class CKEditor extends InputWidget
{
    /**
     * @var array the options for the CKEditor 4 JS plugin
     * @see http://docs.ckeditor.com/#!/guide/dev_installation
     */
    public $editorOptions = [];

    /** @var bool Use the built-in words spell checker if browser provides one */
    public $useBrowserSpellChecker = false;

    public function init()
    {
        parent::init();

        $view = $this->getView();
        $id = Json::encode($this->options['id']);
        if ($this->useBrowserSpellChecker) {
            $this->editorOptions = ['disableNativeSpellChecker' => false] + $this->editorOptions;
        }

        $jsData = "CKEDITOR.replace($id";
        $jsData .= empty($this->editorOptions) ? '' : (', ' . Json::encode($this->editorOptions));
        $jsData .= ").on('blur', function(){this.updateElement(); jQuery(this.element.$).trigger('blur');});";

        $view->registerJs($jsData);
        CKEditorAsset::register($view);
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
    }
}
