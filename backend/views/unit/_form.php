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
/* @var $model common\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-form">
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
                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                            {hint}
                            '])->textInput(['maxlength' => true]) ?>

                        </div>    

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'unit', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                            {hint}
                            '])->textInput(['maxlength' => true]) ?>

                        </div>      

                        <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($model, 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                            {hint}
                            '])->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['class' => 'select2 form-control','prompt' => '']) ?>

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