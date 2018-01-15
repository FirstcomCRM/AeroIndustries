<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Uphostery */

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\User;
use common\models\Setting;

$upNumber = 'Uphostery No Missing';
if ( $model->uphostery_scope && $model->uphostery_type ) {
    $upNumber = Setting::getUphosteryNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
}


$id = $model->id;
$this->title = $upNumber;
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
                <h1>
                    <strong><?= Html::encode($upNumber) ?></strong>
                </h1>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <?php if ( $att ) {  ?>
                    <table class="attachment_table">
                        <tr>
                            <?php $loop = 0; ?>
                            <?php foreach ( $att as $at ) : ?>
                                <?php if ( $loop % 3 == 0 ) {  
                                    echo "</tr><tr>";
                                 } ?>
                                <td style="padding: 5px;">
                                    <img src="uploads/uphostery/<?= $at['value'] ?>" style="height: 150px">
                                </td>
                                <?php $loop ++; ?>
                            <?php endforeach ; ?>
                        </tr>
                    </table>
                <?php } ?>
            </td>
        </tr>
        <tr> 
            <td colspan="3" align="center">
                &nbsp;
            </td>
        </tr>
        <tr> 
            <td colspan="3" align="center">
                <h3>
                   <u>Receiving Inspection Report</u>
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class="box-body preview-po uphostery-order-table receiving-table " width="100%">
                    <tr>
                        <td class="" colspan="2" valign="top" width="50%">
                            <label>Customer's Documents</label><br>
                            <?=$uphosteryPart->is_document?"Yes":"No";?>
                        </td>
                        <td class="" valign="top" width="50%">
                            <label>Part Number (as written in Customer's Documents)</label><br>
                            <?=$uphosteryPart->part_no_1?>
                        </td>
                    </tr>
                    <tr>
                        <td class="" colspan="2" valign="top">
                            <label>Customer's Tag</label><br>
                            <?=$uphosteryPart->is_tag?"Yes":"No";?>
                        </td>
                        <td align="left" valign="top">
                            <label>Part Number (as written in Customer Tag)</label><br>
                            <?=$uphosteryPart->part_no_2?>
                        </td>
                    </tr>
                    <tr>
                        <td class="" valign="top">
                            <label>Identification(ID) Tag</label><br>
                            <?=$uphosteryPart->is_id?"Yes":"No";?>
                        </td>
                        <td class="" valign="top">
                            <label>ID Tag Type</label><br>
                            <?=$uphosteryPart->tag_type?>
                        </td>
                        <td class="" valign="top">
                            <label>Part Number (as written in Identification Tag)</label><br>
                            <?=$uphosteryPart->part_no_3?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2" valign="top">
                            <label>Discrepancy with Customer's Documents</label><br>
                            <?=$uphosteryPart->is_discrepancy?"Yes":"No";?>
                        </td>
                        <td align="left" rowspan="2" valign="top" style="text-align: left;">
                            <label>Corrective action on discrepancy</label><br>
                            <div style=" padding-left: 4px">
                                <?=$uphosteryPart->corrective?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2" valign="top">
                            <label>Identification of Part Number From</label><br>
                            <?=$uphosteryPart->identify_from?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="3" valign="top" style="text-align: left;">
                            <label>Remark(s)</label><br>
                            <div style=" padding-left: 4px">
                                <?= $uphosteryPart->remarks ?>
                            </div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td colspan="3" align="right">
                <br>
                <strong>Form AI-118 Rev: 3</strong>
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
