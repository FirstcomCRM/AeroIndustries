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
$this->title = 'ARC - EASA ' . $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataStaff = ArrayHelper::map(Staff::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$classLeft = 'unused';
$classRight = '';
if ( $model->work_scope == 'Production') {
    $classLeft = '';
    $classRight = 'unused';
}

?>

<style type="text/css">
    body {
        font-size: 10px;
    }
    @media print {


        @page { 
            size: landscape;
        }
    }
</style>

    <!-- Content Header (Page header) -->
<div class="print-area print-arc">

    <table width="1050" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;">
    <?php /* col 7  */  ?>
        <tr>
            <td align="left" colspan="2" width="250" valign="top" class="border-all">
                1. Approving Competent Authority / Country <br>
                <div style="text-align:center">
                    <strong>EASA</strong>
                </div>
            </td>
            <td align="left" colspan="4"  width="550" valign="top" class="border-all">
                <div style="text-align:center">
                    <h4><strong><i>AUTHORISED RELEASE CERTIFICATE</i><br>
                    EASA FORM 1</strong></h4>
                </div>
            </td>
            <td align="left" colspan="2"  width="250" valign="top" class="border-all">
                3. Form Tracking Number<br>
                <div style="text-align:center; margin-top:15px;">
                    <?php echo $woNumber; ?>-<?=$arc->reprint?>
                </div>
            </td>
        </tr>
        <tr>
            <td align="left" colspan="6" valign="top" class="border-all">
                4. Organisation Name and Address<br>
                <div style="text-align:center">
                    <strong>AERO INDUSTRIES (SINGAPORE) PTE LTD<br>
                    28 CHANGI NORTH WAY<br>
                    SINGAPORE 498813</strong>
                </div>
            </td>
            <td align="left" colspan="2" valign="top" class="border-all">
                5. Work Order/Contract/Invoice<br>
                <div style="text-align:center; margin-top:15px;">
                    <?= $woNumber ?>
                </div>

            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="td-small border-all">
                6. Item
            </td>
            <td align="left" valign="top" class="td-small border-all">
                7. Description
            </td>
            <td align="left" valign="top" class="td-small border-all">
                8. Part No.
            </td>
            <td align="left" valign="top" colspan="2" class="td-small border-all">
                9. Qty
            </td>
            <td align="left" valign="top" class="td-small border-all">
                10. Serial No.
            </td>
            <td align="left" valign="top" class="td-small border-all">
                11. Status/Work
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="border-all">
                <div style="text-align:center">
                    1
                </div>
            </td>
            <td align="left" valign="top" class="border-all">
                <div style="text-align:center">
                    <?= $workOrderPart->desc ?>
                </div>
            </td>
            <td align="left" valign="top" class="border-all">
                <div style="text-align:center">
                    <?= $workOrderPart->new_part_no ? $workOrderPart->new_part_no : $workOrderPart->part_no?>
                </div>
            </td>
            <td align="left" valign="top" colspan="2" class="border-all">
                <div style="text-align:center">
                    <?= $workOrderPart->quantity ?>
                </div>
                
            </td>
            <td align="left" valign="top" class="border-all">
                <div style="text-align:center">
                    <?= $workOrderPart->serial_no ?>
                </div>
                
            </td>
            <td align="left" valign="top" class="border-all">
                <div style="text-align:center" class="capitalize">
                    <?= $arc->arc_status?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="7" height="60px" valign="top" class="border-all">
                12. Remarks<br>
                <div style=" margin-left: 100px">
                    <?= $arc->arc_remarks ?>
                </div>

            </td>
        </tr>
        <tr>
            <td colspan="4" align="left" valign="top" class="<?= $classLeft ?> border-all" width="50%">
                <div class="line1-easa <?= $classLeft == '' ? 'hide':''?>"></div>
                <div class="line2-easa <?= $classLeft == '' ? 'hide':''?>"></div>
                13a. Certifies that the items identified above were manufactured in conformity to:<br>

                <?php if ( $arc->third_check ) { $rdcheck = 'check-'; } else { $rdcheck = ''; } ?> 
                <?php if ( $arc->forth_check ) { $thcheck = 'check-'; } else { $thcheck = ''; } ?> 
                <i class="fa fa-<?=$rdcheck?>square-o"> </i> approved design data and are in a condition for safe operation<br>
                <i class="fa fa-<?=$thcheck?>square-o"> </i> non-approved design data specified in block 12

            </td>
            <td colspan="3" class="<?= $classRight ?> border-all" width="50%">
                <div class="line3-easa <?= $classRight == '' ? 'hide':''?>"></div>
                <div class="line4-easa <?= $classRight == '' ? 'hide':''?>"></div>
                <?php if ( $arc->first_check ) { $stcheck = 'check-'; } else { $stcheck = ''; } ?> 
                <?php if ( $arc->second_check ) { $ndcheck = 'check-'; } else { $ndcheck = ''; } ?> 
                14. <i class="fa fa-<?=$stcheck?>square-o"> </i> Part-145.A.50 Release to Service  <i class="fa fa-<?=$ndcheck?>square-o"> </i> Other regulation specified in Block 12 <br>
                <br>
                Certifies that unless otherwise specified in block 12, the work identified in block 11 
                and described in block 12, was accomplished in accordance with Part-145 and in
                respect to that work the items are considered ready for release to service.

            </td>
        </tr>
        <tr>
            <td colspan="2" class="<?= $classLeft ?> border-all" align="left" valign="top" width="25%">
                13b. Authorised Siganature<br>

            </td>
            <td colspan="2" class="<?= $classLeft ?> border-all" align="left" valign="top" width="25%">
                13c. Approval/ Authorisation Number<br>

            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top" width="25%">
                14b. Authorised Signature<br>

            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top" width="25%">
                14c. Certificate/Approval Ref No:<br>
                <div style="text-align:center">
                    <strong>EASA.145.0646</strong>
                </div>

            </td>
        </tr>
        <tr>
            
            <td colspan="2" align="left" valign="top" class="<?= $classLeft ?> border-all">
                13d. Name<br>

            </td>
            <td colspan="2" align="left" valign="top" class="<?= $classLeft ?> border-all">
               13e. Date (dd/mmmm/yyyy)<br>

            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top">
                14d. Name<br>
                <div style="text-align:center">
                    <?= $arc->name ?>
                </div>
            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top">
                14e. Date (dd/mmm/yyyy)<br>
                <div style="text-align:center">
                    <?php echo date('d/M/Y',strtotime($arc->date)); ?>
                    
                </div>

            </td>
        </tr>
        <tr>
            <td colspan="8" class="border-all">
                <div style="width:100%;text-align:center">
                    <strong>USER/INSTALLER RESPONSIBILITIES</strong><br><br>
                </div>

<p>This Certificate does not automatically constitute authority to install.</p>


<p>Where the user/installer performs work in accordance with regulations of an airworthiness authority different than the airworthiness authority specified in
block 1, it is essential that the user/installer ensures that his/her airworthiness authority accepts items from the airworthiness authority specified in block
1.</p>
<p>Statements in block(s) 13a and 14a do not constitute installation certification. In all cases aircraft maintenance records must contain an installation
certification issued in accordance with the national regulations by the user/installer before the aircraft may be flown.</p>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                EASA Form 1 - MF/145   Issue 2
            </td>
            <td colspan="4">
            </td>
        </tr>
    </table>
    <div class="next-page">&nbsp;</div>
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
