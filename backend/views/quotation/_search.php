<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SearchQuotation */
/* @var $form yii\widgets\ActiveForm */
use common\models\Currency;
$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
?>

<div class="quotation-search">

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
                <?= $form->field($model, 'quotation_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Quotation No.'])->label(false) ?>
            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'customer_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Customer Name'])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'from_date')->textInput(['id' => 'datepicker', 'autocomplete' => 'off', 'placeholder' => 'From Date', 'readonly' => true])->label(false) ?>
            </div>    
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'to_date')->textInput(['id' => 'datepicker1', 'autocomplete' => 'off', 'placeholder' => 'To Date', 'readonly' => true])->label(false) ?>
            </div>    
            
            <div class="col-sm-2">
                <?= $form->field($model, 'p_currency')->dropDownList($dataCurrency,['prompt' => 'All Currency'])->label(false) ?>
            </div>


            <div class="col-sm-12 text-right">
                <div class="form-group">
                    <?= Html::submitButton('<i class=\'fa fa-search\'></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
