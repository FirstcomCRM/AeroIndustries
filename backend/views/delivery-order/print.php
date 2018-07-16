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
use common\models\Address;


// $doNumber = "DO-" . sprintf("%008d", $model->delivery_order_no);
$doNumber = $model->delivery_order_no;
$id = $model->id;
$this->title = "DO-" . sprintf("%008d", $model->delivery_order_no);
$this->params['breadcrumbs'][] = ['label' => 'Delivery Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataAddress = ArrayHelper::map(Address::find()->all(), 'id', 'address');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
?>

    <!-- Content Header (Page header) -->
<div class="print-area">
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem">
        
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
            <td colspan="2" align="center">
                <h3>
                    <u>
                        <i>
                            <strong>
                                SHIPPING DOCUMENT / DELIVERY ORDER
                            </strong>
                        </i>
                    </u>
                </h3>
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

                    <table class="box-body preview-do" width="100%" >
                        <tr>
                            <td>
                                <label>Customer:</label>
                            </td>
                            <td>
                                <?= $dataCustomer[$model->customer_id] ?>
                            </td>
                            <td>
                                <label>DO Number:</label>
                            </td>
                            <td>
                                <?= $doNumber ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <label>Ship To:</label>
                            </td>
                            <td>
                                <?= !empty($model->ship_to)?(isset($dataAddress[$model->ship_to])?nl2br($dataAddress[$model->ship_to]):''):'' ?>
                            </td>
                            <td style="vertical-align: top">
                                <label>SCO No:</label>
                            </td>
                            <td style="vertical-align: top">
                                <?= $model->sco_no ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tel:</label>
                            </td>
                            <td>
                                <?= $model->contact_no ?>
                            </td>
                            <td>
                                <label>Date:</label>
                            </td>
                            <td>
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
                    </table>

                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">

                <?php /* product ordered */ ?>
                <div class="box box-success">

                    <div class="box-header with-border">
                      <h3 class="box-title">Parts Ordered</h3>
                    </div>

                    <table class="do-table box-body item" width="100%" >
                        <thead>
                            <tr>
                                <td>
                                    #
                                </td>
                                <td>
                                    Part No
                                </td>
                                <td align="center">
                                    Description
                                </td>
                                <td align="right">
                                    Qty
                                </td>
                                <td align="right">
                                    Work Order
                                </td>
                                <td align="right">
                                    Remarks
                                </td>
                                <td align="right">
                                    PO/RO No.
                                </td>
                            </tr>
                        </thead>
                        <?php $loop = 1; foreach ( $detail as $dd ) { ?>
                            <tr>
                                <td>
                                    <?= $loop ?>
                                </td>
                                <td>
                                    <?= $dd->part_no ?>
                                </td>
                                <td align="center">
                                    <?= $dd->desc ?>
                                </td>
                                <td align="right">
                                    <?= $dd->quantity ?>
                                </td>
                                <td align="right">
                                    <?= $dd->work_order_no ?>
                                </td>
                                <td align="right">
                                    <?= $dd->remark ?>
                                </td>
                                <td align="right">
                                    <?= $dd->po_no ?>
                                </td>
                            </tr>
                        <?php $loop ++; } ?>
                            <tr>
                                <td>
                                <br>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2" valign="bottom">
                                    RECEIVED BY:
                                </td>
                                <td class="bottom-border">
                                </td>
                                <td class="" colspan="3">
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2" valign="bottom">
                                    AUTHORISED STAMP:
                                </td>
                                <td class="bottom-border">
                                <br>
                                <br>
                                </td>
                                <td class="">
                                </td>
                                <td align="right" valign="bottom">
                                    DATE:
                                </td>
                                <td class="bottom-border">
                                </td>
                            </tr>
                    </table>


                </div>
                <?php /* product ordered e*/ ?>


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
