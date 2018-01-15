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
/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['<>','status','inactive'])->all(), 'id', 'company_name');
$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
$dataPartReuse = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->andWhere(['type' => 'tool'])->all(), 'id', 'part_no');
$dataPartNonReuse = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->andWhere(['type' => 'part'])->all(), 'id', 'part_no');
$dataWorkOrder = ArrayHelper::map(WorkOrder::find()->where(['<>','deleted','1'])->all(), 'id', 'work_order_no');


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
                                '])->dropDownList($dataSupplier,['class' => 'select2 form-control',])->label('Supplier') ?>
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
                                '])->dropDownList($supplierAddresses, ['class' => 'form-control quo_cust_addr']) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'attention', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['value' => $supplierAttention]) ?>
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
                                '])->dropDownList($dataCurrency,['class' => 'select2 form-control',]) ?>
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

                        </div>
                       





				    </div>
			    </div>


<?php /* SELECTION */ ?>


                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Select Parts</h3>
                    </div>

                    <div class="box-body po-form">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <td width="60%">
                                        Parts
                                    </td>
                                    <td width="10%">
                                        Qty
                                    </td>
                                    <td width="10%">
                                        Unit Price
                                    </td>
                                    <td width="10%">
                                        Sub-Total
                                    </td>
                                    <td width="10%">
                                        Action
                                    </td>
                                </tr>
                            </thead>
                            <tbody class="po-body selected-item-list" id="selected-item-list">
                                <tr>
                                    <td>
                                        <div class="form-group field-purchaseorderdetail-part_id">

                                            <select id="purchaseorderdetail-part_id" class="form-control select2">
                                                <optgroup label="Stock">
                                                    <?php foreach ($dataPartNonReuse as $id => $dP ) {  ?>
                                                        <option value="<?= $id ?>"><?= $dP ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                                <optgroup label="Tools">
                                                    <?php foreach ($dataPartReuse as $id => $dP ) {  ?>
                                                        <option value="<?= $id ?>"><?= $dP ?></option>
                                                    <?php } ?>

                                                </optgroup>
                                            </select>

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

                                            <input type="text" id="unit" class="form-control" placeholder="0.00" onchange="updatePOSubTotal()" autocomplete="off">

                                            <div class="help-block"></div>
                                        </div>                                    
                                    </td>
                                    <td>
                                        <div class="form-group field-purchaseorderdetail-unit_price">
                                            <input type="text" id="subtotal" class="form-control " placeholder="0.00" readonly>
                                            <div class="help-block"></div>
                                        </div>
                                    </td>
                                    <td valign="top">
                                        <a href="javascript:addPOItem()"><i class="fa fa-plus"></i> Add</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="right">
                            <tr>
                                <td align="right">
                                    <label>Total</label>
                                </td>
                                <td>
                                    <input type="text" id="total" class="form-control" name="PurchaseOrder[subtotal]" placeholder="0.00">
                                    <div class="help-block"></div>
                                </td> 
                            </tr>
                            <tr>
                                <td align="right">
                                    <label>GST (%)</label>
                                </td>
                                <td>
                                    <input type="text" id="gst" class="form-control" name="PurchaseOrder[gst_rate]" value="7" placeholder="0.00" onchange="getPoTotal()">
                                    <div class="help-block"></div>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <label>Grand Total</label>
                                </td>
                                <td>
                                    <input type="text" id="totalGST" class="form-control" name="PurchaseOrder[grand_total]" placeholder="0.00">
                                    <div class="help-block"></div>
                                    <input type="hidden" id='n' value="0">
                                </td> 
                            </tr>
                        </table>

                    </div>
                    <div class="col-sm-12 text-right">
                    <br>
                        <div class="form-group">
                            <?= Html::submitButton('<i class="fa fa-save"></i> Confirm', ['class' => 'btn btn-primary']) ?>
                            <?= Html::a( 'Cancel', Url::to('?r='.$backUrl), array('class' => 'btn btn-default')) ?>
                        </div>
                    </div>
    		    </div>


            </div> <!--  col-sm-12 -->
	    </div><!--  row -->
        <?php ActiveForm::end(); ?>

    </section>
</div>


<!-- 
<script type="text/javascript">
    window.onbeforeunload = function() {
       return 'Are you sure that you want to leave this page?';
    }
</script> -->