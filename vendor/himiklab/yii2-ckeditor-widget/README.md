CKEditor Widget for Yii2
========================

WYSIWYG HTML editor widget for Yii2 based on [CKEditor](http://ckeditor.com/).

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "himiklab/yii2-ckeditor-widget" "*"
```
or add

```json
"himiklab/yii2-ckeditor-widget" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----
Using as field in ActiveForm:

```php
use himiklab\ckeditor\CKEditor;


<?= $form->field($model, 'text')->widget(CKEditor::className(), [
    'editorOptions' => ['height' => '500px']
]) ?>
```

Using as inline field:

```php
use himiklab\ckeditor\CKEditor;

<?= CKEditor::widget([
    'name' => 'comment',
    'value' => 'Please write your comment',
    'editorOptions' => ['height' => '500px']
]) ?>
```
