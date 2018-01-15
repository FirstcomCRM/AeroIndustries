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

/* @var $this yii\web\View */
/* @var $model common\models\Template */
/* @var $form yii\widgets\ActiveForm */

$dataLocation = ArrayHelper::map(StorageLocation::find()->where(['<>','status','inactive'])->all(), 'id', 'name');

?>

<div class="template-form">
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

                                    <?= $form->field($model, 'part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                        {hint}
                                        '])->textInput(['maxlength' => true]) ?>

                                </div>    

                                <div class="col-sm-12 col-xs-12">    

                                    <?= $form->field($model, 'desc', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                        {hint}
                                        '])->textInput(['maxlength' => true]) ?>

                                </div>    

                                <div class="col-sm-12 col-xs-12">    

                                    <?= $form->field($model, 'remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                        {hint}
                                        '])->textInput(['maxlength' => true]) ?>

                                </div>    

                                <div class="col-sm-12 col-xs-12">    

                                    <?= $form->field($model, 'insert', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                        {hint}
                                        '])->textInput(['maxlength' => true]) ?>

                                </div>    

                                <div class="col-sm-12 col-xs-12">    

                                    <?= $form->field($model, 'location_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                        {hint}
                                        '])->dropDownList($dataLocation) ?>

                                </div>  
                                <div class="col-sm-12 col-xs-12">    

                                    <?= $form->field($model, 'alternative', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                        {hint}
                                        '])->textArea(['maxlength' => true]) ?>

                                </div>  
                                <?php /* $max = 8 ; $loop = 1 ; ?>

                                <?php  foreach ( $altEx as $leything ) { ?>

                                    <div class="col-sm-12 col-xs-12">    
                                        <div class="form-group field-template-insert">
                                            <div class="col-sm-3 text-right">
                                                <label class="control-label" for="template-insert">Alternate P/N</label>
                                            </div>
                                            <div class="col-sm-9 col-xs-12">
                                                <input type="text" class="form-control"  name="TemplateAlt[part_no][]" value="<?= $leything->part_no ?>" maxlength="45">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div> 

                                    <?php $loop ++ ; ?>

                                <?php } ?>

                                <?php if ( $loop < $max ) { ?>
                                    <?php while ( $loop < $max ) { ?>

                                    <div class="col-sm-12 col-xs-12">    
                                        <div class="form-group field-template-insert">
                                            <div class="col-sm-3 text-right">
                                                <label class="control-label" for="template-insert">Alternate P/N</label>
                                            </div>
                                            <div class="col-sm-9 col-xs-12">
                                                <input type="text" class="form-control"  name="TemplateAlt[part_no][]" maxlength="45">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div> 

                                        <?php $loop ++ ; ?>
                                    <?php } ?>
                                <?php } */ ?>

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
