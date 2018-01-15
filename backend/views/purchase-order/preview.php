<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Currency;
use common\models\Supplier;
use common\models\Part;
use common\models\User;
use common\models\Unit;
use common\models\PurchaseOrder;
use common\models\WorkOrder;


$poNumber = PurchaseOrder::getPONo($model->purchase_order_no,$model->created);
$id = $model->id;
$this->title = $poNumber;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataSupplier = Supplier::dataSupplier();
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'unit');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$dataWorkOrder = ArrayHelper::map(WorkOrder::find()->all(), 'id', 'work_order_no');
$currencyId = $model->p_currency;

/*plugins*/
use kartik\file\FileInput;
?>
<div class="purchase-order-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($poNumber) ?>
            <small></small>
        </h1>
        Status: <?= $model->approved ?>
    </section>
    <div class="col-sm-4 text-left">
            <?php Html::a('<i class="fa fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>

            <?php if ( $model->approved != 'approved' && $model->approved != 'closed' ) { ?>
                <?= Html::a('<i class="fa fa-check"></i> Approve', ['approve', 'id' => $model->id], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'confirm' => 'Are you sure you want to approve this PO?',
                    ],
                ]) ?>
            <?php } ?> 

            <?php if ( $model->approved != 'cancelled' && $model->approved != 'closed' ) { ?>
                <?= Html::a('<i class="fa fa-ban"></i> Cancel', ['cancel', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to cancel this PO?',
                    ],
                ]) ?>
            <?php } ?> 
    </div>
    <div class="col-sm-8 text-right">

        <?php if ( $model->approved != 'approved' && $model->approved != 'closed' && $model->approved != 'cancelled' ) { ?>
        <?= Html::a('<i class="fa fa-edit"></i> Edit', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
        <?= Html::a( 'Print', Url::to(['print', 'id' => $model->id]), array('class' => 'btn btn-warning' ,'target' => '_blank')) ?>
        <br>
        <br>
        <!-- /.box-header -->
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= Html::encode($poNumber) ?></h3>
                    </div>

                    

                    <div class="box-body preview-po">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Supplier:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $dataSupplier[$model->supplier_id] ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Reference Number:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->supplier_ref_no ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Supplier Address:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->payment_addr ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>PO Date:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?php 
                                        $exIssue = explode(' ',$model->issue_date);
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
                                    <label>Delivery Date:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?php 
                                        $exDelivery = explode(' ',$model->delivery_date);
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
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>PO Currency:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $dataCurrency[$currencyId] ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Quotation Currency:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $dataCurrency[$model->q_currency] ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Ship Via:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->ship_via ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Conversion Rate:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->conversion ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Ship To:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->ship_to ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Remark:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->remark ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Authorized By:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->authorized_by ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Status:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?php 
                                        if ( $model->status == 1 ) {
                                            echo 'Fully Paid';
                                        }  else if ( $model->status == 2) {
                                            echo 'Partially Paid';
                                        } else { 
                                            echo 'Unpaid';
                                        }
                                    ?>
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
                                <div class="col-sm-4">
                                    Parts
                                </div>
                                <div class="col-sm-1">
                                    Qty
                                </div>
                                <div class="col-sm-1">
                                    UM
                                </div>
                                <div class="col-sm-2">
                                    Unit Price
                                </div>
                                <div class="col-sm-1">
                                    Freight
                                </div>
                                <div class="col-sm-3">
                                    Sub-Total
                                </div>
                            </div>
                        </div>
                    <?php $total = 0 ; foreach ( $detail as $d ) { $total += $d->subtotal; ?>
                        <div class="row">
                            <div class="col-sm-4">
                                &nbsp;&nbsp;<?= $dataPart[$d->part_id] ?>
                            </div>
                            <div class="col-sm-1">
                                <?= $d->quantity ?>
                            </div>
                            <div class="col-sm-1">
                                <?= $dataUnit[$d->unit_id] ?>
                            </div>
                            <div class="col-sm-2">
                                <?= $dataCurrencyISO[$model->p_currency] ?> <?= $d->unit_price ?>
                            </div>
                            <div class="col-sm-1">
                            <?php if ($d->freight>0) { ?>
                                <?= $dataCurrencyISO[$model->p_currency] ?> <?= $d->freight ?>
                            <?php } else { ?>
                                0
                            <?php } ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $dataCurrencyISO[$model->p_currency] ?> <?= $d->subtotal ?>
                            </div>
                        </div>
                    <?php } ?>
                        <?php $gstCharges = 0; if ( $model->gst_rate > 0 ) { ?>
                        <div class="row">
                            <div class="col-sm-7">
                            </div>
                            <div class="col-sm-2 text-right">
                                <strong>Sub-Total</strong>
                            </div>
                            <div class="col-sm-3">
                                <strong><?= $dataCurrencyISO[$model->p_currency] ?> <?= number_format((float)$total, 2, '.', '')?></strong>
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
                                <strong><?= $dataCurrencyISO[$model->p_currency] ?> <?= number_format((float)$gstCharges, 2, '.', '')?></strong>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-1 text-right">
                                <strong>Total</strong>
                            </div>
                            <div class="col-sm-3">
                                <strong><?= $dataCurrencyISO[$model->p_currency] ?> <?= number_format((float)$total+$gstCharges, 2, '.', '')?></strong>
                            </div>
                        </div>
                        
                    </div>


                </div>
                <?php /* product ordered e*/ ?>
                <?php /* po payment */ ?>
                <div class="box box-warning">

                    <div class="box-header with-border">
                      <h3 class="box-title">Payment History</h3>
                    </div>
                    <div class="box-body po-table">
                        <?php /*left*/ ?>
                        <div class="col-sm-8">
                            <?php 
                            // $totalAmount = $total + $gstCharges;
                            $totalAmount = $model->usd_total;
                            $balance =  number_format((float)$totalAmount, 2, '.', '');
                            $paid = 0;
                             if ( $oldPayment) { ?>
                                <div class="po-table-header">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            Payment Date
                                        </div>
                                        <div class="col-sm-2">
                                            Amount
                                        </div>
                                        <div class="col-sm-2">
                                            Paid By
                                        </div>
                                        <div class="col-sm-3">
                                            Remark
                                        </div>
                                        <div class="col-sm-2">
                                            Action
                                        </div>
                                    </div>
                                </div>
                                <?php foreach ( $oldPayment as $oP ) { ?>                            
                                    <div class="row">
                                        <div class="col-sm-3">
                                        <?php 
                                            $deliveryDate = '';
                                            if ( $oP->time_paid ) {

                                                $exDelivery = explode(' ',$oP->time_paid);
                                                $dd = $exDelivery[0];
                                                
                                                $time = explode('-', $dd);
                                                $monthNum = $time[1];
                                                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                $monthName = $dateObj->format('M'); // March
                                                $deliveryDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                            }

                                        ?>
                                        <?= $deliveryDate ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?= $dataCurrencyISO[$model->p_currency] ?> <?= $oP->amount ?>
                                            <?php $paid += $oP->amount; ?>
                                            <?php $balance -= $oP->amount ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?= $dataUser[$oP->paid_by] ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $oP->remark ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="?r=purchase-order/remove-payment&id=<?= $oP->id ?>" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } /*if old payment */ else { ?>
                                No Payment History
                            <?php }?>
                        </div>
                        <?php /*right*/ ?>
                        <div class="col-sm-4">
                            <div class="col-sm-5">
                                Total Payable: 
                            </div>
                            <div class="col-sm-7">
                                <?= $dataCurrencyISO[$model->p_currency] ?> <?= number_format((float)$balance, 2, '.', '') <= 0 ? '0.00' : number_format((float)$balance, 2, '.', '')?> 
                            </div>
                            <div class="col-sm-5">
                                Total Paid: 
                            </div>
                            <div class="col-sm-7">
                                <?= $dataCurrencyISO[$model->p_currency] ?> <?= number_format((float)$paid, 2, '.', '')?> 
                            </div>
                            <?php if ( number_format((float)$balance, 2, '.', '') > 0 ) { ?>
                            <div class="col-sm-12">
                                <h3>Make Payment</h3>

                                <?php $form = ActiveForm::begin(); ?>
                                    <input type="hidden" name="balanceAmt" value="<?= number_format((float)$balance, 2, '.', '') ?>">
                                    <?= $form->field($payment, 'time_paid')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false) ?>
                                    <?= $form->field($payment, 'purchase_order_id')->hiddenInput(['value' => $id])->label(false) ?>
                                    <?= $form->field($payment, 'paid_by')->hiddenInput(['value' => Yii::$app->user->identity->id ])->label(false) ?>
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($payment, 'amount', 
                                            ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}</div>
                                            {hint}{error}'])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($payment, 'remark', 
                                            ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}</div>
                                            {hint}{error}'])->textInput(['maxlength' => true]) ?>
                                    </div> 

                                <div class="col-sm-12 text-right">
                                    <br>
                                    <div class="form-group">
                                        <?= Html::submitButton('<i class="fa fa-dollar "></i> Pay', ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                            <?php } ?>
                           
                        </div>

                    </div>
                        

                </div>


            </div>
        </div>
    </section>
</div>
