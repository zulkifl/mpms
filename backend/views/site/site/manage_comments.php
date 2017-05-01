<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel \common\models\CommunityCommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manage Community Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="community-comments-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
         <?php if (Yii::$app->session->getFlash('s_mesage')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?= Yii::$app->session->getFlash('s_mesage'); ?>
        </div>
    <?php } ?>
        <?php //Html::a(Yii::t('app', 'Create Community Comments'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'discussion:ntext',
             [
                'attribute' => 'User Name',
                'content' => function($data) {
        $cname= \common\models\User::findOne(['id'=>$data->user_id]);
        
            $data=$cname->username;
            return $data;
        },
               // 'filter' => Html::activeDropDownList($searchModel, 'type', ArrayHelper::map([['type' => 1, 'name' => Yii::t('app', "Looking for business")], ['type' => 2, 'name' => Yii::t('app', "General Discussion")], ['type' => 3, 'name' => Yii::t('app', " Business")]], 'type', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Community Type')]),
            ],
            'c_timestamp',
              [
                'attribute' => 'Community Type',
                'content' => function($data) {
        $cType=  \common\models\Community::findOne(['id'=>$data->community_id]);
            if ($cType->type == 1) {
                $data = 'Looking For Business';
               
            } 
            else if ($cType->type == 2)
            {
             $data = 'General Discussion';   
            }
            else {

                $data = 'Business';   
            }
            return $data;
        },
               // 'filter' => Html::activeDropDownList($searchModel, 'type', ArrayHelper::map([['type' => 1, 'name' => Yii::t('app', "Looking for business")], ['type' => 2, 'name' => Yii::t('app', "General Discussion")], ['type' => 3, 'name' => Yii::t('app', " Business")]], 'type', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Community Type')]),
            ],
            [
                'attribute' => 'Action',
                'content' => function($data) {
            

                $data = Html::a('', ['site/comment_del', 'id' => $data->id ,],['class'=>'glyphicon glyphicon-trash del_c']);
               
            
            return $data;
        },
      ],
                   [
                'attribute' => 'Expel',
                'content' => function($data) {
            

                $data = Html::a('Expel', ['site/user_expel', 'id' => $data->user_id ,],['class'=>'']);
               
            
            return $data;
        },
      ],
                
        ],
    ]); ?>

</div>
