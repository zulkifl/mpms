<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unames-index">


    <p>
             <?= Html::a(Yii::t('app', 'Create') . ' ' . common\config\Options::getOptionName(common\config\Controller2::USERS), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Export') . ' ' . common\config\Options::getOptionName(common\config\Controller2::USERS), ['export'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'f_name',
            'l_name',
            'email',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}'],
        ],
    ]);
    ?>

</div>
