<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\Part;
use common\models\PartCategory;
use common\models\Supplier;
use common\models\StorageLocation;
use common\models\PurchaseOrder;
/* @var $this yii\web\View */
/* @var $model common\models\SearchStock */
/* @var $form yii\widgets\ActiveForm */
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataPartCat = ArrayHelper::map(PartCategory::find()->all(), 'id', 'name');
$dataStorage = ArrayHelper::map(StorageLocation::find()->all(), 'id', 'name');
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');
$dataPOTemp = ArrayHelper::map(PurchaseOrder::find()->all(), 'id', 'purchase_order_no');

$dataPO = array();
foreach ( $dataPOTemp as $poId => $poNo )  {
    $dataPO[$poId] = "PO-" . sprintf("%008d", $poNo);
}
?>

<div class="stock-search">

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
                <?= $form->field($model, 'part_category_id')->dropDownList($dataPartCat, ['class' => 'select2 form-control','prompt' => 'All Category'])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'part_id')->dropDownList($dataPart, ['class' => 'select2 form-control','prompt' => 'All Parts'])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'storage_location_id')->dropDownList($dataStorage, ['class' => 'select2 form-control','prompt' => 'All Storage Area'])->label(false) ?>
            </div>   

            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'purchase_order_id')->dropDownList($dataPO, ['class' => 'select2 form-control','prompt' => 'All PO'])->label(false) ?>
            </div>   

            <div class="col-sm-2 col-xs-12">
                <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Inactive'],['class' => 'select2 form-control','prompt' => 'All Status'])->label(false) ?>
            </div>

     <?php // echo $form->field($model, 'batch_no') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'expiration_date') ?>

    <?php // echo $form->field($model, 'status') ?>
        <div class="col-sm-2 col-xs-12 pull-right">
            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                 <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
            </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>
