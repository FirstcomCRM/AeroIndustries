<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);

$backUrl = $exBackUrlFull[1];

use common\models\Currency;
use common\models\Supplier;
/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
?>

<div class="purchase-order-form">
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= $subTitle ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body ">
				    <?php $form = ActiveForm::begin(); ?>

                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'supplier_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->dropDownList($dataSupplier)->label('Supplier') ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'supplier_ref_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'purchase_order_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'issue_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['id'=>'datepicker']) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'delivery_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['id'=>'datepicker']) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'p_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'p_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->dropDownList($dataCurrency)->label('Payment Currency')?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'ship_via', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'ship_to', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'subtotal', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'subj_gst', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->dropDownList([1=>'Yes',2=>'No']) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'grand_total', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                        <div class="col-sm-9 col-xs-12">{input}</div>
                        {hint}
                        {error}'])->textInput(['maxlength' => true]) ?>
                    </div>
	  

                    <div class="col-sm-12 text-right">
		            <br>
					    <div class="form-group">
					        <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
		                    <?= Html::a( 'Cancel', Url::to('?r='.$backUrl), array('class' => 'btn btn-default')) ?>
					    </div>
				    </div>

				    <?php ActiveForm::end(); ?>
				    </div>
			    </div>
		    </div>
	    </div>
    </section>
</div>
