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
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: ">
        
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
                    <img src="uploads/work_order/<?= $att[0]['value'] ?>" style="height:350px">
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
                        <tr>
                            <td colspan="3">
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
                        <?php $loop ++; ?>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>

    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:20px;font-size: 11px; page-break-inside: avoid ;">
        <tr>
            <td align="left">
                <h5><strong>In-Process Inspection and Hidden Damage Evaluation</strong></h5>
            </td>
        </tr>
        <tr>
            <td>
                <table class="preview-po work-order-print-table" width="100%" border="1">
                    <tr>
                        <td align="center" colspan="5" class="border-none">
                            <?php if ( $att ) {  ?>
                                <img src="uploads/hidden_damage/<?= $att[0]['value'] ?>" style="height:150px">
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if ($hiddenDamage) { ?>
                        <?php $loop = 1 ; ?>
                        <?php foreach ($hiddenDamage as $wP) { ?>
                            <tr>
                                <td valign="bottom" colspan="5">
                                    <label>Discrepancy <?=$loop?></label><br>
                                    <?= $wP->discrepancy ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" colspan="5">
                                    <label>Corrective Action</label><br>
                                    <?= $wP->corrective ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
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
                            <?php $loop ++ ; ?>
                        <?php } /* foreach */ ?>
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

                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
    
    <div class="print-footer">
        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem">
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
