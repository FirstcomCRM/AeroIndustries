<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Tool */
/* @var $form yii\widgets\ActiveForm */
use kartik\file\FileInput;
?>

<div class="tool-form">
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Import Tool</h3><br>
                        <small>Please make sure supplier,unit and category are already created in the system before proceed.</small>
                    </div>
                    <div class="box-body ">
				    <?php $form = ActiveForm::begin(); ?>
                        <div class="col-sm-12 col-xs-12">
                             <?= $form->field($model, 'attachment', [
                                    'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                ])
                                ->fileInput()
                            ?>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <a href="uploads/tool/format.xlsx">Download Import Format</a>
                        </div>
                        <div class="col-sm-12 text-right">
        	            <br>
        				    <div class="form-group">
        				        <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
        	                    <button class="btn btn-default back-button">Cancel</button>
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