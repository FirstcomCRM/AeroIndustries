<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\Setting;

/* @var $this yii\web\View */
/* @var $model common\models\SearchWorkOrder */
/* @var $form yii\widgets\ActiveForm */
$dataWorkType = Setting::dataWorkType();
$dataWorkScope = Setting::dataWorkScope();
$dataWorkStatus = Setting::dataWorkStatus();
?>

<div class="work-order-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>


        
            <div class="col-sm-2 col-xs-12">    
                <?= $form->field($model, 'work_type')->dropDownList($dataWorkType,['prompt' => 'All Work Type'])->label(false) ?>
            </div>  

        
            <div class="col-sm-2 col-xs-12">    
                <?= $form->field($model, 'work_scope')->dropDownList($dataWorkScope,['prompt' => 'All Work Scope'])->label(false) ?>
            </div>   

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'work_order_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Work Order No.'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'customer_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Customer Name'])->label(false) ?>

            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?php /* $form->field($model, 'part_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Part No.'])->label(false)*/ ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'customer_po_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Customer PO'])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'from_date')->textInput(['id' => 'datepicker', 'autocomplete' => 'off', 'placeholder' => 'From Date', 'readonly' => true])->label(false) ?>
            </div>    

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'to_date')->textInput(['id' => 'datepicker1', 'autocomplete' => 'off', 'placeholder' => 'To Date', 'readonly' => true])->label(false) ?>
            </div>    

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'status')->dropDownList($dataWorkStatus,['prompt' => 'All Status'])->label(false) ?>
            </div>    
            
    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'part_no') ?>

    <?php // echo $form->field($model, 'received_date') ?>

    <?php // echo $form->field($model, 'qc_notes') ?>

    <?php // echo $form->field($model, 'inspection') ?>

    <?php // echo $form->field($model, 'corrective') ?>

    <?php // echo $form->field($model, 'disposition_note') ?>

    <?php // echo $form->field($model, 'hidden_damage') ?>

    <?php // echo $form->field($model, 'inspector') ?>

    <?php // echo $form->field($model, 'supervisor') ?>

    <?php // echo $form->field($model, 'arc_remark') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'approved') ?>

    <?php // echo $form->field($model, 'deleted') ?>

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
