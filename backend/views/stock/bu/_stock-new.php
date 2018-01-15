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

use common\models\Part;
use common\models\StorageLocation;
use common\models\Unit;
use common\models\PurchaseOrder;
use common\models\Currency;
use common\models\Supplier;
/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['<>','status','inactive'])->all(), 'id', 'company_name');
$dataStorage = ArrayHelper::map(StorageLocation::find()->where(['<>', 'deleted', 1])->andWhere(['<>','status','inactive'])->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'part_no');
$dataPartType = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'type');
$dataUnit = ArrayHelper::map(Unit::find()->where(['<>','status','inactive'])->all(), 'id', 'unit');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPo = ArrayHelper::map(PurchaseOrder::find()->where(['<>','deleted',1])->andWhere(['approved'=>'approved'])->orderBy('id DESC')->all(), 'id', 'purchase_order_no');
$dataPurchaseOrder = [];
foreach ( $dataPo as $id => $dp) {
    $dataPurchaseOrder[$id] =  "PO-" . sprintf("%008d", $dp);
}
/*plugins*/
use kartik\file\FileInput;
if ( isset ( $_GET['id'] ) && !empty ( $_GET['id'] )  ) {
    $model->purchase_order_id = $_GET['id'];
}

?>

<div class="stock-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group text-right">
            <?php if ( ! $allReceivedStatus ) { ?>
                <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
            <?php } ?> 
            <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
            &nbsp;
        </div>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Stock In</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header with-border">
                                    <?php if ( $purchaseOrder && $purchaseOrderDetail ) { ?>
                                        <h3 class="box-title"><?php echo "PO-" . sprintf("%008d", $purchaseOrder->purchase_order_no); ?></h3>
                                    <?php } else { ?>
                                        <h3 class="box-title">Please select PO Number</h3>
                                    <?php } ?>
                                </div>
                                <!-- /.box-header -->
            							    
                                <div class="box-body ">

                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'purchase_order_id',['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div> {hint}'])
                                        ->dropDownList($dataPurchaseOrder, [
                                            'class' => 'select2 form-control',
                                            'prompt' => 'Please select purchase order',
                                            'onchange' => 'stockInPo()',
                                        ])
                                        ->label('Purchase Order') ?>


                                        <?php if ( $purchaseOrder && $purchaseOrderDetail ) { ?>


                                            <?= $form->field($model, 'received',['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div> {hint}'])
                                            ->textInput(['id'=>'datepicker0','value' => date('Y-m-d') ]) ?>

                                        <?php }  ?>

                                    </div>

                                </div><!--  box body -->

                            </div> <!-- box -->
                            <?php /* retrieve from PO */  ?>
                            <?php if ( $purchaseOrder && $purchaseOrderDetail ) { ?>

                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">PO Details</h3>
                                    </div>
                                    <div class="box-body">            

                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>Supplier:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $purchaseOrder->supplier_id ? $dataSupplier[$purchaseOrder->supplier_id] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>Payment Currency:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $purchaseOrder->p_currency ? $dataCurrencyISO[$purchaseOrder->p_currency] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>Date Issued:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?php 
                                                    $exIssue = explode(' ',$purchaseOrder->issue_date);
                                                    $is = $exIssue[0];
                                                    
                                                    $time = explode('-', $is);
                                                    $monthNum = $time[1];
                                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                    $monthName = $dateObj->format('M'); // March
                                                    $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                                ?>
                                                <?= $issueDate ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>Delivery Date:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?php 
                                                    $exDelivery = explode(' ',$purchaseOrder->delivery_date);
                                                    $dd = $exDelivery[0];
                                                    
                                                    $time = explode('-', $dd);
                                                    $monthNum = $time[1];
                                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                    $monthName = $dateObj->format('M'); // March
                                                    $deliveryDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                                ?>
                                                <?= $deliveryDate ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>Status:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $purchaseOrder->status == 1 ? "Paid" : "Unpaid" ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>Remark:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $purchaseOrder->remark ?>
                                            </div>
                                        </div>

                                    </div> <!-- box body -->


                                </div>

                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Stock in</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">            
                                        <table class="table table-striped table-bordered">

                                            <?php $loop = 1; ?>
                                            <?php foreach ( $purchaseOrderDetail as $poD ) { ?>

                                            <thead>
                                                <tr>
                                                    <th width="20px">#</th>
                                                    <th>Part</th>
                                                    <th width="60px">Qty</th>
                                                    <th width="60px">Received</th>
                                                        <th width="110px">Batch/Lot No.</th>
                                                        <th width="150px">Shelf Life (Hours)</th>
                                                        <th width="110px">Expire Date</th>
                                                        <th width="140px">Location</th>
                                                </tr>
                                            </thead>

                                                <?php /* if not yet receive all */  ?>
                                                <?php if ( $poD->received < $poD->quantity ) { ?>
                                                    <?php $unitId = $poD['unit_id']; ?>
                                                    <tr>
                                                        <td rowspan="2">
                                                           <?= $loop ?> 
                                                        </td>
                                                        <td rowspan="2">
                                                            <?= $dataPart[$poD['part_id']] ?> [<?= $dataPartType[$poD['part_id']] ?>]
                                                            <input type="hidden" name="podid[]" value="<?= $poD->id ?>">
                                                            <input type="hidden" name="stock_type[]" value="<?= $dataPartType[$poD['part_id']] ?>">
                                                            <?= $form->field($model, 'supplier_id')->hiddenInput(['value' => $purchaseOrder->supplier_id])->label(false) ?>
                                                            <?= $form->field($model, 'part_id[]')->hiddenInput(['value' => $poD['part_id']])->label(false) ?>

                                                        </td>
                                                        <td rowspan="">
                                                            <?= $poD['quantity'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $poD['received'] ?>
                                                        </td>

                                                        <td>
                                                            <?= $form->field($model, 'batch_no[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['placeholder' => 'Batch/Lot No.'])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'shelf_life[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['placeholder' => 'Shelf life'])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'expiration_date[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['id' => 'datepicker'.$loop, 'placeholder' => 'Expire Date'])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'storage_location_id[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->dropDownList($dataStorage)->label(false) ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="80px">Stock in</th>
                                                        <th width="140px">UM</th>
                                                        <th width="140px">Qty per unit item</th>
                                                        <th width="140px">UM</th>
                                                        <th width="80px">Unit Price</th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td>
                                                            <?= $form->field($model, 'quantity[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['value' => ($poD->quantity - $poD->received)])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'unit_id[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->dropDownList($dataUnit,[ 'options'=>[$unitId => ["Selected"=>true] ] ])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'sub_quantity[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['placeholder' => 'Qty'])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'sub_unit_id[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->dropDownList($dataUnit)->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'unit_price[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['value' => $poD->unit_price])->label(false) ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7"><hr></td>
                                                    </tr>

                                                <?php  } /* if not yet receive all */ else { ?>

                                                    <?php /* if all received for this item */ ?>
                                                    <tr>
                                                        <td>
                                                           <?= $loop ?> 
                                                        </td>
                                                        <td>
                                                            <?= $dataPart[$poD['part_id']] ?>
                                                        </td>
                                                        <td>
                                                            <?= $poD['quantity'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $poD['received'] ?>
                                                        </td>
                                                        <td colspan='7' align="center">
                                                            <i>Received</i>
                                                        </td>
                                                    </tr>

                                                <?php } /* else received */ ?>

                                                <?php $loop ++ ; ?>
                                            <?php } /* foreach poD */ ?>


                                        </table><!--  table -->

                                    </div> <!-- box body -->
                                </div> <!-- box -->

                            <?php } /* if purchaseOrder = true */ ?>


                        </div>
                    </div>
                </div>
            </div> <!--  tab content -->
        </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
