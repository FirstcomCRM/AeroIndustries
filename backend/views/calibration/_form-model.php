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


use common\models\StorageLocation;
use common\models\Part;

$dataStorage = StorageLocation::dataLocation();
$dataPart = Part::dataPart();
$dataPartDesc = Part::dataPartDesc();
/* @var $this yii\web\View */
/* @var $model common\models\Calibration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calibration-form">
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
                        <div class="form-group field-calibration-tool_id has-success">
                            <div class="col-sm-3 text-right">
                                <label class="control-label" for="calibration-tool_id">Tool</label>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                            <input type="text" id="calibration-tool_id" class="form-control" value="<?=$partId?$dataPart[$partId]:''?>" readonly>
                            <input type="hidden" name="Calibration[tool_id]" value="<?=$model->tool_id?>">
                            </div>

                            <div class="help-block"></div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'description', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true,'value' => $partId?$dataPartDesc[$partId]:'']) ?>

                    </div>

                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'manufacturer', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                    </div>         


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'model', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                    </div>   
  
  
                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'serial_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true,'value' => $serialNo]) ?>

                    </div>  


                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'storage_location', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->dropDownList($dataStorage,['class' => 'select2']) ?>

                    </div>    
                   
                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'con_approval', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput() ?>

                    </div>    

                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'acceptance_criteria', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                    </div>    

                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['id' => 'datepicker1']) ?>

                    </div>    

                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'due_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['id' => 'datepicker2']) ?>

                    </div>    

                    <?php /* 
                    <div class="col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'con_limitation', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                    </div>    
                    */ ?> 
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