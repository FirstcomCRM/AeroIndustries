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
                    'action' => ['stock'],
                    'method' => 'get',
                ]); ?>

            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'part_category_id')->dropDownList($dataPartCat, ['class' => 'select2 form-control','prompt' => 'All Category'])->label(false) ?>
            </div>

            <div class='col-sm-2 col-xs-12'>
                <?= $form->field($model, 'part_id')->dropDownList($dataPart, ['class' => 'select2 form-control','prompt' => 'All Parts'])->label(false) ?>
            </div>

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
