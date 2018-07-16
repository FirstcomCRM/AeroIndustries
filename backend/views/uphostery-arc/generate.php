<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Setting;
$dataWorkStatus = Setting::dataWorkStatus();
$dataArcStatus = Setting::dataArcStatus();

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

/* @var $this yii\web\View */
/* @var $model common\models\UphosteryArc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="uphostery-arc-form">
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

                            <?= $form->field($model, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                            '])->textInput(['id' => 'datepicker1', 'autocomplete' => 'off' ,'readonly' => true]) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'arc_status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                '])->dropDownList($dataArcStatus) 
                            ?>
                        </div> 
                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'arc_remarks', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                '])->textArea(['maxlength' => true,'rows' => 8]) 
                            ?>
                        </div> 


                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'name', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                            '])->textInput() ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{hint}{error}</div>
                            '])->dropDownList($dataType, ['class' => 'select2 form-control','prompt' => '']) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'first_check', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{hint}{error}</div>
                            '])->checkbox() ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'second_check', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{hint}{error}</div>
                            '])->checkbox() ?>

                        </div>    
                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'third_check', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{hint}{error}</div>
                            '])->checkbox() ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'forth_check', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{hint}{error}</div>
                            '])->checkbox() ?>

                        </div>    
                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'is_tracking_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{hint}{error}</div>
                            '])->checkbox() ?>

                        </div>    
                        
                        <div class="col-sm-12 text-right">

    		            <br>
    					    <div class="form-group">
                            <?= Html::submitButton('<i class="fa fa-save"></i> Generate', [
                                    'class' => 'btn btn-primary',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to generate ARC?',
                                    ],
                                ]) ?>

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