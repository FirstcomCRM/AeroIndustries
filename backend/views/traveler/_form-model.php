<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use dosamigos\ckeditor\CKEditor;


$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

/*plugins*/
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model common\models\Worksheet */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="traveler-form">
    <section class="content">
        <?php $form = ActiveForm::begin(); ?>

            <div class="form-group text-right">
                <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Cancel', Url::to('?r='.$backUrl), array('class' => 'btn btn-default')) ?>
                &nbsp;
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Worksheet</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Content</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <div class="row">
                            <div class="col-xs-12">
                                
                                <div class="box-header with-border">
                                  <h3 class="box-title">Worksheet Details</h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body ">
                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'traveler_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'job_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'desc', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'effectivity', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'revision_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput() ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'revision_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['id' => 'datepicker', 'readonly' => true]) ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive'], ['class' => 'form-control']) ?>

                                    </div>  
                                    <?php 
                                        $model->status == 'inactive' ? $disc_class = '' : $disc_class = 'hidden' ;
                                    ?>
                                    <div class="col-sm-12 col-xs-12 disc-reas <?= $disc_class ?>">    

                                        <?= $form->field($model, 'discont_reason', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput() ?>

                                    </div>     
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            <div class="col-xs-12">
                                
                                <!-- /.box-header -->
                                <div class="box-body ">
                                    <div class="col-sm-12 col-xs-12">
                                       <?= $form->field($model, 'attachment', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                            ])
                                            ->widget(FileInput::classname())->fileInput()->label('Upload Attachment(s)') ?>
                                    </div> 
                                    <?php if ( $travelerLog ) { ?>
                                    <div class="col-sm-12 col-xs-12">
                                       <?= $form->field($travelerLog, 'description', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textArea(['row' => 3])->label('Description of revision') ?>
                                    </div> 
                                    <div class="col-sm-12 col-xs-12">
                                       <?= $form->field($travelerLog, 'revision_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput() ?>
                                    </div>  
                                    <div class="col-sm-12 col-xs-12">
                                       <?= $form->field($travelerLog, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['id' => 'datepicker1']) ?>
                                    </div>  
                                    <?php } ?> 
                                </div>
                            </div>

                        </div> 
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
<script type="text/javascript"> confi(); </script>
