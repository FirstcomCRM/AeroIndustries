<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}


use common\models\Customer;
use common\models\WorkOrder;

/* @var $this yii\web\View */
/* @var $model common\models\DeliveryOrder */
/* @var $form yii\widgets\ActiveForm */
$dataCustomer = ArrayHelper::map(Customer::find()->where(['<>','status','inactive'])->all(), 'id', 'name');

use common\models\Setting;

$woNumber = '';
if ( isset($workOrder->work_scope )){
    if ( $workOrder->work_scope && $workOrder->work_type ) {
        $woNumber = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
    }
}

?>

<div class="delivery-order-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>

            <div class="form-group text-right">
                <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Cancel', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                &nbsp;
            </div>
        
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Delivery Order</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Details</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-xs-12">
                                
                                <div class="box-header with-border">
                                  <h3 class="box-title"><?= $subTitle ?></h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body ">
 
                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'delivery_order_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '])->textInput() ?>

                                    </div>   
 
                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'sco_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '])->textInput() ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '])->textInput(['id' => 'datepicker','readonly' => true]) ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'customer_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '])->dropDownList($dataCustomer,['class' => 'select2']) ?>

                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'ship_to', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                        {hint}
                                        '])->dropDownList($customerAddresses, ['class' => 'form-control quo_cust_addr']) ?>
                                    </div>

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'contact_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '])->textInput(['maxlength' => true]) ?>

                                    </div>    
  

                                    <div class="col-sm-12 col-xs-12">    

                                        <?= $form->field($model, 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '])->dropDownList(['active' => 'active', 'cancelled' => 'cancelled']) ?>

                                    </div>    
                                    <div class="col-sm-12 col-xs-12" >
                                        <?= $form->field($model, 'attachment', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                            ])
                                            ->widget(FileInput::classname(), [
                                            'options' => ['accept' => 'image/*'],
                                        ])->fileInput(['multiple' => false,])->label('Upload Attachment') ?>
                                    </div>   
                                    <?php if (isset($currAtta)) { ?>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <?php foreach ($currAtta as $curA) { ?>
                                                    <?php 
                                                        $currentAttachmentClass = explode('\\', get_class($curA))[2];
                                                        $fileNameOnlyEx = explode('-', $curA->value);
                                                    ?>
                                                    <div class="col-sm-3 col-xs-12">
                                                        <a href="<?= 'uploads/do/' .$curA->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a> 
                                                        <?= Html::a(' <i class="fa fa-close"></i> ', ['rfq/remove-atta', 'id' => $curA->id], [
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to remove this attachment?',
                                                            ],
                                                        ]) ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>	          


            				    </div>
                			    
                		    </div>
                	    </div>
                    </div>


                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            <div class="col-xs-12">
                                
                                <div class="box-header with-border">
                                  <h3 class="box-title">Details</h3>
                                </div>

                                <div class="box-body do-detail-body">

                                    <?php foreach ( $workOrderPart as $wop) :  ?>
                                        <div class="row">
                                            <div class="col-sm-1 col-xs-12">    
                                                1
                                            </div>    
                                            <div class="col-sm-2 col-xs-12">    
                                                <?= $form->field($detail, 'work_order_no[]', ['template' => '
                                                    {input}{error}
                                                    {hint}
                                                    '])->textInput(['placeholder' => 'Work Order', 'value' => $woNumber]) ?>

                                            </div>  
                                            
                                            <div class="col-sm-2 col-xs-12">    
                                                <?= $form->field($detail, 'part_no[]', ['template' => '
                                                    {input}{error}
                                                    {hint}
                                                    '])->textInput(['placeholder' => 'Part No.', 'value' => $wop['part_no']]) ?>

                                            </div>    

                                            <div class="col-sm-2 col-xs-12">    
                                                <?= $form->field($detail, 'desc[]', ['template' => '
                                                    {input}{error}
                                                    {hint}
                                                    '])->textInput(['maxlength' => true, 'placeholder' => 'Description', 'value' => $wop['desc']]) ?>

                                            </div>    

                                            <div class="col-sm-1 col-xs-12">    
                                                <?= $form->field($detail, 'quantity[]', ['template' => '
                                                    {input}{error}
                                                    {hint}
                                                    '])->textInput(['placeholder' => 'Qty', 'value' => $wop['quantity']]) ?>

                                            </div>    


                                            <div class="col-sm-2 col-xs-12">    
                                                <?= $form->field($detail, 'remark[]', ['template' => '
                                                    {input}{error}
                                                    {hint}
                                                    '])->textInput(['maxlength' => true, 'placeholder' => 'Remark']) ?>

                                            </div>  

                                            <div class="col-sm-2 col-xs-12">    
                                                <?= $form->field($detail, 'po_no[]', ['template' => '
                                                    {input}{error}
                                                    {hint}
                                                    '])->textInput(['maxlength' => true, 'placeholder' => 'PO No.', 'value' => $workOrder['customer_po_no']]) ?>

                                            </div>  
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="col-sm-12 col-xs-12 text-right">
                                    <input type="hidden" id="noLoop" value="1">
                                    <button type="button" onclick="addDODetail()" class="btn btn-primary"><i class="fa fa-plus"></i> Add Details</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>

<script type="text/javascript"> confi(); </script>