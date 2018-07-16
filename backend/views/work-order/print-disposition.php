<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Work Order */

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\User;
use common\models\Staff;
use common\models\Setting;

$woNumber = 'Work Order No Missing';
if ( $model->work_scope && $model->work_type ) {
    $woNumber = Setting::getWorkNo($model->work_type,$model->work_scope,$model->work_order_no);
}
$id = $model->id;
$this->title = $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataCustomerAddr1 = ArrayHelper::map(Customer::find()->all(), 'id', 'addr_1');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$dataStaffId = Staff::dataStaffId();
$serial = false;
$batch = false;
if ( !empty($model->serial_no) && $model->serial_no != 'N/A' ) { 
    $serial = true;
} 
if ( !empty($model->batch_no) && $model->batch_no != 'N/A' ) { 
    $batch = true;
} 


?>

    <!-- Content Header (Page header) -->
<div class="print-area">

    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: 100%">
        <?php include ('print-header.php');?>
        <tr>
            <td align="center" colspan="3">
                <h3>
                   <u>Disposition Report</u>
                </h3>
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="td-label">
                 Preliminary Inspection and Evaluation
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class="box-body preview-po work-order-print-table" width="100%" style="font-size: 11px;" border="1">
                    <?php $loop = 1; ?>
                    <?php foreach ($workPreliminary as $wP) { ?>
                        <tr>
                            <td colspan="6" valign="top">
                                <label>Discrepancy <?=$loop?></label><br>
                                <?= $wP->discrepancy ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" valign="top">
                                <label>Corrective Action</label><br>
                                <?= $wP->corrective ?>
                            </td>
                        </tr>
                        <?php $loop++; ?>
                    <?php } ?>
                </table>

              
            </td>
        </tr>
        <tr>
            <td colspan="3">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="3" class="td-label">
                 In-Process Inspection and Hidden Damage Evaluation
            </td>
        </tr>
        <tr>
            <td colspan="3">
                
                <table class="box-body preview-po work-order-print-table" width="100%" style="font-size: 11px;" border="1">
                    <?php if ( $hiddenDamage ) { ?>
                        <?php $loop = 1; ?>
                        <?php foreach ($hiddenDamage as $hD) : ?>
                            <tr>
                                <td colspan="6" valign="top">
                                    <label>Discrepancy <?=$loop?></label><br>
                                    <?= $hD->discrepancy ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" valign="top">
                                    <label>Corrective Action</label><br>
                                    <?= $hD->corrective ?>
                                </td>
                            </tr>
                            <?php $loop++; ?>
                        <?php endforeach; ?>
                    <?php } else { ?>
                            <tr>
                                <td colspan="6" valign="top">
                                    <label>Discrepancy <?=$loop?></label><br>
                                    N/A
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" valign="top">
                                    <label>Corrective Action</label><br>
                                    N/A
                                </td>
                            </tr>

                    <?php } ?>
                </table>
            </td>
        </tr>

        <tr><td colspan="3" class="td-label">&nbsp;</td></tr>

        <tr>
            <td class="td-label" valign="top">
                 PMA Part Used
            </td>
            <td colspan="2">
                <?= $workOrderPart->pma_used?>
            </td>
        </tr>

        <tr><td colspan="3" class="td-label">&nbsp;</td></tr>

        <tr>
            <td class="td-label" valign="top">
                 Repair Supervisor
            </td>
            <td colspan="2">
                <?= $dataStaffId[$workOrderPart->repair_supervisor] ?>
            </td>
        </tr>
    </table>
    <div class="print-footer">
        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px">
            <tr>
                <td class="td-label">
                    Authorised Signature
                </td>
                <td class="td-label text-right">
                    Date: <?=$workOrderPart->disposition_date?$workOrderPart->disposition_date:date('Y-m-d')?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    The Signature above Certifies that the work identified above was carried out in accordance with Regulations and in respect to that work the items are considered ready for release to service.
                </td>
            </tr>
            <tr>   
                <td>
                </td>
                <td align="right">
                    <strong>Form AI-118 &nbsp; &nbsp; Rev: 3</strong>
                </td>
            </tr>
        </table>
    </div>


    <div class="page-break"></div>

        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px">
            
            <tr>
                <td class="td-label">
                    Attachment(s):
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
            <?php foreach ( $disAttachment as $disA ) { ?>
            <tr>
                <td align="center">
                    <img src="uploads/disposition/<?= $disA->value ?>" style="height:400px">
                </td>
            </tr>
            <?php } ?>
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
