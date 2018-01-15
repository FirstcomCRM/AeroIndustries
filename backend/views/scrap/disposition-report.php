<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Customer;
use common\models\User;
use common\models\Setting;
use common\models\WorkOrder;

$getWorkOrder = WorkOrder::find()->where(['id' => $model->work_order_id])->one();

$woNumber = 'Work Order No Missing';
if ( $getWorkOrder->work_scope && $getWorkOrder->work_type ) {
    $woNumber = Setting::getWorkNo($getWorkOrder->work_type,$getWorkOrder->work_scope,$getWorkOrder->work_order_no);
}


$id = $model->id;
$this->title = "Disposition Report";
$this->params['breadcrumbs'][] = ['label' => 'Disposition Report', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataCustomerAddr = ArrayHelper::map(Customer::find()->all(), 'id', 'addr_1');

?>

    <!-- Content Header (Page header) -->
<div class="print-area">
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem">
        
        <tr>
            <td colspan="2">
            <br>
            <br>
            <br>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <div style="text-align:center; font-size: 10pt; font-weight:bold">
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
            <td colspan="2" align="center">
                <h1>
                    Certificate of Destruction
                    <small></small>
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

                    <table class="box-body preview-po" width="100%">
                        <tr>
                            <td width="20%" valign="top">
                                <label>Customer Name:</label>
                            </td>
                            <td width="28%" valign="top">
                                <?= $dataCustomer[$model->workOrder->customer_id] ?>
                            </td>
                            <td width="2%">
                            </td>
                            <td width="20%" valign="top">
                                <label>Customer PO:</label>
                            </td>
                            <td width="30%" valign="top">
                                <?= !empty ( $model->workOrder->customer_po_no ) ? $model->workOrder->customer_po_no : 'N/A';  ?>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="4" valign="top">
                                <label>Address:</label>
                            </td>
                            <td rowspan="4" valign="top">
                                <?= nl2br($dataCustomerAddr[$model->workOrder->customer_id])?>
                            </td>
                            <td>
                            </td>
                            <td>
                                <label>Work Order:</label>
                            </td>
                            <td>
                                <?= $woNumber ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td valign="top">
                                <label>Part:</label>
                            </td>
                            <td>
                                <?= $model->part_no ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td valign="top">
                                <label>Serial/Batch #:</label>
                            </td>
                            <td>
                                <?= $model->serial_no ?> /
                                <?= $model->batch_no ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td valign="top">
                                <label>Description:</label>
                            </td>
                            <td>
                                <?= $model->description ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <br>
                <br>
                <br>
                <br>
                <strong>This certificate is presented as evidence that the above listed aircraft part has been properly disposed of in accordance with FAA Order 8120.11 DISPOSITION OF SCRAP OR SALVAGEABLE AIRCRAFT PARTS AND MATERIALS by Aero Industries Pte. Ltd. The above mentioned part has been mutilated to the extent that it has been rendered unusable for its original intended purpose and subsequently disposed of.</strong>
            </td>
        </tr>
    </table>

    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem; margin-top: 100px;">
        <tr>
            <td width="55%">
            </td>
            <td width="5%">
            </td>
            <td width="20%">
            </td>
            <td width="5%">
            </td>
            <td width="20%" class="capitalize">
                <?php if ( $model->date ) { ?>
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
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="cod-border" width="55%">
                SIGNATURE
            </td>
            <td width="5%">
            </td>
            <td class="cod-border" width="20%">
                STAMP
            </td>
            <td width="5%">
            </td>
            <td class="cod-border" width="20%">
                Date(D/M/Y)
            </td>
        </tr>
    </table>
</div>

<div class="row text-center">
    <div class="col-sm-5">
        
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-danger form-control print-button">Print</button>
    </div>
</div>
