<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchTravelerLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="traveler-log-search">

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

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'description') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'date') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'revision_no') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'created') ?>

</div>    <?php // echo $form->field($model, 'created_by') ?>

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
