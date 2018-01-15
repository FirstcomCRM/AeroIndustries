<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

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
                <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Customer Name'])->label(false) ?>

            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => 'Email'])->label(false) ?>

            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'status')->dropDownList([ 1 => 'Active', 0 => 'Inactive'], ['class' => 'select2 form-control','prompt' => 'All Status'])->label(false) ?>

            </div>

            <div class="col-sm-2 col-xs-12">
                <?= $form->field($model, 'contact_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Contact No.'])->label(false) ?>
            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'contact_person')->textInput(['autocomplete' => 'off', 'placeholder' => 'Contact Person'])->label(false) ?>

            </div>    

    <?php // echo $form->field($model, 'addr_1') ?>
    <?php // echo $form->field($model, 'addr_2') ?>
    <?php // echo $form->field($model, 'email') ?>
    <?php // echo $form->field($model, 'contact_no') ?>
    <?php // echo $form->field($model, 'title') ?>
    <?php // echo $form->field($model, 's_addr_1') ?>
    <?php // echo $form->field($model, 's_addr_2') ?>
    <?php // echo $form->field($model, 'b_addr_1') ?>
    <?php // echo $form->field($model, 'b_addr_2') ?>
    <?php // echo $form->field($model, 'b_term') ?>
    <?php // echo $form->field($model, 'b_currency') ?>
    <?php // echo $form->field($model, 'status') ?>
    <?php // echo $form->field($model, 'created') ?>
    <?php // echo $form->field($model, 'updated') ?>

        <div class="col-sm-2 text-right">
            <div class="form-group">
                <?= Html::submitButton('<i class=\'fa fa-search\'></i> Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
