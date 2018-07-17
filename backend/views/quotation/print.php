<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Quotation */

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\User;
use common\models\Address;


if ($model->quotation_type == 'work_order') {
  $x = '-w';
}elseif($model->quotation_type == 'uphostery'){
  $x = '-u';
}else{
  $x = '';
}



$quoNumber = "QUO-" . sprintf("%008d", $model->quotation_no).$x;
$id = $model->id;
$this->title = "QUO-" . sprintf("%008d", $model->quotation_no);
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataAddress = ArrayHelper::map(Address::find()->all(), 'id', 'address');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$currencyId = $model->p_currency;
?>

    <!-- Content Header (Page header) -->
<div class="print-area">
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="" style="background:white;border-radius:0.5rem;margin-bottom:1rem">

        <tr>
            <td width="50%">
                <img src="images/logo.png">
            </td>
            <td align="right">
                <div style="text-align:right; font-size: 10pt">
                    <strong>Aero Industries (Singapore) Pte Ltd</strong><br>
                    28 Changi North Way<br>
                    Singapore 498813<br>
                    Tel: (65) 6542 6288 <br>
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
                <h2>
                    Quotation
                    <small></small>
                </h2>
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
                            <td width="25%">
                                <label>Quotation No.:</label>
                            </td>
                            <td width="25%">
                                <?= $quoNumber ?>
                            </td>
                            <td width="25%">
                                <label>Date Issued:</label>
                            </td>
                            <td width="25%">
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
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label>Customer:</label>
                            </td>
                            <td valign="top">
                                <?= $dataCustomer[$model->customer_id] ?>
                            </td>
                            <td valign="top">
                                <label>Customer Order No:</label>
                            </td>
                            <td valign="top">
                                <?= $model->reference ?>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="3" valign="top">
                                <label>Address</label>
                            </td>
                            <td rowspan="3" valign="top">
                                <?= !empty($model->address)?(isset($dataAddress[$model->address])?nl2br($dataAddress[$model->address]):''):'' ?>
                            </td>
                            <td valign="top">
                                <label>Lead Time:</label>
                            </td>
                            <td valign="top">
                                <?= $model->lead_time ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label>Payment Terms:</label>
                            </td>
                            <td valign="top">
                                <?= $model->p_term ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label>Delivery Terms:</label>
                            </td>
                            <td valign="top">
                                <?= $model->d_term ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label>Attention:</label>
                            </td>
                            <td valign="top">
                                <?= $model->attention ?>
                            </td>
                            <td valign="top">
                                <label>Payment Currency:</label>
                            </td>
                            <td valign="top">
                                <?= $dataCurrency[$currencyId] ?>
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
                      <h3 class="box-title"></h3>
                    </div>

                    <table class="quo-print-table box-body item" width="100%" >
                        <thead>
                            <tr>
                                <th class="text-center border-all">
                                    Item
                                </th>
                                <th class="text-center border-all">
                                    Qty
                                </th>
                                <th class="border-all">
                                    Part No. & Description
                                </th>
                                <th class="text-center border-all" style="width: 10%">
                                    Work Performance
                                </th>
                                <th class="text-center border-all" style="width: 15%">
                                    Unit Price
                                </th>
                                <th class="text-center border-all" style="width: 15%">
                                    Sub-Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $group = ''; $total = 0 ; foreach ( $detail as $d ) { $total += $d->subtotal; ?>
                                <tr>
                                    <td class="border-left border-right text-center" valign="top">
                                        <?= $group == $d->group ? '' : $d->group ?>
                                        <?php $group = $d->group; ?>
                                    </td>
                                    <td align="center" class="border-right text-center" valign="top">
                                        <?= $d->quantity ?>
                                    </td>
                                    <td class="border-right">
                                        <?= $d->service_details ?>
                                    </td>
                                    <td class="border-right text-center" valign="top">
                                        <?= $d->work_type ?>
                                    </td>
                                    <td align="right" class="border-right" valign="top">
                                        <?= $dataCurrencyISO[$currencyId] ?> <?= $d->unit_price ?>
                                    </td>
                                    <td align="right" class="border-right" valign="top">
                                        <?= $dataCurrencyISO[$currencyId] ?> <?= $d->subtotal ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="6" class="border-all">
                                <i>Remarks: <?= $model->remark ?></i>
                                </td>
                            </tr>
                            <tr class="total-tr">
                                <td colspan="4">
                                </td>
                                <td align="right">
                                    <strong>Sub-Total</strong>
                                </td>
                                <td align="right">
                                    <strong><?= $dataCurrencyISO[$currencyId] ?> <?= number_format((float)$total, 2, '.', '')?></strong>
                                </td>
                            </tr>
                            <tr class="total-tr">
                                <td colspan="4">
                                </td>
                                <td align="right">
                                    <strong>GST (<?= $model->gst_rate ?> %)</strong>
                                </td>
                                <td align="right">
                                <?php
                                  $gstCharges = $total * $model->gst_rate / 100;
                                ?>
                                    <strong><?= $dataCurrencyISO[$currencyId] ?> <?= number_format((float)$gstCharges, 2, '.', '')?></strong>
                                </td>
                            </tr>
                            <tr class="total-tr">
                                <td colspan="4">
                                </td>
                                <td align="right">
                                    <strong>Total</strong>
                                </td>
                                <td align="right" style="border-top: 1px dotted #ccc">
                                    <strong><?= $dataCurrencyISO[$currencyId] ?> <?= number_format((float)$total+$gstCharges, 2, '.', '')?></strong>
                                </td>
                            </tr>
                        </tbody>

                    </table>


                </div>
                <?php /* product ordered e*/ ?>


            </td>
        </tr>

    </table>
    <div class="page-break"></div>
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="quo-back" style="background:white;border-radius:0.5rem;">
        <tr>
            <td class="border-all" colspan="3">
                Please expedite approval by signing below.<br>
                <br>
                In Our continuing effort to meet customer needs and to maintain compliance with federal regulations, please notify us of all applicable Airworthiness Directives. Service Bullets and Engineering Orders that you wish to have implemented.
            </td>
        </tr>
        <tr>
            <td class="border-top border-right border-left" colspan="3">
                <br>
                <u>Aero Industries (Singapore) Pte Ltd Contact: Jessie Goh / Steve Foo</u><br>
                <br>
                Customer hereby approves this quotation and authorizes Aero Industries (Singapore) Pte Ltd as its maintenance designee to materials and services as described herein. And in accordance with Product support Agreements between the provide OEM, the Aircraft Manufacturer and its Customer, authorizes Aero Industries (Singapore) Pte Ltd to receive technical, data service bulletins & updates, all parts availability & pricing. and all other maintenance support & benefits to which customer and its maintenance designee are entitled under those agreements. <br>
                PLEASE NOTE: Prices quoted are estimated costs based upon teardown inspection of the unit. Additional charges may be incurred should other parts fail or require replacement during final assembly and test. Aero Industries will provide the quickest possible turn time. Prompt reply and return of this customer Approval will accelerate the repair process and avoid unnecessary delay. In the event the customer does not reply with specific written instructions to either withhold repairs or to BER the unit, within seven days off the date of this quote, then Aero Industries shall assume that tacit approval has been granted as quoted and repairs shall proceed. In the event of a BER or an order to withhold repairs within the seven days, the customer shall be responsible for charges for initial inspection, evaluation and testing. <br>
                All data and pricing information provided herein is Confidential and Proprietary to Aero Industries (Singapore) Pte Ltd. It is provided to the Customer for their sole use in determing an estimate approval and may not be otherwise used or distributed for any other purpose <br>
                <br>
                <br>


            </td>
        </tr>
        <tr>
            <td class="border-bottom border-left">
                Approved By:
                <hr>
            </td>
            <td width="250px" class="border-bottom">
            </td>
            <td class="border-bottom border-right">
                Date:
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan='3'>
                Please Return Your Approval to Jessie Goh at Dedicated Fax: (65) 6353 3578 or Email: jgoh@aeroindustries.sg<br>
                <br>
                Please expedite approval by signing in the Customer Approval block.
            </td>
        </tr>
    </table>
</div>

<div class="row text-center">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-danger form-control print-button">Print</button>
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-default form-control close-button">Close</button>
    </div>
</div>
