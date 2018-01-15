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
/* @var $this yii\web\View */
/* @var $model common\models\Quotation */
/* @var $form yii\widgets\ActiveForm */
$dataCustomer = ArrayHelper::map(Customer::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'part_no');
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
                                <?= $form->field($model, 'customer_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->dropDownList($dataCustomer,['class' => 'select2 form-control',])->label('Customer') ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'attention', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->dropDownList(['Repair','Manufacturing']) ?>
                            </div>


                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['id'=>'datepicker', 'autocomplete' => 'off', 'placeholder' => 'Please select date']) ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'lead_time', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput() ?>
                            </div>


                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'reference', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['maxlength' => true]) ?>
                            </div>

                            
                        </div>

                        <div class="row">

                            

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'p_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['maxlength' => true])->label('Payment Term') ?>
                            </div>


                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'p_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->dropDownList($dataCurrency,['class' => 'select2 form-control',])->label('Payment Currency') ?>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'd_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textInput(['maxlength' => true])->label('Delivery Term') ?>
                            </div>
                            
                        </div>

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'work_performed', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textArea(['maxlength' => true,'rows' => 4]) ?>
                            </div>

                            <div class="col-sm-6 col-xs-12">    
                                <?= $form->field($model, 'remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->textArea(['maxlength' => true,'rows' => 4]) ?>
                            </div>
                            
                        </div>
                       





                    </div>
                </div>



<?php /* SELECTION */ ?>


                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Select Parts</h3>
                        <div class="pull-right change-type-button">
                            <button onclick="changeItemType('service')" class="btn btn-primary">Add Services</button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="po-table col-md-12">
                            <div class="po-table-header">
                                <div class="row">
                                    <div class="col-sm-3">
                                        Parts/Services
                                    </div>
                                    <div class="col-sm-1">
                                        Quantity
                                    </div>
                                    <div class="col-sm-3">
                                        Unit Price
                                    </div>
                                    <div class="col-sm-3">
                                        Sub-Total
                                    </div>
                                    <div class="col-sm-2">
                                        Action
                                    </div>
                                </div>
                            </div>
                            <div class="item-list">


                                    <div class="row">


                                        <div class="col-sm-3">   
                                            <div class="form-group field-quotationdetail-part_id">
                                                <input type="hidden" id="item-type" value="part">
                                            <?php  /*add service */  ?>
                                                <div class="item-service hidden ">
                                                    <textarea id="service" placeholder="Services" class="form-control" ></textarea>
                                                </div>

                                            <?php  /*add parts*/  ?>
                                                <div class="item-part">
                                                    <select id="part_id" class="form-control select2">
                                                        <?php foreach ($dataPart as $id => $dP ) {  ?>
                                                            <option value="<?= $id ?>"><?= $dP ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="help-block"></div>
                                            </div>                                    
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group field-qty">

                                                <input type="text" id="qty-par" class="form-control" placeholder="Qty" onchange="updateQuoSubTotalPar()" autocomplete="off">

                                                <div class="help-block"></div>
                                            </div>                                    
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group field-unit">

                                                <input type="text" id="unit-par" class="form-control" placeholder="0.00" onchange="updateQuoSubTotalPar()" autocomplete="off">

                                                <div class="help-block"></div>
                                            </div>                                    
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group field-quotationdetail-unit_price">
                                                <input type="text" id="subtotal-par" class="form-control " placeholder="0.00" readonly>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="javascript:addQuoItemPar()"><i class="fa fa-plus"></i> Add</a>
                                        </div>
                                    </div>


                            </div>
                            <div class="selected-item-list" id="selected-item-list">
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

                    <div class="col-sm-12 col-xs-12">
                        <?= $form->field($qAttachment, 'attachment[]', [
                          'template' => "<div class='col-sm-2 text-left'>{label}</div>\n<div class='col-sm-10 col-xs-12'>{input}</div>\n{hint}\n{error}"
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

            </div> <!--  col-sm-12 -->
        </div><!--  row -->
        <?php ActiveForm::end(); ?>

    </section>
</div>
