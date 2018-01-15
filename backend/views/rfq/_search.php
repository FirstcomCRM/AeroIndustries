<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchRfq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rfq-search">

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
                <?= $form->field($model, 'date')->textInput(['autocomplete' => 'off', 'placeholder' => 'Date','id' => 'datepicker'])->label(false) ?>
            </div>
            <div class='col-sm-3 col-xs-12'>    
                <?= $form->field($model, 'supplier_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Supplier'])->label(false) ?>
            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'quotation_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Quotation No.'])->label(false) ?>
            </div> 
            <div class='col-sm-3 col-xs-12'>    
                <?= $form->field($model, 'manufacturer')->textInput(['autocomplete' => 'off', 'placeholder' => 'Manufacturer'])->label(false) ?>
            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'trace_certs')->textInput(['autocomplete' => 'off', 'placeholder' => 'Trace Cert'])->label(false) ?>
            </div>   
    <?php // echo $form->field($model, 'remark')->textInput(['autocomplete' => 'off', 'placeholder' => 'Work Order No.'])->label(false) ?>

    <?php // echo $form->field($model, 'deleted')->textInput(['autocomplete' => 'off', 'placeholder' => 'Work Order No.'])->label(false) ?>

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
