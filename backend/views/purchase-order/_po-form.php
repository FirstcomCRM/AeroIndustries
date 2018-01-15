<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;




$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
    $backUrl = $exBackUrlFull[1];
}

use common\models\Currency;
use common\models\Supplier;
use common\models\Part;
use common\models\WorkOrder;
use common\models\Unit;
/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = Supplier::dataSupplier();

$dataCurrency = Currency::dataCurrency();
$dataCurrencyISO = Currency::dataCurrencyISO();
$dataCurrencyRate = Currency::dataCurrencyRate();

$dataUnit = Unit::dataUnit();
$dataPart = Part::dataPart();
$dataPartNonReuse = Part::dataPartStock();
$dataWorkOrder = WorkOrder::dataWorkOrder();

$firstCurrencyId = array_keys($dataCurrency)[0];
$firstCurrency = $dataCurrencyISO[$firstCurrencyId];
use imanilchaudhari\CurrencyConverter\CurrencyConverter;
$rate = 0;
$converter = new CurrencyConverter();
try{
    $rate = $converter->convert($firstCurrency, 'USD');
}catch (Exception $e) {
    $rate = $dataCurrencyRate[$firstCurrencyId];
}


if ($isEdit) {
    $rate = $model->conversion;
} 

/*plugins*/
use kartik\file\FileInput;
?>

<div class="purchase-order-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-xs-12">


<?php /* BASIC INFO  */ ?>
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= $subTitle ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body ">

                        <div class="row">
                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'supplier_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($dataSupplier,['class' => 'select2 form-control po-supplier',])->label('Supplier') ?>
                            </div>


                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'supplier_ref_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>

                        </div>

                        <div class="row">


                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'payment_addr', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($supplierAddresses, ['class' => 'form-control quo_cust_addr po_pay_addr']) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'attention', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['value' => $supplierAttention,'class' => 'form-control po-attention']) ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'issue_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['id'=>'datepicker', 'autocomplete' => 'off', 'placeholder' => 'Please select date']) ?>
                            </div>


                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'delivery_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['id'=>'datepicker2', 'autocomplete' => 'off', 'placeholder' => 'Please select date']) ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'p_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($dataCurrency,['class' => 'select2 form-control currency-selection',]) ?>
                            </div>
                            
                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'q_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($dataCurrency,['class' => 'select2 form-control currency-selection',]) ?>
                            </div>
                        </div>

                        <div class="row">
                            

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'authorized_by', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'p_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'ship_to', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textArea(['maxlength' => true,'rows' => 4]) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textArea(['maxlength' => true,'rows' => 4]) ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'ship_via', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <?= $form->field($poAttachment, 'attachment', [
                                    'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                ])
                                ->widget(FileInput::classname(), [
                                    'options' => ['accept' => 'image/*'],
                                ])->fileInput(['multiple' => true,])->label('Attachment') ?>
                            </div>   

                        </div>
                         <div class="col-sm-9 col-xs-12">
                            <?php if ( !empty ( $data['currAttachment'] ) ) { ?> 
                                <?php foreach ( $data['currAttachment'] as $at ) { 
                                    $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                    <?php 
                                    $fileNameOnlyEx = explode('-', $at->value);

                                    ?>
                                    <div class="col-sm-3 col-xs-12">
                                        <a href="<?= 'uploads/PurchaseOrderAttachment/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                        <?= Html::a(' <i class="fa fa-close"></i> ', ['work-order/remove-woa', 'id' => $at->id], [
                                            'data' => [
                                            'confirm' => 'Are you sure you want to remove this attachment?',
                                            ],
                                            ]) ?>
                                    </div>
                                <?php } ?> 
                            <?php } else { ?> 
                                <div class="col-sm-12 col-xs-12">
                                    No attachment found!
                                </div>
                            <?php } ?> 
                        </div>
                       





				    </div>
			    </div>


<?php /* SELECTION */ ?>


                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Select Parts</h3>
                    </div>

                    <div class="box-body">
                        <div class="po-form">
                            <?php if ( $isEdit == false ) { ?>
                                <small>
                                    The conversion rate today: <strong> 1 <span id="currencyText"><?= $firstCurrency ?></span></strong> is <strong><span id="rateText"><?= $rate ?></span> <strong>USD</strong> </strong>
                                    <br>
                                </small>
                            <?php } else { ?>
                                <small>
                                    The conversion rate on <?= explode(' ',$model->created)[0] ?>: <strong> 1 <span id="currencyText"><?= $firstCurrency ?></span></strong> is <strong><span id="rateText"><?= $rate ?></span> <strong>USD</strong> </strong>
                                    <br>
                                </small>
                            <?php } ?>
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td width="30%">
                                            Parts
                                        </td>
                                        <td width="10%" align="left">
                                            Qty
                                        </td>
                                        <td width="10%" align="center">
                                            Unit Price
                                        </td>
                                        <td width="10%" align="center">
                                            Converted Price
                                        </td>
                                        <td width="10%" align="left">
                                            UM
                                        </td>
                                        <td width="10%" align="center">
                                            Sub-Total
                                        </td>
                                        <td width="20%" align="left">
                                            Action
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="po-body selected-item-list" id="selected-item-list">
                                    <tr>
                                        <td>
                                            <div class="form-group field-purchaseorderdetail-part_id">
                                                <select id="purchaseorderdetail-part_id" class="form-control select2">
                                                    <option>Please select part</option>
                                                        <?php foreach ($dataPartNonReuse as $id => $dP ) {  ?>
                                                            <option value="<?= $id ?>"><?= $dP ?></option>
                                                        <?php } ?>
                                                </select>
                                                <span class="stock-result"></span>
                                                <div class="help-block"></div>
                                            </div>                                    
                                        </td>
                                        <td>
                                            <div class="form-group field-qty">
                                                <input type="text" id="qty" class="form-control" placeholder="Qty" onchange="updatePOSubTotal()" autocomplete="off">
                                                <div class="help-block"></div>
                                            </div>                                    
                                        </td>
                                        <td>
                                            <div class="form-group field-unit">
                                                <input type="text" id="unit" class="form-control" placeholder="0.00" onchange="convert()" autocomplete="off">
                                                <div class="help-block"></div>
                                            </div>                                    
                                        </td>
                                        <td>
                                            <div class="form-group field-unit_converted">
                                                <input type="text" id="converted_unit" class="form-control" placeholder="0.00" onchange="updatePOSubTotal()" autocomplete="off">
                                                <div class="help-block"></div>
                                            </div>                                    
                                        </td>
                                        <td>
                                            <div class="form-group field-um">

                                                <select id="unitm" class="form-control select2">
                                                    <?php foreach ($dataUnit as $id => $dP ) {  ?>
                                                        <option value="<?= $id ?>"><?= $dP ?></option>
                                                    <?php } ?>
                                                </select>

                                                <div class="help-block"></div>
                                            </div>                                    
                                        </td>
                                        <td>
                                            <div class="form-group field-purchaseorderdetail-subtotal">
                                                <input type="text" id="subtotal" class="form-control" placeholder="0.00" readonly>
                                                <div class="help-block"></div>
                                            </div>
                                        </td>
                                        <td valign="top">
                                            <a href="javascript:addPOItem()"><i class="fa fa-plus"></i> Add</a>
                                        </td>
                                    </tr>
                                    <?php $n = 0; ?>
                                    <?php if ( isset ( $oldDetail ) ) { ?>
                                        <?php foreach ( $oldDetail as $dd ) { ?>
                                            <?php if (isset($dd->part_id)) { ?>
                                                <tr class="item-<?= $n ?>">
                                                    <td>    
                                                        <div class="form-group field-purchaseorderdetail-part_id">
                                                            <input type="text" class="form-control" id="selected-<?= $n ?>-part" value="<?= $dataPart[$dd->part_id]?>" readonly>
                                                            <input type="hidden" class="form-control" name="PurchaseOrderDetail[<?= $n ?>][part_id]" value="<?= $dd->part_id ?>" readonly>
                                                        </div>                                    
                                                    </td>
                                                    <td> 
                                                        <div class="form-group field-qty0">
                                                            <input type="text" class="form-control" id="selected-<?= $n ?>-qty" name="PurchaseOrderDetail[<?= $n ?>][quantity]" value="<?= $dd->quantity ?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
                                                        </div>                                    
                                                    </td>
                                                    <td> 
                                                        <div class="form-group field-unit">
                                                            <input type="text" class="form-control unitGroup" name="PurchaseOrderDetail[<?= $n ?>][unit_price]" id="selected-<?= $n ?>-unit" value="<?= number_format((float)$dd->unit_price / $rate, 2, '.', '')?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
                                                        </div>                                    
                                                    </td>
                                                    <td> 
                                                        <div class="form-group field-unit">
                                                            <input type="text" class="form-control converted_unit" id="selected-<?= $n ?>-converted_unit" value="<?= $dd->unit_price ?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
                                                        </div>                                    
                                                    </td>
                                                    <td> 
                                                        <div class="form-group field-unit-m">
                                                            <input type="text" class="form-control" id="selected-<?= $n ?>-unitm" value="<?=$dataUnit[$dd->unit_id]?>" readonly>
                                                            <input type="hidden" name="PurchaseOrderDetail[<?= $n ?>][unit_id]" value="<?= $dd->unit_id ?>" readonly>
                                                        </div>                                    
                                                    </td>
                                                    <td> 
                                                        <div class="form-group field-purchaseorderdetail-unit_price">
                                                            <input type="text" class="form-control subTotalGroup" id="selected-<?= $n ?>-subTotal" name="PurchaseOrderDetail[<?= $n ?>][subTotal]" value="<?= $dd->subtotal ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td> 
                                                        <?php /* <span class="edit-button<?= $n ?> edit-button"> 
                                                            <a href="javascript:editPOItem(<?= $n ?>)"><i class="fa fa-pencil"></i> Edit</a>
                                                        </span> */ ?>
                                                        <span class="save-button<?= $n ?> save-button hidden">
                                                            <a href="javascript:savePOItem(<?= $n ?>)"><i class="fa fa-save"></i> Save</a>
                                                        </span>
                                                        <span class="remove-button">
                                                            <a href="javascript:removePOItem(<?= $n ?>)">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php }  ?>
                                            <?php $n++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="po-total">
                            <table align="right">
                                <tr>
                                    <td align="right">
                                        <label>Total</label>
                                    </td>
                                    <td>
                                        <input type="text" id="total" class="form-control" name="PurchaseOrder[subtotal]" placeholder="0.00" value="<?=isset($model->subtotal)?$model->subtotal:0?>">
                                        <div class="help-block"></div>
                                    </td> 
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label>GST (%)</label>
                                    </td>
                                    <td>
                                        <input type="text" id="gst" class="form-control" name="PurchaseOrder[gst_rate]" value="7" placeholder="0.00" onchange="getPoTotal()" value="<?=isset($model->gst)?$model->gst * $model->subtotal:0?>">
                                        <div class="help-block"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label>Grand Total</label>
                                    </td>
                                    <td>
                                        <input type="text" id="totalGST" class="form-control" name="PurchaseOrder[grand_total]" placeholder="0.00" value="<?=isset($model->grand_total)?$model->grand_total:0?>">
                                        <div class="help-block"></div>
                                        <input type="hidden" id='n' value="0">
                                        <input type="hidden" id='currencyRate' name="PurchaseOrder[conversion]" value="<?= $rate ?>">
                                    </td> 
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="col-sm-12 text-right">
                    <br>
                        <div class="form-group">
                            <?= Html::submitButton('<i class="fa fa-save"></i> Confirm', ['class' => 'btn btn-primary']) ?>
                            <button class="back-button btn btn-default">Cancel</button>
                        </div>
                    </div>
    		    </div>


            </div> <!--  col-sm-12 -->
	    </div><!--  row -->
        <?php ActiveForm::end(); ?>

    </section>
</div>

<script type="text/javascript"> confi(); </script>