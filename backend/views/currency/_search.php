<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCurrency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-search">

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
                <?= $form->field($model, 'iso')->textInput(['autocomplete' => 'off', 'placeholder' => 'ISO'])->label(false) ?>
            </div>
            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Name'])->label(false) ?>
            </div>
            <div class="col-sm-2 col-xs-12">
                <?= $form->field($model, 'status')->dropDownList(['active' => 'Active', 'inactive' => 'Inactive'],['class' => 'select2 form-control','prompt' => 'All Status'])->label(false) ?>
            </div>

            <div class="col-sm-2 col-xs-12 pull-right">
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                     <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                </div>

            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
