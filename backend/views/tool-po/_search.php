<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SearchPurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
use common\models\Currency;
$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
?>

<div class="box">
    <div class="tool-po-search">

        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>


        <div class="box-body">
            <div class="col-sm-2">
                <?= $form->field($model, 'supplier_company_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Company Name'])->label(false) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'supplier_ref_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Supplier Ref No.'])->label(false) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'purchase_order_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'PO No.'])->label(false) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'issue_date')->textInput(['id'=>'datepicker2', 'autocomplete' => 'off', 'placeholder' => 'Date Issued', 'readonly' => true])->label(false) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'approved')->dropDownList(['approved' => 'Approved', 'pending' => 'Pending', 'cancelled' => 'Cancelled'],['prompt' => 'Status'])->label(false) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'p_currency')->dropDownList($dataCurrency,['prompt' => 'All Currency'])->label(false) ?>
            </div>
        
            <div class="col-sm-12 text-right">
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
