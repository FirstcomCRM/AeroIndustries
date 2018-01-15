<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

/* @var $this yii\web\View */
/* @var $model common\models\WorkOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-order-form">
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
							    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'work_order_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'customer_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'customer_po_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'received_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'qc_notes', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'inspection', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'corrective', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'disposition_note', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'hidden_damage', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'inspector', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'supervisor', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'arc_remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'created', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'created_by', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'updated', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'updated_by', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'approved', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->dropDownList([ 'approved' => 'Approved', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'closed' => 'Closed', ], ['class' => 'select2 form-control','prompt' => '']) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'deleted', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>		            <div class="col-sm-12 text-right">
		            <br>
					    <div class="form-group">
					        <?= Html::submitButton('<i class=\'fa fa-save\'></i> Save', ['class' => 'btn btn-primary']) ?>
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
