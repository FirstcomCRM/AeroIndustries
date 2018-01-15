<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchDeliveryOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-order-search">

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
                <?= $form->field($model, 'delivery_order_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Delivery Order No.'])->label(false) ?>
            </div>
            <div class='col-sm-3 col-xs-12'>    
                <?= $form->field($model, 'customer_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Customer Name'])->label(false) ?>
            </div>  
            
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'from_date')->textInput(['id'=>'datepicker2', 'autocomplete' => 'off', 'placeholder' => 'From Date', 'readonly' => true])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'to_date')->textInput(['id'=>'datepicker1', 'autocomplete' => 'off', 'placeholder' => 'To Date', 'readonly' => true])->label(false) ?>
            </div> 

     <?php // echo $form->field($model, 'ship_to') ?>

    <?php // echo $form->field($model, 'contact_no') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'created_by') ?>

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
