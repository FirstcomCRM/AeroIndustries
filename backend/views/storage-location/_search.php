<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchStorageLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storage-location-search">

    <div class="box">
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

            <div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'id') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'name') ?>

</div><div class='col-sm-3 col-xs-12'>    <?= $form->field($model, 'size') ?>

</div>        <div class="form-group">
            <?= Html::submitButton('<i class=\'fa fa-search\'></i> Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
