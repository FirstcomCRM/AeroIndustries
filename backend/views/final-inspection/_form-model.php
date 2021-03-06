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

/* @var $this yii\web\View */
/* @var $model common\models\FinalInspection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="final-inspection-form">
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

                                    <?= $form->field($model, 'build', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput() ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'title', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    

                            <?= $form->field($model, 'form_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                          
                            <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                                'options' => ['rows' => 6],
                                'preset' => 'custom',
                                'clientOptions' => [
                                    'filebrowserUploadUrl' => '?r=site/url',
                                ]
                            ]) ?>

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