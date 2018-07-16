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
use common\models\ToolPo;

$poNumber = ToolPo::getTPONo($model->purchase_order_no,$model->created);
$id = $model->id;
$this->title = $poNumber;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'unit');
$dataSupplierAtt = ArrayHelper::map(Supplier::find()->all(), 'id', 'contact_person');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$currencyId = $model->p_currency;
?>

    <!-- Content Header (Page header) -->
<div class="print-area">
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem; font-size: 12px">
        
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
                <h3>
                    <?= Html::encode($poNumber) ?>
                    <small></small>
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

                    
                    <table class="box-body preview-po" width="100%" >
                        <tr>
                            <td valign="top" width="25%">
                                <label>To:</label>
                            </td>
                            <td valign="top" width="25%">
                                <?= $dataSupplier[$model->supplier_id] ?>
                            </td>
                            <td width="25%">
                                <label>Date:</label>
                            </td>
                            <td width="25%">
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
                                <label>Delivery Date:</label>
                            </td>
                            <td valign="top">
                                <?php 
                                    $exIssue = explode(' ',$model->delivery_date);
                                    $is = $exIssue[0];
                                    
                                    $time = explode('-', $is);
                                    $monthNum = $time[1];
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('M'); // March
                                    $dDate = $time[2] . ' ' . $monthName . ' ' .$time[0] ;
                                ?>
                                <?= $dDate ?>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="3" valign="top">
                                <label>Address</label>
                            </td>
                            <td rowspan="3" valign="top">
                                <?= nl2br($model->payment_addr) ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label>Terms:</label>
                            </td>
                            <td valign="top">
                                <?= $model->p_term ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label>Payment Currency:</label>
                            </td>
                            <td valign="top">
                                US Dollar
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label>Ship To</label>
                            </td>
                            <td valign="top">
                                <?= nl2br($model->ship_to) ?>
                            </td>
                            <td valign="top">
                                <label>Ship Via</label>
                            </td>
                            <td valign="top">
                                <?= $model->ship_via ?>
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
                    <table class="po-table box-body" width="100%" >
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>
                                    Parts
                                </th>
                                <th>
                                    UoM
                                </th>
                                <th class="text-center">
                                    Qty
                                </th>
                                <th class="text-right">
                                    Unit Price
                                </th>
                                <th class="text-right">
                                    Sub-Total
                                </th>
                            </tr>
                        </thead>
                        <?php $total = 0 ; $loop = 1; foreach ( $detail as $d ) { $total += $d->subtotal; ?>
                            <tr>
                                <td align="center">
                                    <?= $loop ?>
                                </td>
                                <td>
                                    <?= $dataPart[$d->part_id] ?>
                                </td>
                                <td align="left">
                                    <?= $dataUnit[$d->unit_id]?>
                                </td>
                                <td align="center">
                                    <?= $d->quantity ?>
                                </td>
                                <td align="right">
                                    USD <?= $d->unit_price ?>
                                </td>
                                <td align="right">
                                    USD <?= $d->subtotal ?>
                                </td>
                            </tr>
                        <?php $loop ++;  } ?>
                        <tr>
                            <td colspan="5">
                            <br>
                            </td>
                        </tr>
                    </table>


                </div>
                <?php /* product ordered e*/ ?>


            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table class="po-table-footer box-body" width="100%" >
                    <tr>
                        <td width="65%" rowspan="7">
                            <strong>IMPORTANT NOTE:</strong>
                            <ol type="1" class="poterms">
                                <li>CERTIFICATION REQUIREMENTS: FAA 8130-3 or EASA FORM 1 or equivalent document or Manufacturers Certificate of Conformity must accompany shipment. INCLUDING TEST CERTIFICATES</li>
                                <li>ACKNOWLEDGEMENT: Please fax airway billm invoice & packaging list when dispatching goods. Please acknowledge receipt of this order by return e-mail & advise shipping schedule.</li>
                                <li>WARRANTY: 1 year after receipt</li>
                                <li>SHELF LIFE ITEMS: Items must have at least 80% shelf life remaining</li>
                                <li>PO NUMBER: Delivery Order are to be indicated with our Purchase Order number.</li>
                                <li>Notify Aero Industries Pte Ltd (AI) of nonconforming product & obtain AI's approval for nonconforming product disposition</li>
                                <li>Notify AI of changes in product and / or process, changes of supplier, changes of manufacturing facility location and, where required, obtain AI's approval</li>
                                <li>Flow down to the supply chain applicable requirements specified in AI's purchase order.</li>
                                <li>Allow right of access by AI, AI's customers and regulatory authorities to all the applicable facilities, at any level of the supply chain, involved in the order and to all applicable records.</li>
                                <li>Supplier to retain record (if any) specified in the PO accordingly</li>
                                <li>Our standard trading terms and conditions applies</li>
                            </ol>
                        </td>
                        <td align="right" width="15%" class="pototal">
                            <strong>SUB TOTAL</strong>
                        </td>
                        <td align="right" width="20%" class="pototal">
                            <strong>USD <?= number_format((float)$total, 2, '.', '')?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" width="15%" class="pototal">
                            <strong>Add 7 % GST</strong>
                        </td>
                        <td align="right" width="20%" class="pototal">
                            <?php 
                              $gstCharges = $total * $model->gst_rate / 100;
                            ?>
                            <strong>USD <?= number_format((float)$gstCharges, 2, '.', '')?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" width="15%" class="pototal">
                            <strong>NET TOTAL</strong>
                        </td>
                        <td align="right" width="20%" class="pototal">
                            <strong>USD <?= number_format((float)$total+$gstCharges, 2, '.', '')?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td width="35%" valign="top" colspan="2" class="posign">
                            Authorized by:<br><strong>AERO INDUSTRIES (SINGAPORE) PTE LTD</strong>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="border-top capitalize">
                                <?=$model->authorized_by?><br>
                            </div>
                        </td>
                    </tr>
                </table>
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
