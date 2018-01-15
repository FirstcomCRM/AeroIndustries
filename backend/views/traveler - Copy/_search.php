<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchTraveller */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="traveler-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

            <div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'id') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'work_order_id') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'traveler_no') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'job_type') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'desc') ?>

</div>    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'effectivity') ?>

    <?php // echo $form->field($model, 'revision_no') ?>

    <?php // echo $form->field($model, 'revision_date') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'status') ?>

        <div class="col-sm-12 text-right">
            <div class="form-group">
                <?= Html::submitButton('<i class=\"fa fa-search\"></i> Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
