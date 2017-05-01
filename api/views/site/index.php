
<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = \Yii::$app->params['name'];
?>
<div class="site-index">

    <h3>API List</h3>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <ul>
                <li>The response will be in json format</li>
                <li>Every response will contain at least three elements
                    <ul>
                        <li><b>Message</b> it would be 'Success' Or 'Failure' </li>
                        <li><b>Description</b> it is brief of response, it could be reason of failure</li>
                        <li><b>Code</b> it would be '1' Or '2'. 1 = Success ,2 = Failure </li>
                        <li> token = 3O57L9399K64IU6938HCGAFA2A2AB</li>
                    </ul>
                </li>

            </ul>
        </div>
        <div class="col-md-6">
            <ul>
                <li>You can access api using http://apimpms.alfoze.com/api/[functioname]</li>
                <li>A convention have been followed that if you are retrieving data <i>GET</i> method is used and if you are inserting or updating data <i>POST</i> method is used </li>
                <li>In <i>POST</i> request data is to be submitted in body parameters</li>
                <li>Where ever image is being retrieved or inserted base64 format is used</li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="row">
        <?php
        $list = \api\models\apis::apigetlist();
        foreach ($list as $key => $value) {
            echo '<div class="col-md-4">';
            echo Html::a($value['name'], Yii::$app->urlManager->createUrl(['site/viewapi', 'id' => $key, 'type'=>'get']));
            echo '</div>';
        }
        ?>
    </div>
    <hr>
    <div class="row">
        <?php
        $list = \api\models\apis::apipostlist();
        foreach ($list as $key => $value) {
            echo '<div class="col-md-4">';
            echo Html::a($value['name'], Yii::$app->urlManager->createUrl(['site/viewapi', 'id' => $key, 'type'=>'post']));
            echo '</div>';
        }
        ?>
    </div>
</div>
