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
use common\models\GeneralPO;
use common\models\Currency;
use common\models\Supplier;
/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = Supplier::dataSupplier();
$dataStorage = StorageLocation::dataLocation();
$dataPart = Part::dataPart();
$dataPartType = Part::dataPartType();
$dataPartReusable = Part::dataPartReusable();
$dataPartShelf = Part::dataPartShelf();
$dataUnit = Unit::dataUnit();
$dataCurrency = Currency::dataCurrencyISO();
$dataCurrencyISO = Currency::dataCurrencyISO();
$dataPo = PurchaseOrder::dataPO();
$dataAllPOCreated = PurchaseOrder::dataAllPOCreated();
$dataPurchaseOrder = [];
foreach ( $dataPo as $id => $dp) {
    $created = $dataAllPOCreated[$id];
    $dataPurchaseOrder[$id] = PurchaseOrder::getPONo($dp,$created);
}
$dataGPo = GeneralPO::dataGPO();
$dataAllGPOCreated = GeneralPO::dataAllGPOCreated();
$dataGeneralPO = [];
foreach ( $dataGPo as $id => $dp) {
    $created = $dataAllGPOCreated[$id];
    $dataGeneralPO[$id] = GeneralPo::getGPONo($dp,$created);
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
                                        <div class="form-group field-stock-purchase_order_id">
                                            <div class="col-sm-3 text-right">
                                                <label class="control-label" for="stock-purchase_order_id">Purchase Order</label>
                                            </div>
                                            <div class="col-sm-9 col-xs-12">
                                                <select id="stock-purchase_order_id" class="select2 form-control" name="Stock[purchase_order_id]" onchange="stockInPo()">
                                                    <option value="">Please select purchase order</option>
                                                    <?php
                                                        $varSelected = '';
                                                        if ( isset($_GET['id']) && isset($_GET['ty']) ){
                                                            $varSelected = $_GET['id'] . '-' . $_GET['ty'];
                                                        }
                                                    ?>
                                                    <optgroup label="Parts PO">
                                                        <?php foreach ($dataPurchaseOrder as $id => $dataP) {  ?> 
                                                            <?php $selected1 = $varSelected == $id . '-part' ?'selected':'';?>
                                                            <option value="<?= $id ?>-part" <?=$selected1?>><?=$dataP?></option>
                                                        <?php } ?>
                                                    </optgroup>
                                                    <optgroup label="General PO">
                                                        <?php foreach ($dataGeneralPO as $id => $dataP) {  ?> 
                                                            <?php $selected2 = $varSelected == $id . '-tool' ?'selected':'';?>
                                                            <option value="<?= $id ?>-tool" <?=$selected2?>><?=$dataP?></option>
                                                        <?php } ?>
                                                    </optgroup>
                                                </select>
                                                <div class="help-block"></div>
                                            </div> 
                                        </div>

                                        <?php if ( $purchaseOrder && $purchaseOrderDetail ) { ?>
                                            <?= $form->field($model, 'received',['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div> {hint}'])
                                            ->textInput(['id'=>'datepicker0','value' => date('Y-m-d') ]) ?>
                                            <div class="form-group field-stock-freight has-success">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label" for="stock-freight">Freight</label>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <input type="text" id="stock-freight-top" class="form-control">
                                                    <div class="help-block">
                                                    </div>
                                                </div> 
                                            </div>

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
                                            <?php $freightQtyCount = 0 ; ?>
                                            <?php foreach ( $purchaseOrderDetail as $key => $poD ) { ?>

                                            <thead>
                                                <tr>
                                                    <th width="20px">#</th>
                                                    <th>Part</th>
                                                    <th width="60px">Qty</th>
                                                    <th width="60px">Received</th>
                                                        <th width="110px">Batch/Lot No.</th>
                                                        <th width="150px">Shelf Life</th>
                                                        <th width="110px">Expire Date</th>
                                                        <th width="140px">Location</th>
                                                </tr>
                                            </thead>

                                                <?php /* if not yet receive all */  ?>
                                                <?php if ( $poD->received < $poD->quantity ) { ?>
                                                    <?php $unitId = $poD['unit_id']; ?>
                                                    <?php $partId = $poD['part_id']; ?>
                                                    <tr>
                                                        <td>
                                                           <?= $loop ?> 
                                                        </td>
                                                        <td>
                                                            <?= $dataPart[$poD['part_id']] ?> [<?= $dataPartType[$poD['part_id']] ?>]
                                                            <input type="hidden" name="podid[]" value="<?= $poD->id ?>">
                                                            <input type="hidden" name="reusable[]" value="<?= $dataPartReusable[$poD['part_id']] ?>">
                                                            <input type="hidden" name="stock_type[]" value="<?= $dataPartType[$poD['part_id']] ?>">
                                                            <?= $form->field($model, 'supplier_id')->hiddenInput(['value' => $purchaseOrder->supplier_id])->label(false) ?>
                                                            <?= $form->field($model, 'part_id[]')->hiddenInput(['value' => $poD['part_id']])->label(false) ?>

                                                        </td>
                                                        <td rowspan="">
                                                            <?= $poD['quantity'] ?>
                                                            <?php $freightQtyCount += $poD['quantity'] ?>
                                                            <input type="hidden" class="each-qty-freight-<?=$partId?> each-qty-freight" value="<?=$poD['quantity']?>">
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
                                                            ->textInput(['placeholder' => 'Shelf life','value' => ($dataPartShelf[$poD['part_id']]==0)?'-1':'' ])->label(false) ?>

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
                                                        <th width="80px">Freight</th>
                                                        <th width="80px">Unit Price (USD)</th>
                                                        <th width="80px">Last Calibration</th>
                                                        <th width="80px">Next Calibration</th>
                                                        <th width="80px">Update Stock?</th>
                                                    </tr>
                                                    <tr>
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
                                                            <?= $form->field($model, 'sub_unit_id[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->dropDownList($dataUnit,[ 'options'=>[$unitId => ["Selected"=>true] ] ])->label(false) ?>

                                                        </td>
                                                        <td>

                                                            <?= $form->field($model, 'freight[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['class' => "form-control ave-freight ave-freight-$partId"])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'usd_price[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['class' => 'form-control usd_price_'.$key,'value' => (number_format((float)$poD->unit_price, 2, '.', '') )])->label(false) ?>

                                                            <input type="hidden" id="orgemagi-<?=$key?>" value="<?= (number_format((float)$poD->unit_price, 2, '.', '') ) ?>">

                                                            <?= $form->field($model, 'unit_price[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->hiddenInput(['value' => $poD->unit_price])->label(false) ?>

                                                            <?= $form->field($model, 'currency_id[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->hiddenInput(['value' => $purchaseOrder->p_currency ])->label(false) ?>
                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'last_cali[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['id' => 'datepicker4','placeholder' => 'Last Calibration'])->label(false) ?>

                                                        </td>
                                                        <td>
                                                            <?= $form->field($model, 'next_cali[]',
                                                                ['template' => '{input}{error}{hint}'])
                                                            ->textInput(['id' => 'datepicker5','placeholder' => 'Next Calibration'])->label(false) ?>

                                                        </td>
                                                        <td>

                                                            <input type="checkbox" name="stock_in[<?=$key?>]" class="">

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
                                    <input type="hidden" id="freightQtyCount" value="<?=$freightQtyCount?>">
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
<script type="text/javascript"> confi(); </script>
