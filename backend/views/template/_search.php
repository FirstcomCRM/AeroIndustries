<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\StorageLocation;
/* @var $this yii\web\View */
/* @var $model common\models\SearchTemplate */
/* @var $form yii\widgets\ActiveForm */
$dataStorage = ArrayHelper::map(StorageLocation::find()->all(), 'id', 'name');
?>

<div class="template-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>
            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'part_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Part No.'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'desc')->textInput(['autocomplete' => 'off', 'placeholder' => 'Description'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'remark')->textInput(['autocomplete' => 'off', 'placeholder' => 'Remarks'])->label(false) ?>

            </div>

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'insert')->textInput(['autocomplete' => 'off', 'placeholder' => 'Insert'])->label(false) ?>

            </div>  

            <div class='col-sm-2 col-xs-12'>    

                <?= $form->field($model, 'location_id')->dropDownList($dataStorage, ['prompt' => 'All location'])->label(false) ?>

            </div>    
    <?php // echo $form->field($model, 'location_id') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'udpated_by') ?>

        <div class="col-sm-12 text-right">
            <div class="form-group">
                <?= Html::submitButton('<i class=\"fa fa-search\"></i> Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
