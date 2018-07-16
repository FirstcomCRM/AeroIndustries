<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchWorkOrderArc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-order-arc-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

            <div class='col-sm-3 col-xs-12'>
                <?= $form->field($model, 'work_order_no')->textInput(['placeholder' => 'Work Order No.'])->label(false) ?>
            </div>
            <div class='col-sm-3 col-xs-12'>
                <?= $form->field($model, 'date')->textInput(['placeholder' => 'Date','id' => 'datepicker'])->label(false) ?>
            </div>
            <div class='col-sm-3 col-xs-12'>
            <?php 
                $type = ['EASA' => 'EASA', 'FAA' => 'FAA', 'CAAS' => 'CAAS', 'COC' => 'COC'];
            ?>
                <?= $form->field($model, 'type')->dropDownList($type, ['prompt' => 'Select Type'])->label(false) ?>
            </div>

    <?php // echo $form->field($model, 'second_check')->textInput(['placeholder' => 'Description'])->label(false) ?>

    <?php // echo $form->field($model, 'form_tracking_no')->textInput(['placeholder' => 'Description'])->label(false) ?>

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
