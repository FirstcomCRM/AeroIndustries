<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

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

                        <table class="table table-striped table-bordered">
                            <?php foreach ($tidDetails as $key => $tidD) {?>
                            <?php $partId = $tidD['part_id']; ?>
                            <?php $toolId = $tidD['tool_id']; ?>
                            <?php $serialNo = $tidD['serial_no']; ?>
                            <thead>
                                <tr>
                                    <th>Tool</th>
                                    <th>Description</th>
                                    <th>Manufacturer</th>
                                    <th>Model</th>
                                    <th>Serial No.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group field-calibration-tool_id">
                                            <input type="text" id="calibration-tool_id" class="form-control" value="<?=$partId?$dataPart[$partId]:''?>" readonly>
                                            <input type="hidden" name="Calibration[tool_id][]" value="<?=$toolId?>">
                                        </div>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'description[]')->textInput(['maxlength' => true])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'manufacturer[]')->textInput(['maxlength' => true])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'model[]')->textInput(['maxlength' => true])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'serial_no[]')->textInput(['maxlength' => true])->label(false) ?>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Storage Location</th>
                                    <th>Conditional Approval</th>
                                    <th>Acceptance Criteria</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?= $form->field($model, 'storage_location[]')->dropDownList($dataStorage,['class' => 'select2'])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'con_approval[]')->textInput()->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'acceptance_criteria[]')->textInput()->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'date[]')->textInput(['id' => 'datepicker1'])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($model, 'due_date[]')->textInput(['id' => 'datepicker2'])->label(false) ?>
                                    </td>
                                </tr>
                            </tbody>

                            <thead>
                                <tr>
                                    <th colspan="5">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?= $form->field($atta, 'attachment[]')->fileInput()->label(false) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5"><hr></td>
                                </tr>
                            </tbody>

                            <?php } /* foreach e */ ?> 
                        </table>
   
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