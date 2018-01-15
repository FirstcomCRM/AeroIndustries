<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\Part;
use common\models\Supplier;
use common\models\StorageLocation;

/* @var $this yii\web\View */
/* @var $model common\models\SearchTool */
/* @var $form yii\widgets\ActiveForm */

$dataPart = ArrayHelper::map(Part::find()->where(['type' => 'tool'])->all(), 'id', 'part_no');
$dataStorage = ArrayHelper::map(StorageLocation::find()->all(), 'id', 'name');
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');

?>

<div class="tool-search">

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
               <?= $form->field($model, 'supplier_id')->dropDownList($dataSupplier, ['class' => 'select2 form-control','prompt' => 'All Supplier'])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'part_id')->dropDownList($dataPart, ['class' => 'select2 form-control','prompt' => 'All Parts'])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'storage_location_id')->dropDownList($dataStorage, ['class' => 'select2 form-control','prompt' => 'All Storage Area'])->label(false) ?>
            </div>   

            <div class="col-sm-2 col-xs-12">
                <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Inactive'],['class' => 'select2 form-control','prompt' => 'All Status'])->label(false) ?>
            </div>
 

    <?php // echo $form->field($model, 'part_id') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'batch_no') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'sub_quantity') ?>

    <?php // echo $form->field($model, 'unit_id') ?>

    <?php // echo $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'shelf_life') ?>

    <?php // echo $form->field($model, 'hour_used') ?>

    <?php // echo $form->field($model, 'time_used') ?>

    <?php // echo $form->field($model, 'expiration_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'received') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'deleted') ?>

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
