<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchTpoSupplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tpo-supplier-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'company_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Company Name'])->label(false) ?>
        </div>

        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => 'Email'])->label(false) ?>
        </div>

        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'contact_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Contact No.'])->label(false) ?>
        </div>

        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'contact_person')->textInput(['autocomplete' => 'off', 'placeholder' => 'Contact Person'])->label(false) ?>
        </div>

        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'status')->dropDownList([ 1 => 'Active', 0 => 'Inactive'], ['class' => 'select2 form-control','prompt' => 'All Status'])->label(false) ?>
        </div>

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
