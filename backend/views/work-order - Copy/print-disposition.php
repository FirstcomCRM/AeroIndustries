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
            <td colspan="3">
                <table class="box-body preview-po" width="100%" >
                    <?php /* 6 col */ ?>
                    <tr>
                        <td class="td-label" width="90px">
                            Work Order #
                        </td>
                        <td width="100px">
                            <?= $woNumber ?>
                        </td>
                        <td class="td-label">
                            Part No
                        </td>
                        <td>
                            <?= $model->part_no ?>
                        </td>
                        <td class="td-label">
                            Description
                        </td>
                        <td>
                            <?= $model->desc ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label" valign="top">
                            Customer
                        </td>
                        <td colspan="3">
                            <?= $dataCustomer[$model->customer_id] ?>&nbsp;&nbsp;
                            PO: <?= $model->customer_po_no ?><br>
                            <?= nl2br($dataCustomerAddr1[$model->customer_id]) ?>
                        </td>
                        <td class="td-label" valign="top">
                            Serial/Batch Number
                        </td>
                        <td valign="top">
                            <?php if ( ! $serial && ! $batch ) { ?>
                                N/A
                            <?php } else if ( $serial && ! $batch ) { ?>
                                <?= $model->serial_no ?>
                            <?php } else if ( !$serial && $batch) { ?>
                                <?= $model->batch_no ?>
                            <?php } else if ( $serial && $batch) { ?>
                                <?= $model->serial_no ?> /
                                <?= $model->batch_no ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                        &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="td-label">
                             Teardown and Evaluation
                        </td>
                    </tr>
                    <?php foreach ($workPreliminary as $wP) { ?>
                        <tr>
                            <td valign="top">
                                Discrepancy
                            </td>
                            <td colspan="5">
                                <?= $wP->discrepancy ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                Corrective Action
                            </td>
                            <td colspan="5">
                                <?= $wP->corrective ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                &nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="6">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="td-label">
                             Hidden Damage Inspection
                        </td>
                    </tr>
                    <?php foreach ($hiddenDamage as $hD) { ?>
                        <tr>
                            <td valign="top">
                                Discrepancy
                            </td>
                            <td colspan="5">
                                <?= $hD->discrepancy ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                Corrective Action
                            </td>
                            <td colspan="5">
                                <?= $hD->corrective ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                &nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="6">
                            &nbsp;
                        </td>
                    </tr>
                     <tr>
                        <td colspan="6" class="td-label">
                             PMA Part Used
                        </td>
                    </tr>
                     <tr>
                        <td colspan="6">
                             <?= $model->pma_used?>
                        </td>
                    </tr>
                </table>
              
            </td>
        </tr>
    </table>
    <div class="print-footer">
        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px">
            <tr>
                <td class="td-label">
                    Certifying Staff Signature
                </td>
                <td class="td-label text-right">
                    Date: <?=$model->disposition_date?$model->disposition_date:date('Y-m-d')?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    The Signature above Certifies that the work specified above was carried out in accordance with Authority Regulation and in respect to the work performed the part is approved for return to service.
                </td>
            </tr>
        </table>
        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px">
            <tr>   
                <td>
                    Form AI-001 Rev: Dated: 1/9/2008
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
                    <img src="uploads/wo_dis/<?= $disA->value ?>" style="height:400px">
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
