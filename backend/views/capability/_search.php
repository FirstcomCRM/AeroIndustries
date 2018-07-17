<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCapability */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capability-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>
            <div class='col-sm-2 col-xs-12'>

                <?= $form->field($model, 'part_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Part No.'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>

                <?= $form->field($model, 'description')->textInput(['autocomplete' => 'off', 'placeholder' => 'Description'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>

                <?= $form->field($model, 'manufacturer')->textInput(['autocomplete' => 'off', 'placeholder' => 'Manufacturer'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>

                <?= $form->field($model, 'workscope')->textInput(['autocomplete' => 'off', 'placeholder' => 'Work Scope'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>

                <?= $form->field($model, 'capability_type')->textInput(['autocomplete' => 'off', 'placeholder' => 'Capability Type'])->label(false) ?>

            </div>

        <div class="col-sm-2 text-right">
            <div class="form-group">
                <?= Html::submitButton('<i class=\"fa fa-search\"></i> Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>

            </div>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
