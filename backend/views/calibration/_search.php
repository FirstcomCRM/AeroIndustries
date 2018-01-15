<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\StorageLocation;
use common\models\Part;
/* @var $this yii\web\View */
/* @var $model common\models\SearchCalibration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calibration-search">

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

                <?= $form->field($model, 'tool_id')->dropDownList(Part::dataPartTool(),['prompt' => 'Description','class' => 'select2'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'storage_location')->dropDownList(StorageLocation::dataLocation(),['prompt' => 'Storage Location','class' => 'select2'])->label(false) ?>

            </div>

            <div class='col-sm-3 col-xs-12'>    

                <?= $form->field($model, 'description')->textInput(['placeholder' => 'Description'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'manufacturer')->textInput(['placeholder' => 'Manufacturer'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'model')->textInput(['placeholder' => 'Model'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'serial_no')->textInput(['placeholder' => 'Serial No'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'date')->textInput(['placeholder' => 'Date Calibrated','id' => 'datepicker'])->label(false) ?>

            </div>

    <?php // echo $form->field($model, 'storage_location') ?>

    <?php // echo $form->field($model, 'acceptance_criteria') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'due_date') ?>

    <?php // echo $form->field($model, 'con_approval') ?>

    <?php // echo $form->field($model, 'con_limitation') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

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
