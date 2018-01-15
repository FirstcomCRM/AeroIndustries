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


<?php /*page 1*/ ?> 
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: 100%">
        
        <?php include ('print-header.php');?>

        <tr class="">
            <td colspan="3" align="center">
                <h3>
                   <u>Detailed Inspection Report</u>
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <?php if ( 1 == 0 ) {  ?>
                    <img src="uploads/wo/<?= $att[0]['value'] ?>" style="height:350px">
                <?php } ?>
            </td>
        </tr>
    </table> 

<?php /*page 2*/ ?>    


    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;font-size: 11px;">
        <tr>
            <td>
                Preliminary inspection and Evaluation
                <table class="preview-po work-order-print-table" width="100%" border="1">
                    <?php foreach ($workPreliminary as $wP) { ?>
                        <tr>
                            <td colspan="6" valign="top">
                                <label>Discrepancy</label><br>
                                <?= $wP->discrepancy ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" valign="top">
                                <label>Corrective Action</label><br>
                                <?= $wP->corrective ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"
                                &nbsp;
                            </td>
                            <td width="25%" style="padding: 5px">
                                <strong>Inspector:</strong>
                                &nbsp;
                            </td>
                            <td width="25%" style="padding: 5px">
                                <strong>Date:</strong>
                                &nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <table class="preview-po" width="100%">
                    <tr>
                        <td class="td-label" colspan="2">
                            Technician
                        </td>
                        <td class="td-label" colspan="2">
                            Inspector
                        </td>
                        <td class="td-label" colspan="2">
                            Date
                        </td>
                    </tr>
                    <?php foreach ($technicians as $key => $t) { ?>
                    <tr>
                        <td colspan="2">
                            <?= $t->staff_name ?>
                        </td>
                        <td colspan="2">
                            <?= $inspector[$key]['staff_name']?>
                        </td>
                        <td colspan="2">
                            
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
    <div>
        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px">
            <tr>
                <td width="50%" valign="top">
                    <strong>Supervisor Signature and date</strong><br>
                    <?= $supervisor->staff_name ?>&nbsp;&nbsp;&nbsp;<?= $model->preliminary_date ?>
                </td>
                <td width="50%" valign="top">
                    <strong>Inspector Signature and date</strong><br>
                    &nbsp;&nbsp;&nbsp;<?= $model->preliminary_date ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <?php /*
            <tr>
                <td width="50%" valign="top">
                    <strong>Final Inspector Signature and date</strong><br>
                    <?= $finalInspector->staff_name ?>
                </td>
                <td width="50%">
                </td>
            </tr>
            */ ?>
            <tr>
                <td colspan="2">
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Form AI-019B Rev: Dated: 1/9/2008
                </td>
            </tr>
        </table>
    </div>


<?php /*page 3*/ ?>    
    <div class="page-break"></div>

    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px;font-size: 11px;">
        <tr>
            <td align="left">
                <h3>Work Order <?= $woNumber ?></h3>
            </td>
        </tr>
        <tr>
            <td>
                <table class="preview-po work-order-print-table" width="100%" border="1" >
                    <?php /* 6 col */ ?>
                    <tr>
                        <td class="td-label" width="180px">
                            Part Number/
                            Description
                        </td>
                        <td class="td-label" width="140px">
                            Serial/Batch Number
                        </td>
                        <td class="td-label">
                            Date Received
                        </td>
                        <td class="td-label">
                            Customer
                        </td>
                        <td class="td-label">
                            Customer PO
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= $model->part_no ?><br>
                            <?= $model->desc ?>
                        </td>
                        <td>
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
                        <td>
                            <?= $model->received_date ?>
                        </td>
                        <td>
                            <?= $dataCustomer[$model->customer_id] ?>&nbsp;&nbsp;
                        </td>
                        <td>
                            <?= $model->customer_po_no ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="td-label">
                             Hidden Damage Inspection
                        </td>
                    </tr>
                    <?php if ($hiddenDamage) { ?>
                        <?php foreach ($hiddenDamage as $wP) { ?>
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
                    <?php } else { ?>
                        <tr>
                            <td valign="top">
                                Discrepancy
                            </td>
                            <td colspan="5">
                                Nil
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                Corrective Action
                            </td>
                            <td colspan="5">
                                <br>
                                <br>
                                <br>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                &nbsp;
                            </td>
                        </tr>

                    <?php } ?>
                </table>
                <table class="box-body preview-po" width="100%" >
                    <tr>
                        <td class="td-label">
                            Technician
                        </td>
                        <td>
                            
                        </td>
                        <td class="td-label">
                            Inspector
                        </td>
                        <td>
                            
                        </td>
                        <td class="td-label">
                            Date
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    <?php foreach ($technicians as $key => $t) { ?>
                    <tr>
                        <td>
                            <?= $t->staff_name ?>
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            <?= $inspector[$key]['staff_name']?>
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
    <div class="print-footer">
        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px">
            <tr>
                <td width="50%" valign="top">
                    <strong>Supervisor Signature and date</strong><br>
                    <?= $supervisor->staff_name ?><br>
                    <?= $model->hidden_date ?>
                </td>
                <td width="50%" valign="top">
                    <strong>Inspector Signature and date</strong><br>
                    <?= $model->hidden_date ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Form AI-019C Rev: Dated: 1/9/2008
                </td>
            </tr>
        </table>
    </div>


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
