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

/* @var $this yii\web\View */
/* @var $model common\models\Rfq */
/* @var $form yii\widgets\ActiveForm */
use common\models\Supplier;

$dataSupplier = Supplier::dataSupplier();

?>

<div class="rfq-form">
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
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['id' => 'datepicker','readonly' => true]) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'supplier_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->dropDownList($dataSupplier,['class' => 'select2']) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'quotation_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>  

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'manufacturer', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput() ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'trace_certs', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput() ?>

                        </div>    
  

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textarea(['rows' => 6]) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12" style="padding-top:10px">
                           <?= $form->field($atta, 'attachment[]', [
                                  'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                ])
                                ->widget(FileInput::classname(), [
                                'options' => ['accept' => 'image/*'],
                            ])->fileInput(['multiple' => true,])->label('Upload Attachment(s)') ?>
                        </div>   
                        <?php if (isset($currAtta)) { ?>
                            <div class="col-sm-12">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <?php foreach ($currAtta as $curA) { ?>
                                        <?php 
                                            $currentAttachmentClass = explode('\\', get_class($curA))[2];
                                            $fileNameOnlyEx = explode('-', $curA->value);
                                        ?>
                                        <div class="col-sm-3 col-xs-12">
                                            <a href="<?= 'uploads/rfq/' .$curA->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a> 
                                            <?= Html::a(' <i class="fa fa-close"></i> ', ['rfq/remove-atta', 'id' => $curA->id], [
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to remove this attachment?',
                                                ],
                                            ]) ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        
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