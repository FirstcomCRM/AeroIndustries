<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
    $backUrl = 'quotation/index';
}

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\WorkOrder;
use common\models\Setting;

/* @var $this yii\web\View */
/* @var $model common\models\Quotation */
/* @var $form yii\widgets\ActiveForm */
$dataCustomer = Customer::dataCustomer();
$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'part_no');
$dataWorkOrder = WorkOrder::dataWorkOrder();
$dataWorkO = [];
foreach ( $dataWorkOrder as $id => $dwo ) {
    $workOrder = WorkOrder::getWorkOrder($id);
    if ( $workOrder->work_scope && $workOrder->work_type ) {
        $woNumber = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
        $dataWorkO[$id] = $woNumber;
    }
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
                                <?= $form->field($model, 'work_order_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($dataWorkO,['class' => 'select2 form-control work-order-selection',])->label('Work Order No.') ?>
                            </div>
                        
                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['id'=>'datepicker', 'autocomplete' => 'off', 'placeholder' => 'Please select date']) ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'customer_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($dataCustomer,['class' => 'select2 form-control',])->label('Customer') ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'attention', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput() ?>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'address', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($customerAddresses, ['class' => 'form-control quo_cust_addr']) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                
                                <?= $form->field($model, 'p_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true])->label('Payment Term') ?>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'reference', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true]) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'd_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput(['maxlength' => true])->label('Delivery Term') ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <?= $form->field($model, 'certification', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList([ 'ARC' => 'ARC', 'COC' => 'COC', 'NA' => 'NA']) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'p_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->dropDownList($dataCurrency,['class' => 'select2 form-control',])->label('Currency') ?>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textArea(['maxlength' => true,'rows' => 4]) ?>
                            </div>
                            

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'lead_time', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                {hint}
                                '])->textInput() ?>
                            </div>
                        </div>
                       

                    </div>
                </div>



<?php /* SELECTION */ ?>


                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Select Parts</h3>
                        <div class="pull-right change-type-button">
                            <?php /* <button onclick="changeItemType('service')" class="btn btn-primary">Add Services</button>*/ ?>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="po-table col-md-12">
                            <div class="table-responsive">
                                <table class="quo-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">
                                                Group
                                            </th>
                                            <th style="width: 7%;">
                                                Qty
                                            </th>
                                            <th>
                                                Description
                                            </th>
                                            <th style="width: 12%;">
                                                Type
                                            </th>
                                            <th style="width: 15%;">
                                                Unit Price
                                            </th>
                                            <th style="width: 15%;">
                                                Sub-Total
                                            </th>
                                            <th style="width: 15%; text-align: center"> 
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group field-qty">
                                                    <input type="text" id="group" class="form-control" placeholder="Grp" autocomplete="off">    
                                                    <div class="help-block"></div>
                                                </div>     
                                            </td>
                                            <td>
                                                <div class="form-group field-qty">
                                                    <input type="text" id="qty-par" class="form-control" placeholder="Qty" onchange="updateQuoSubTotalPar()" autocomplete="off">
                                                    <div class="help-block"></div>
                                                </div>        
                                            </td>
                                            <td>
                                                <div class="form-group field-quotationdetail-part_id">
                                                    <textarea id="quotationdetail-service_details" class="form-control" placeholder="Service Detail"></textarea>
                                                    <div class="help-block"></div>
                                                </div>         
                                            </td>
                                            <td>  
                                                <div class="form-group field-quotationdetail-part_id">
                                                    <select id="quotationdetail-work_type" class="form-control">
                                                        <option></option>
                                                        <option value="Composite">Composite</option>
                                                        <option value="Upholstery">Upholstery</option>
                                                        <option value="Seat Cover">Seat Cover</option>
                                                    </select>
                                                    <div class="help-block"></div>
                                                </div>        
                                            </td>
                                            <td>  
                                                <div class="form-group field-unit">
                                                    <input type="text" id="unit-par" class="form-control" placeholder="0.00" onchange="updateQuoSubTotalPar()" autocomplete="off">
                                                    <div class="help-block"></div>
                                                </div>            
                                            </td>
                                            <td>
                                                <div class="form-group field-quotationdetail-unit_price">
                                                    <input type="text" id="subtotal-par" class="form-control " placeholder="0.00" readonly>
                                                    <div class="help-block"></div>
                                                </div>
                                            </td>
                                            <td align="center"> 
                                                <a href="javascript:addQuoItemPar()"><i class="fa fa-plus"></i> Add</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="selected-item-list quo-table" id="selected-item-list">
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group field-unit0">
                                        <div class="col-sm-4 text-right">
                                            <label>Total</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" id="total" class="form-control" name="Quotation[subtotal]" placeholder="0.00">

                                            <div class="help-block"></div>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group field-unit0">
                                        <div class="col-sm-4 text-right">
                                            <label>GST (%)</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" id="gst" class="form-control" name="Quotation[gst_rate]" value="7" placeholder="0.00" onchange="getQuoTotal()">

                                            <div class="help-block"></div>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group field-unit0">
                                        <div class="col-sm-4 text-right">
                                            <label>Grand Total</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" id="totalGST" class="form-control" name="Quotation[grand_total]" placeholder="0.00">

                                            <div class="help-block"></div>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <input type="hidden" id='n' value="0">
                        
                        </div>

                    </div>
                </div>
<?php /* ATTACHMENTS */ ?>
            <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Attachments</h3>
                </div>
                <div class="box-body">
                        <?php /*   <?= $form->field($qAttachment, 'attachment[]', [
                          'template' => "<div class='col-sm-2 text-left'>{label}</div>\n<div class='col-sm-10 col-xs-12'>{input}</div>\n{hint}\n"
                        ])->fileInput(['multiple' => true,])->label('Select Attachment(s)') ?> */ ?>

                    <div class="col-sm-6 col-xs-12">
                       <?= $form->field($qAttachment, 'attachment[]')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*'],
                        ])->fileInput(['multiple' => true,])->label('Select Attachment(s)') ?>
                    </div>
                    <div class="col-sm-12 text-right">
                    <br>
                        <div class="form-group">
                            <?= Html::submitButton('<i class="fa fa-save"></i> Confirm', ['class' => 'btn btn-primary']) ?>
                            <?= Html::a( 'Cancel', Url::to('?r='.$backUrl), array('class' => 'btn btn-default')) ?>
                        </div>
                    </div>

                </div>


            </div> 



<?php /* END */ ?>
        <?php ActiveForm::end(); ?>

            </div> <!--  col-sm-12 -->
        </div><!--  row -->

    </section>
</div>

<script type="text/javascript"> confi(); </script>