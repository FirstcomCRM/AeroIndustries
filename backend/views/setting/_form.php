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
/* @var $model common\models\Setting */
/* @var $form yii\widgets\ActiveForm */
$settingSelection = [
	'product_type' => 'Product Type',
	'arc_status' => 'ARC Status',
	'job_type' => 'Job Type',
	'work_status' => 'Work Status',
	'email_calibration' => 'Calibration Email Notification',
	'id_tag_type' => 'ID Tag Type',
	'identify_from' => 'Part Number Identification',
	'PO Email Notification'=>'PO email notification',
	'GPO Email Notification'=>'GPO email notification',
	'TPO Email Notification'=>'TPO email notification',
	'Stocks Received Email Notification'=>'Stocks Received Email Notification',
];
?>

<div class="setting-form">
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

					    	<?= $form->field($model, 'name', ['template' => '<div class="col-sm-3 text-right">{label}</div>
								<div class="col-sm-9 col-xs-12">{input}</div>
								{hint}
								{error}'])->dropDownList($settingSelection,['maxlength' => true]) ?>

	   					</div>

	    				<div class="col-sm-12 col-xs-12">

		    				<?= $form->field($model, 'desc', ['template' => '<div class="col-sm-3 text-right">{label}</div>
								<div class="col-sm-9 col-xs-12">{input}</div>
								{hint}
								{error}'])->textInput(['maxlength' => true]) ?>

					    </div>

					    <div class="col-sm-12 col-xs-12">

						    <?= $form->field($model, 'value', ['template' => '<div class="col-sm-3 text-right">{label}</div>
								<div class="col-sm-9 col-xs-12">{input}</div>
								{hint}
								{error}'])->textInput(['maxlength' => true]) ?>

					    </div>


					    <div class="col-sm-12 col-xs-12">

						    <?= $form->field($model, 'value_2', ['template' => '<div class="col-sm-3 text-right">{label}</div>
								<div class="col-sm-9 col-xs-12">{input}</div>
								{hint}
								{error}'])->textInput(['maxlength' => true]) ?>

					    </div>


					    <div class="col-sm-12 col-xs-12">

						    <?= $form->field($model, 'sort', ['template' => '<div class="col-sm-3 text-right">{label}</div>
								<div class="col-sm-9 col-xs-12">{input}</div>
								{hint}
								{error}'])->textInput(['maxlength' => true]) ?>

					    </div>

					    <div class="col-sm-12 text-right">
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

<script type="text/javascript"> confi(); </script>
