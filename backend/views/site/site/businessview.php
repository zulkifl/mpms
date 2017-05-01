<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>

<br><br><br>

<p>
    <?= Html::a(Yii::t('app', 'Manage Business'), ['/site/managebusiness'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="row body_1">

    <div class="col-md-8 business_box" style="margin-top: 1%;">

        <!-- Business Sale List Detail -->

        <div class="row">
            <div class="col-md-12">

                <h1>
                    <?= $model->add_title ?>
                </h1>

                <br >
                <b>
                    <?php
                    $cityObj = common\models\Cities::findOne($model->city);
                    $countryObj = common\models\Countries::findOne($model->country);

                    $city = $cityObj != null ? ", " . $cityObj->name : "";
                    $country = $countryObj != null ? ", " . $countryObj->name : "";

                    echo $model->address . $city . $country;

                    $galaryObj = common\models\Gallery::findOne(["option_id" => $model->id , "option_type"=>'0']);
                    //var_dump($galaryObj);
                    $main_img = $galaryObj != null ? @$galaryObj->image_path : "";
                    ?>
                </b>
                <?php if (!empty($main_img)) { ?>
                    <br>
                    <img src="<?= 'http://bizbuysell.alfoze.com' . '/' . $main_img; ?>" class="img_adverting" />
                <?php } ?>
            </div>

        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6"><b><?= $model->generateAttributeLabel('price'); ?>:</b>$<?= $model->price; ?></div>
        </div>

        <div class="row" style="margin-top: 2%;">
            <?= $model->description; ?>   
        </div>

        <div class="row" style="margin-top: 4%;">
            <div class="col-md-3"><b>Optional Information:</b></div>
            <div class="col-md-9">

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b><?= $model->generateAttributeLabel('category_id'); ?></b></td>
                            <td>
                                <?php
                                $catObj = \common\models\Category::findOne($model->category_id);
                                echo $catObj != null ? $catObj->name : "";
                                ?>
                            </td>
                            <td>
                                <b><?= $model->generateAttributeLabel('employess'); ?></b>
                            </td>
                            <td><?= $model->employess; ?></td>
                        </tr>

                        <tr>
                            <td><b><?= $model->generateAttributeLabel('established_year'); ?></b></td>
                            <td>
                                <?= $model->established_year; ?>
                            </td>
                            <td>
                                <b><?= $model->generateAttributeLabel('gross_revenue'); ?></b>
                            </td>
                            <td>
                                <?= $model->gross_revenue; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b><?= $model->generateAttributeLabel('real_estate'); ?></b></td>
                            <td>
                                <?php
                                echo $model->real_estate == 1 ? "Yes" : "No";
                                ?>
                            </td>
                            <td>
                                <b><?= $model->generateAttributeLabel('training'); ?></b>
                            </td>
                            <td>
                                <?php
                                echo $model->training == 1 ? "Yes" : "No";
                                ?>
                            </td>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-top: 2%;">
            <div class="col-md-3"><b><?= $model->generateAttributeLabel('reason_of_selling'); ?>:</b></div>
            <div class="col-md-9">
                <p>
                    <?= $model->reason_of_selling; ?>
                </p>  
            </div>
        </div>

        <div class="row" style="margin-top: 2%;">
            <div class="col-md-3"><b><?= $model->generateAttributeLabel('facilities'); ?>:</b></div>
            <div class="col-md-9">
                <?= $model->facilities; ?>
            </div>
        </div>

        <div class="row" style="margin-top: 2%;">
            <div class="col-md-3"><b><?= $model->generateAttributeLabel('website'); ?>:</b></div>
            <div class="col-md-9">
                <?= $model->website; ?>
            </div>
        </div>
        <?php if (!empty($model->video_link)) { ?>
            <div class="row" style=" margin-top: 3%;">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <iframe src="<?= $model->video_link; ?>" style="width: 100%; height: 315px;" frameborder="0" allowfullscreen></iframe>
                </div>

            </div>

        <?php } ?>

    </div>
</div>