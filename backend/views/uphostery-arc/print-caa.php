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
use common\models\Staff;
use common\models\Setting;

$woNumber = 'Uphostery No Missing';
if ( $model->uphostery_scope && $model->uphostery_type ) {
    $woNumber = Setting::getUphosteryNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
}
$id = $model->id;
$this->title = 'ARC - CAAS ' . $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataStaff = ArrayHelper::map(Staff::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
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
$classLeft = 'unused';
$classRight = '';
if ( $model->uphostery_scope == 'Production') {
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
    <table width="1050" cellpadding="32" cellspacing="0" border="1" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;">
    <?php /* col 7  */  ?>
        <tr>
            <td align="left" colspan="2" width="250" valign="top">
                1. Country<br>
                <div style="text-align:center">
                    <h4>Singapore</h4>
                </div>
            </td>
            <td align="left" colspan="4"  width="550" valign="top">
                2<br>
                <div style="text-align:center">
                    CIVIL AVIATION AUTHORITY OF SINGAPORE<br>
                    <strong style="font-size: 14px">AUTHORISED RELEASE CERTIFICATE</strong><br>
                    CAAS(AW)95
                </div>
            </td>
            <td align="left" colspan="2"  width="250" valign="top">
                3. Form Tracking Number<br>
                <div style="text-align:center; margin-top:15px; font-size: 14px">
                    <?php echo 'AI'.sprintf("%005d", $arc->form_tracking_no); ?>
                    <?php if ($arc->is_tracking_no) { ?>
                    -<?=$arc->reprint?>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <tr>
            <td align="left" colspan="6" valign="top">
                4. Approved Organisation Name and Address<br>
                <div style="text-align:center">
                    <strong>AERO INDUSTRIES (SINGAPORE) PTE LTD<br>
                    28 CHANGI NORTH WAY<br>
                    SINGAPORE 498813</strong>
                </div>
            </td>
            <td align="left" colspan="2" valign="top">
                5. Uphostery/Contract/Invoice<br>
                <div style="text-align:center; margin-top:15px;">
                    <?= $woNumber ?>
                </div>

            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="td-small">
                6. Item
            </td>
            <td align="left" valign="top" class="td-small">
                7. Description
            </td>
            <td align="left" valign="top" class="td-small">
                8. Part No.
            </td>
            <td align="left" valign="top" class="td-small">
                9. Eligibility
            </td>
            <td align="left" valign="top" class="td-small">
                10. Quantity
            </td>
            <td align="left" valign="top" class="td-small">
                11. Serial/Batch No.
            </td>
            <td align="left" valign="top" class="td-small">
                12. Status/Work
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">
                <div style="text-align:center">
                    1
                </div>
            </td>
            <td align="left" valign="top">
                <div style="text-align:center">
                    <?= $uphosteryPart->desc ?>
                </div>
            </td>
            <td align="left" valign="top">
                <div style="text-align:center">
                    <?= $uphosteryPart->new_part_no ? $uphosteryPart->new_part_no : $uphosteryPart->part_no?>
                </div>
            </td>
            <td align="left" valign="top">
                <div style="text-align:center">
                    N/A
                </div>
            </td>
            <td align="left" valign="top">
                <div style="text-align:center">
                    <?= $uphosteryPart->quantity ?>
                </div>
                
            </td>
            <td align="left" valign="top">
                <div style="text-align:center">
                    <?php if ( ! $serial && ! $batch ) { ?>
                        N/A
                    <?php } else if ( $serial && ! $batch ) { ?>
                        <?= $uphosteryPart->serial_no ?>
                    <?php } else if ( !$serial && $batch) { ?>
                        <?= $uphosteryPart->batch_no ?>
                    <?php } else if ( $serial && $batch) { ?>
                        <?= $uphosteryPart->serial_no ?> /
                        <?= $uphosteryPart->batch_no ?>
                    <?php } ?>
                </div>
                
            </td>
            <td align="left" valign="top">
                <div style="text-align:center" class="capitalize">
                    <?= $arc->arc_status?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="7" height="60px" valign="top">
                13. Remarks<br>
                <div style=" margin-left: 100px">
                    <?= $arc->arc_remarks ?>
                </div>

            </td>
        </tr>
        <tr>
            <td colspan="4" align="left" valign="top" class="<?= $classLeft ?>" width="50%">
                <div class="line1 <?= $classLeft == '' ? 'hide':''?>"></div>
                <div class="line2 <?= $classLeft == '' ? 'hide':''?>"></div>
                14. New Parts<br>
                Certifies that the items identified above were manufactured in conformity to:<br>
                <?php if ( $arc->third_check ) { $rdcheck = 'check-'; } else { $rdcheck = ''; } ?> 
                <?php if ( $arc->forth_check ) { $thcheck = 'check-'; } else { $thcheck = ''; } ?> 
                <i class="fa fa-<?=$rdcheck?>square-o"> </i> Approved design data and are in condition for safe operation<br>
                <i class="fa fa-<?=$thcheck?>square-o"> </i> Non-approved design data specified in Block 13  <br>

            </td>
            <td colspan="3" class="<?= $classRight ?>" width="50%">
                <div class="line3 <?= $classRight == '' ? 'hide':''?>"></div>
                <div class="line4 <?= $classRight == '' ? 'hide':''?>"></div>
                19. USED PARTS<br>
                <?php if ( $arc->first_check ) { $stcheck = 'check-'; } else { $stcheck = ''; } ?> 
                <?php if ( $arc->second_check ) { $ndcheck = 'check-'; } else { $ndcheck = ''; } ?> 
                <i class="fa fa-<?=$stcheck?>square-o"> </i> SAR-145.50 Release to Service <br>
                <i class="fa fa-<?=$ndcheck?>square-o"> </i> Other regulation specified in Block 13 <br>
                <br>
                Certifies that unless specified in Block 13, the work identified in Block 12 and described in Block 13, was accomplished
                 in accordance with SAR-145 and the Air Navigation Order and 
                in respect to that work the items are considered ready for release to service. 
            </td>
        </tr>
        <tr>
            <td colspan="2" class="<?= $classLeft ?>" align="left" valign="top" width="25%">
                15. Authorised Siganature<br>
            </td>
            <td colspan="2" class="<?= $classLeft ?>" align="left" valign="top" width="25%">
                16. CAAS Approval No<br>
                <div style="text-align:center">
                    <strong><?= $classLeft == '' ? 'AWI/POA/012' : ''?></strong>
                </div>
            </td>
            <td colspan="2" class="<?= $classRight ?>" align="left" valign="top" width="25%">
                20. Authorised Signature<br>
            </td>
            <td colspan="2" class="<?= $classRight ?>" align="left" valign="top" width="25%">
                21. CAAS Approval No:<br>
                <div style="text-align:center">
                    <strong><?= $classRight == '' ? 'AWI/254' : ''?></strong>
                </div>
            </td>
        </tr>
        <tr>
            
            <td colspan="2" align="left" valign="top" class="<?= $classLeft ?>">
                17. Name<br>
                <div style="text-align:center">
                    <?= $classLeft == '' ? $arc->name : ''?>
                </div>
            </td>
            <td colspan="2" align="left" valign="top" class="<?= $classLeft ?>">
                18. Date (dd/mm/yyyy)<br>
                <div style="text-align:center">
                    <?= $classLeft == '' ? date('d/m/Y',strtotime($arc->date)) : ''?>
                </div>
            </td>
            <td colspan="2" class="<?= $classRight ?>" align="left" valign="top">
                22. Name<br>
                <div style="text-align:center">
                    <?= $classRight == '' ? $arc->name : ''?>
                </div>
            </td>
            <td colspan="2" class="<?= $classRight ?>" align="left" valign="top">
                23. Date (dd/mm/yyyy)<br>
                <div style="text-align:center">
                    <?= $classRight == '' ? date('d/m/Y',strtotime($arc->date)) : ''?>
                </div>
            </td>
        </tr>
    </table>
    <table width="1050" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;">
        <tr>
            <td width="30%" class="ins" style="padding: 0;">
                <strong>CASSS(AW)95 - Issue 2</strong>
            </td>
            <td colspan="6" align="right" valign="top" class="ins" style="padding: 0;">
                * Installer must cross check eligibility with applicable technical data 
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" valign="top" style="padding: 0;">
                <h4><strong>USER / INSTALLER RESPONSIBILITIES</strong></h4>
            </td>
        </tr>
        <tr>
            <td style="font-size: 10px; padding: 0" colspan="2">
                Note
                <ul>
                    <li>1. It is important to understand that the existance of the Certificate alone does not automaticcally constitute authority to install the part/componenet/assembly</li>
                    <li>2. Where the user/installer works in accordance with the national regulations of an Airworthiness Authority different from the Civil Aviation Authority of Singapore (CAAS), it is essential that the user/installer ensures that his/her Airworthiness Authority accepts parts/components/assemblies from the CAAS. </li>
                    <li>3. Statements 14 and 19 do not constitute installation certification. In all cases, the aircraft maintenance record must contain an installation certification issued in accordance with the national regulations by the user/installer before the aircraft may be flown. </li>
                </ul>
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
