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
//use common\models\Supplier;
use common\models\GpoSupplier;
use common\models\Part;
use common\models\WorkOrder;
use common\models\Unit;
/* @var $this yii\web\View */
/* @var $model common\models\GeneralPo */
/* @var $form yii\widgets\ActiveForm */
//$dataSupplier = GpoSupplier::dataSupplier();
$data = GpoSupplier::find()->where(['<>','status','inactive'])->all();
$dataSupplier = ArrayHelper::map($data,'id','company_name');

$dataCurrency = Currency::dataCurrency();
$dataCurrencyISO = Currency::dataCurrencyISO();
$dataCurrencyRate = Currency::dataCurrencyRate();

$dataUnit = Unit::dataUnit();
$dataPart = Part::dataPart();
$dataPartReuse = Part::dataPartTool();
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


if ($isEdit && !empty($model->conversion)) {

  //  $rate = $model->conversion;
      $rate = 1;//edr Temporary due to divided by zero error
}

//die($rate);

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
                                '])->dropDownList($dataSupplier,['class' => 'select2 form-control gpo-supplier',])->label('Supplier') ?>
                            </div>


                            <div class="col-sm-6 col-xs-12">
                                <?= $form->field($model, 'supplier_ref_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>

                        </div>

                        <div class="row">

                          <!---edr-->
                            <div class="col-sm-6 col-xs-12">
                                <?= $form->field($model, 'payment_addr', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($supplierAddresses, ['class' => 'form-control quo_cust_addr gpo_pay_addr']) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <?= $form->field($model, 'attention', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['value' => $supplierAttention,'class' => 'form-control gpo-attention']) ?>
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
                                <?= $form->field($model, 'p_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <?= $form->field($model, 'p_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($dataCurrency,['class' => 'select2 form-control currency-selection',])->label('Quotation Currency') ?>
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
                                <?= $form->field($model, 'authorized_by', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>

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
                            <?php if ( $isEdit == true && !empty($model->conversion) ) { ?>
                                <small>
                                    The conversion rate is: <strong> 1 <span id="currencyText"><?= $firstCurrency ?></span></strong> is <strong><span id="rateText"><?= $rate ?></span> <strong>USD</strong> </strong>
                                    <br>
                                    The currency above are gathered from the date this PO created: <?= $model->created?></a>
                                </small>
                            <?php } else { ?>
                                <small>
                                    The conversion rate today: <strong> 1 <span id="currencyText"><?= $firstCurrency ?></span></strong> is <strong><span id="rateText"><?= $rate ?></span> <strong>USD</strong> </strong>
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
                                            <div class="form-group field-generalpodetail-part_id">

                                                    <input type="text" id="generalpodetail-part_id" class="form-control" placeholder="Parts" >

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
                                            <div class="form-group field-generalpodetail-subtotal">
                                                <input type="text" id="subtotal" class="form-control" placeholder="0.00" readonly>
                                                <div class="help-block"></div>
                                            </div>
                                        </td>
                                        <td valign="top">
                                            <a href="javascript:addGPOItem()"><i class="fa fa-plus"></i> Add</a>
                                        </td>
                                    </tr>
                                    <?php $n = 0; ?>
                                    <?php if ( isset ( $oldDetail ) ) { ?>
                                        <?php foreach ( $oldDetail as $dd ) { ?>
                                            <?php if (isset($dd->part_id)) { ?>
                                                <tr class="item-<?= $n ?>">
                                                    <td>
                                                        <div class="form-group field-generalpodetail-part_id">
                                                            <input type="text" class="form-control" id="selected-<?= $n ?>-part" value="<?= $dd->part_id?>" readonly>
                                                            <input type="hidden" class="form-control" name="generalpodetail[<?= $n ?>][part_id]" value="<?= $dd->part_id ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group field-qty0">
                                                            <input type="text" class="form-control" id="selected-<?= $n ?>-qty" name="generalpodetail[<?= $n ?>][quantity]" value="<?= $dd->quantity ?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group field-unit">
                                                            <input type="text" class="form-control unitGroup" id="selected-<?= $n ?>-unit" value="<?= number_format((float)$dd->unit_price / $rate, 2, '.', '')?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group field-unit">
                                                            <input type="text" class="form-control converted_unit" id="selected-<?= $n ?>-converted_unit" name="generalpodetail[<?= $n ?>][unit_price]" value="<?= $dd->unit_price ?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group field-unit-m">
                                                            <input type="text" class="form-control" id="selected-<?= $n ?>-unitm" value="<?=$dataUnit[$dd->unit_id]?>" readonly>
                                                            <input type="hidden" name="generalpodetail[<?= $n ?>][unit_id]" value="<?= $dd->unit_id ?>" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group field-generalpodetail-unit_price">
                                                            <input type="text" class="form-control subTotalGroup" id="selected-<?= $n ?>-subTotal" name="generalpodetail[<?= $n ?>][subTotal]" value="<?= $dd->subtotal ?>" readonly>
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
                                        <!---<input type="text" id="total" class="form-control" name="GeneralPo[subtotal]" placeholder="0.00">--->
                                        <?php echo $form->field($model, 'subtotal')->textInput(['id'=>'total', 'placeholder'=>'0.00'])->label(false)  ?>
                                        <div class="help-block"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label>GST (%)</label>
                                    </td>
                                    <td>
                                        <!---<input type="text" id="gst" class="form-control" name="GeneralPo[gst_rate]" value="7" placeholder="0.00" onchange="getPoTotal()">--->
                                          <?php echo $form->field($model, 'gst_rate')->textInput(['id'=>'gst', 'placeholder'=>'0.00', 'onchange'=>'getPoTotal()'])->label(false)  ?>
                                        <div class="help-block"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label>Grand Total</label>
                                    </td>
                                    <td>
                                      <!---  <input type="text" id="totalGST" class="form-control" name="GeneralPo[grand_total]" placeholder="0.00">--->
                                        <?php echo $form->field($model, 'grand_total')->textInput(['id'=>'totalGST', 'placeholder'=>'0.00'])->label(false)  ?>
                                        <div class="help-block"></div>
                                        <input type="hidden" id='n' value="0">
                                        <input type="hidden" id='currencyRate' name="GeneralPo[conversion]" value="<?= $rate ?>">
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
