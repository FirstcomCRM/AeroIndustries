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

$this->title = $reNumber;
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['receiver']];
$this->params['breadcrumbs'][] = $this->title;
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
?>
<input type="hidden" name="re-no" id="re-no" value="<?= $reNumber ?>"> 
    <!-- Content Header (Page header) -->
<div class="print-area">

    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem">
        <tr>
            <td colspan="2">
            <br>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <img src="images/logo.png">
            </td>
            <td align="right">
                <div style="text-align:right; font-size: 10pt">
                    49 Jalan Pemimpin<br>
                    #05-03 APS Industrial Building<br>
                    Singapore 577203<br>
                    Tel: (65) 6353 8003 &nbsp; &nbsp;
                    Fax: (65) 6353 3578<br>
                    Email: sales@aeroindustries.sg
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <br>
            </td>
        </tr>
        <tr class="">
            <td colspan="2">
                <h1>
                    Receiver 
                    <small><?= "RE-" . sprintf("%008d", $reNumber); ?></small> 
                </h1>
               
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="box">

                    <table class="box-body preview-po" width="100%" >
                        <tr>
                            <td>
                                <label>Supplier:</label>
                            </td>
                            <td>
                                <?= $dataSupplier[$supplierId] ?>
                            </td>
                            <td>
                                <label>PO No. </label>
                            </td>
                            <td>
                                <?= "PO-" . sprintf("%008d", $po->purchase_order_no ) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Receiver Number:</label>
                            </td>
                            <td>
                                <?= "RE-" . sprintf("%008d", $reNumber); ?>
                            </td>
                            <td>
                                <label>Date Received:</label>
                            </td>
                            <td>
                                <?php 
                                    $exIssue = explode(' ',$receiveDate);
                                    $is = $exIssue[0];
                                    
                                    $time = explode('-', $is);
                                    $monthNum = $time[1];
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('M'); // March
                                    $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                ?>
                                <?= $issueDate ?>
                            </td>
                        </tr>
                       
                    </table>

                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">

                <?php /* product ordered */ ?>
                <div class="box box-success">

                    <div class="box-header with-border">
                      <h3 class="box-title">Stock Received</h3>
                    </div>

                    <table class="po-table box-body item" width="100%" >
                        <thead class="po-table-header">
                            <tr>
                                <td>
                                    #
                                </td>
                                <td align="center">
                                    Part No.
                                </td>
                                <td align="right">
                                    Description
                                </td>
                                <td align="right">
                                    Qty
                                </td>
                                <td align="right">
                                    Unit Price
                                </td>
                                <td align="right">
                                    Subtotal
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td align="left" colspan="2">
                                    Batch.
                                </td>
                                <td align="left">
                                    Shelf life
                                </td>
                                <td align="left" colspan="2">
                                    WO
                                </td>
                            </tr>
                        </thead>
                        <?php $noLoop = 1; ?>
                        <?php $total = 0; ?>

                        <?php if ( $model ) { ?>
                            <?php foreach ( $model as $d ) { ?>
                                <tr>
                                    <td>
                                        <?= $noLoop ?>
                                    </td>
                                    <td align="center">
                                        <?= $dataPart[$d->part_id] ?>
                                    </td>
                                    <td align="right">
                                        <?= $d->desc ?>
                                    </td>
                                    <td align="right">
                                        <?= $d->quantity ?>
                                    </td>
                                    <td align="right">
                                        <?= $d->unit_price ?>
                                    </td>
                                    <td align="right">
                                        <?php 
                                            $subTotal = $d->quantity * $d->unit_price;
                                            $total += $subTotal;
                                        ?>
                                        <?= number_format((float)$subTotal, 2, '.', '') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td align="left" colspan="2">
                                        <?= $d->batch_no ?>
                                    </td>
                                    <td align="left">
                                        <?= $d->shelf_life ?>
                                    </td>
                                    <td align="left" colspan="2">
                                        WO???
                                    </td>
                                </tr>
                            <?php $noLoop++; ?>
                            <?php } ?>
                        <?php } /* if model is not empyy */ ?>



                        <?php if ( $model2 ) { ?>
                            <?php foreach ( $model2 as $d ) { ?>
                                <tr>
                                    <td>
                                        <?= $noLoop ?>
                                    </td>
                                    <td align="center">
                                        <?= $dataPart[$d->part_id] ?>
                                    </td>
                                    <td align="right">
                                        <?= $d->desc ?>
                                    </td>
                                    <td align="right">
                                        <?= $toolQty[$d->id] ?>
                                    </td>
                                    <td align="right">
                                        <?= $d->unit_price ?>
                                    </td>
                                    <td align="right">
                                        <?php 
                                            $subTotal = $toolQty[$d->id] * $d->unit_price;
                                            $total += $subTotal;
                                        ?>
                                        <?= number_format((float)$subTotal, 2, '.', '') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td align="left" colspan="2">
                                        <?= $d->batch_no ?>
                                    </td>
                                    <td align="left">
                                        <?= $d->shelf_life ?>
                                    </td>
                                    <td align="left" colspan="2">
                                        WO???
                                    </td>
                                </tr>
                            <?php $noLoop++; ?>
                            <?php } ?>
                        <?php } /* if model2 is not empyy */ ?>

                        <tr>
                            <td colspan="4">
                            <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                            </td>
                            <td align="right">
                                <strong>Sub-Total</strong>
                            </td>
                            <td align="right">
                                <strong><?= $dataCurrencyISO[$po->p_currency] ?> <?= number_format((float)$total, 2, '.', '')?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                            </td>
                            <td align="right">
                                <strong>GST (<?= $po->gst_rate ?> %)</strong>
                            </td>
                            <td align="right">
                            <?php 
                              $gstCharges = $total * $po->gst_rate / 100;
                              $totalWithGst = $total + $gstCharges
                            ?>
                                <strong><?= $dataCurrencyISO[$po->p_currency] ?> <?= number_format((float)$gstCharges, 2, '.', '')?></strong>
                            </td>
                        </tr>
                        </tr> 
                        <tr>
                            <td colspan="4">
                            </td>
                            <td align="right">
                                <strong>Total Cost:</strong>
                            </td>
                            <td align="right" style="border-top: 1px dotted #ccc">
                                <strong><?= $dataCurrencyISO[$po->p_currency] ?> <?= number_format((float)$totalWithGst, 2, '.', '')?></strong>
                            </td>
                        
                    </table>


                </div>
                <?php /* product ordered e*/ ?>


            </td>
        </tr>

        
    </table>
</div>

<div class="row text-center">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-danger form-control print-button"><i class="fa fa-print"></i> Print Receiver</button>
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-primary form-control print-sticker"><i class="fa fa-print"></i> Print Sticker</button>
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-default form-control back-button"><i class="fa fa-arrow-left"></i> Back</button>
    </div>
</div>
