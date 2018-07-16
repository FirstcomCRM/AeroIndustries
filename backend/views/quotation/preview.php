<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\User;
use common\models\Uphostery;
use common\models\WorkOrder;
use common\models\Setting;


$quoNumber = "QUO-" . sprintf("%008d", $model->quotation_no);
$id = $model->id;
$this->title = "QUO-" . sprintf("%008d", $model->quotation_no);
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$currencyId = $model->p_currency;
$work_uphostery_no = 0;
if ($model->quotation_type=="work_order") {
    $workOrder = WorkOrder::getWorkOrder($model->work_order_id);
    if ( $workOrder->work_scope && $workOrder->work_type ) {
        $work_uphostery_no = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
    }
}
if ($model->quotation_type=="uphostery") {
    $uphostery = Uphostery::getUphostery($model->work_order_id);
    if ( $uphostery->uphostery_scope && $uphostery->uphostery_type ) {
        $work_uphostery_no = Setting::getUphosteryNo($uphostery->uphostery_type,$uphostery->uphostery_scope,$uphostery->uphostery_no);
    }
}
/*plugins*/
use kartik\file\FileInput;
?>
<div class="purchase-order-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($quoNumber) ?>
            <small><?= $model->deleted == '1' ? 'quotation deleted' : '' ?></small>
        </h1>
         <?php  /* Status:$model->approved */ ?>
    </section>
        <div class="col-sm-6">
                <?php Html::a('<i class="fa fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>

                <?php if ( $model->approved != 'approved' ) { ?>
                    <?php Html::a('<i class="fa fa-check"></i> Approve', ['approve', 'id' => $model->id], [
                        'class' => 'btn btn-primary',
                        'data' => [
                            'confirm' => 'Are you sure you want to approve this PO?',
                        ],
                    ]) ?>
                <?php } ?> 

                <?php if ( $model->approved != 'cancelled' ) { ?>
                    <?php Html::a('<i class="fa fa-ban"></i> Cancel', ['cancel', 'id' => $model->id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Are you sure you want to cancel this PO?',
                        ],
                    ]) ?>
                <?php } ?> 
        </div>
        <div class="col-sm-6 text-right">

                <?= $model->deleted == '0' ? Html::a( 'Print', Url::to(['print', 'id' => $model->id]), array('class' => 'btn btn-warning' ,'target' => '_blank')) : '' ?>

                <?php if ( $model->deleted == '0' ) { ?>
                    <?= Html::a('<i class="fa fa-trash"></i> Delete', ['delete-column', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this quotation?',
                        ],
                    ]) ?>
                <?php } ?> 
                <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
            <br>
            <br>
            <!-- /.box-header -->
        </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= Html::encode($quoNumber) ?></h3>
                    </div>

                    

                    <div class="box-body preview-po">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Customer:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $dataCustomer[$model->customer_id] ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Reference:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->reference ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Quotation No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $quoNumber ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Date Issued:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?php 
                                        $exIssue = explode(' ',$model->date);
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
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Payment Terms:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->p_term ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Work Order/Uphostery:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $work_uphostery_no; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Payment Currency:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $dataCurrency[$currencyId] ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php /* product ordered */ ?>
                <div class="box box-success">

                    <div class="box-header with-border">
                      <h3 class="box-title">Parts Ordered</h3>
                    </div>

                    <div class="po-table box-body">
                        <div class="po-table-header">
                            <div class="row">
                                <div class="col-sm-1 text-center">
                                    Group
                                </div>
                                <div class="col-sm-1 text-center">
                                    Qty
                                </div>
                                <div class="col-sm-3">
                                    Parts/Services
                                </div>
                                <div class="col-sm-2">
                                    Type
                                </div>
                                <div class="col-sm-2">
                                    Unit Price/Charges
                                </div>
                                <div class="col-sm-3">
                                    Sub-Total
                                </div>
                            </div>
                        </div>
                    <?php $total = 0 ; foreach ( $detail as $d ) { $total += $d->subtotal; ?>
                        <div class="row">
                            <div class="col-sm-1 text-center">
                                <?= $d->group ?> 
                            </div>
                            <div class="col-sm-1 text-center">
                                <?= $d->quantity ?>
                            </div>
                            <div class="col-sm-3">
                                <?=nl2br(trim($d->service_details)) ?> 
                            </div>
                            <div class="col-sm-2">
                                <?= $d->work_type ?>
                            </div>
                            <div class="col-sm-2">
                                <?= $dataCurrencyISO[$currencyId] ?> <?= $d->unit_price ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $dataCurrencyISO[$currencyId] ?> <?= $d->subtotal ?>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="row">
                            <div class="col-sm-7">
                            </div>
                            <div class="col-sm-2 text-right">
                                <strong>Sub-Total</strong>
                            </div>
                            <div class="col-sm-3">
                                <strong><?= $dataCurrencyISO[$currencyId] ?> <?= number_format((float)$total, 2, '.', '')?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                            </div>
                            <div class="col-sm-2 text-right">
                                <strong>GST (<?= $model->gst_rate ?> %)</strong>
                            </div>
                            <div class="col-sm-3">
                            <?php 
                                $gstCharges = $total * $model->gst_rate / 100;
                            ?>
                                <strong><?= $dataCurrencyISO[$currencyId] ?> <?= number_format((float)$gstCharges, 2, '.', '')?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-1 text-right">
                                <strong>Total</strong>
                            </div>
                            <div class="col-sm-3">
                                <strong><?= $dataCurrencyISO[$currencyId] ?> <?= number_format((float)$total+$gstCharges, 2, '.', '')?></strong>
                            </div>
                        </div>
                        
                    </div>


                </div>
                <?php /* product ordered e*/ ?>


                <?php /* attachment*/ ?>
                    <div class="box box-danger">

                        <div class="box-header with-border">
                          <h3 class="box-title">Attachments</h3>
                        </div>

                        

                        <div class="box-body preview-po">
                            <div class="row">
                                <?php if ( !empty ( $attachment ) ) { ?> 
                                    <?php foreach ( $attachment as $at ) { 
                                        $attachmentClass = explode('\\', get_class($at))[2]; ?>
                                        <?php 
                                            $fileNameOnlyEx = explode('-', $at->value);

                                        ?>
                                        <div class="col-sm-3 col-xs-12">
                                            <a href="<?= 'uploads/'.$attachmentClass . '/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                        </div>
                                    <?php } ?> 
                                <?php } else { ?> 
                                        <div class="col-sm-12 col-xs-12">
                                            No attachment found!
                                        </div>
                                <?php } ?> 
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                <?php $form = ActiveForm::begin(); ?>
                                   
                                   <?= $form->field($newAttachment, 'attachment[]')->widget(FileInput::classname(), [
                                        'options' => ['accept' => 'image/*'],
                                    ])->fileInput(['multiple' => true,])->label('Select Attachment(s)') ?>

                                <?php ActiveForm::end(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php /* attachmente */ ?>
            </div>
        </div>
    </section>
</div>
