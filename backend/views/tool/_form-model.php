<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Part;
use common\models\Unit;
use common\models\StorageLocation;
$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

$dataSupplier = Supplier::dataSupplier();
$dataLocation = StorageLocation::dataLocation();
$dataPartTool = Part::dataPartTool();
$dataUnit = Unit::dataUnit();
/* @var $this yii\web\View */
/* @var $model common\models\Tool */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tool-form">
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
                                {error}'])->dropDownList($dataSupplier,['class' => 'select2 form-control']) ?>
                        </div>    
 
                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'general_po_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'storage_location_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->dropDownList($dataLocation,['class' => 'form-control select2']) ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'receiver_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'part_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->dropDownList($dataPartTool,['class' => 'form-control select2']) ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'desc', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['maxlength' => true]) ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'batch_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['maxlength' => true]) ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'note', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['maxlength' => true]) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'quantity', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                        </div>     

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'unit_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->dropDownList($dataUnit,['class' => 'form-control select2']) ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'unit_price', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['maxlength' => true]) ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'shelf_life', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'hour_used', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'time_used', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'expiration_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['id' => 'datepicker']) ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'received', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['id' => 'datepicker2']) ?>
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
