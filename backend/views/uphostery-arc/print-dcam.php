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

    <table width="1050" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;">
    <?php /* col 7  */  ?>
        <tr>
            <td align="left" colspan="2" width="250" valign="top" class="border-all" style="padding-bottom: 0;">
                1. Country<br>
                <div style="text-align:center">
                    <h4>MALAYSIA</h4>
                </div>
            </td>
            <td align="left" colspan="4"  width="550" valign="top" class="border-all">
                2. Department of Civil Aviation Malaysia<br>
                <div style="text-align:center">
                    <strong style="font-size: 18px">AUTHORIZED RELEASE CERTIFICATE<br>DCA FORM 1</strong>
                </div>
            </td>
            <td align="left" colspan="2"  width="250" valign="top" class="border-all">
                3. Form Tracking Number<br>
                <div style="text-align:center; margin-top:15px; font-size: 14px">
                    <?php echo $woNumber; ?>
                    <?php if ($arc->is_tracking_no) { ?>
                    -<?=$arc->reprint?>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <tr>
            <td align="left" colspan="6" valign="top" class="border-all">
                4. Approved  Organisation Name and Address:<br>
                <div style="text-align:center">
                    <strong>AERO INDUSTRIES (SINGAPORE) PTE LTD<br>
                    28 CHANGI NORTH WAY<br>
                    SINGAPORE 498813</strong>
                </div>
            </td>
            <td align="left" colspan="2" valign="top" class="border-all">
                5. Uphostery/Contract/Invoice<br>
                <div style="text-align:center; margin-top:15px;">
                    <?= $woNumber ?>
                </div>

            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="td-small border-all">
                6. Item:
            </td>
            <td align="left" valign="top" class="td-small border-all">
                7. Description:
            </td>
            <td align="left" valign="top" class="td-small border-all">
                8. Part No.:
            </td>
            <td align="left" valign="top" colspan="2" class="td-small border-all">
                9. Qty:
            </td>
            <td align="left" valign="top" class="td-small border-all">
                10. Serial/ Batch No.
            </td>
            <td align="left" valign="top" class="td-small border-all">
                11. Status/ Work:
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
                    <?= $uphosteryPart->desc ?>
                </div>
            </td>
            <td align="left" valign="top" class="border-all">
                <div style="text-align:center">
                    <?= $uphosteryPart->new_part_no ? $uphosteryPart->new_part_no : $uphosteryPart->part_no?>
                </div>
            </td>
            <td align="left" valign="top" colspan="2" class="border-all">
                <div style="text-align:center">
                    <?= $uphosteryPart->quantity ?>
                </div>
                
            </td>
            <td align="left" valign="top" class="border-all">
                <div style="text-align:center">
                    <?= $uphosteryPart->serial_no ?>
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
                <div class="line1-dcam <?= $classLeft == '' ? 'hide':''?>"></div>
                <div class="line2-dcam <?= $classLeft == '' ? 'hide':''?>"></div>
                13. Certifies that the items identified above were manufactured in conformity to:<br>

                <?php if ( $arc->third_check ) { $rdcheck = 'check-'; } else { $rdcheck = ''; } ?> 
                <?php if ( $arc->forth_check ) { $thcheck = 'check-'; } else { $thcheck = ''; } ?> 
                <i class="fa fa-<?=$rdcheck?>square-o"> </i> Approved design data and are in condition for safe operation.<br>
                <i class="fa fa-<?=$thcheck?>square-o"> </i> Non-approved design data specified in Block 12.

            </td>
            <td colspan="3" class="<?= $classRight ?> border-all" width="50%">
                <div class="line3-dcam <?= $classRight == '' ? 'hide':''?>"></div>
                <div class="line4-dcam <?= $classRight == '' ? 'hide':''?>"></div>
                <?php if ( $arc->first_check ) { $stcheck = 'check-'; } else { $stcheck = ''; } ?> 
                <?php if ( $arc->second_check ) { $ndcheck = 'check-'; } else { $ndcheck = ''; } ?> 
                18. <i class="fa fa-<?=$stcheck?>square-o"> </i> MCAR Reg.32; Maintenance Release <i class="fa fa-<?=$ndcheck?>square-o"> </i> Other regulation specified in Block 12 <br>
                <br>
                  Certifies that unless otherwise specified in block 12, the work identified in block 11 and 
                  described in block 12, was accomplished in accordance with DCA Malaysia Requirement 
                  and in respect to that work the items are considered ready for release to service.
            </td>
        </tr>
        <tr>
            <td colspan="2" class="<?= $classLeft ?> border-all" align="left" valign="top" width="25%">
                14. Authorised Siganature<br>

            </td>
            <td colspan="2" class="<?= $classLeft ?> border-all" align="left" valign="top" width="25%">
                15. Approval/ Authorisation Number<br>

            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top" width="25%">
                19. Authorised Signature<br>

            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top" width="25%">
                20. Certificate/Approval Ref No:<br>
                <div style="text-align:center">
                    <strong>FAMO/2017/54</strong>
                </div>

            </td>
        </tr>
        <tr>
            
            <td colspan="2" align="left" valign="top" class="<?= $classLeft ?> border-all">
                16. Name<br>

            </td>
            <td colspan="2" align="left" valign="top" class="<?= $classLeft ?> border-all">
               17. Date (dd/mm/yyyy)<br>

            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top">
                21. Name<br>
                <div style="text-align:center">
                    <?= $arc->name ?>
                </div>
            </td>
            <td colspan="2" class="<?= $classRight ?> border-all" align="left" valign="top">
                22. Date (dd/mm/yyyy)<br>
                <div style="text-align:center">
                    <?php echo date('d/m/Y',strtotime($arc->date)); ?>
                    
                </div>

            </td>
        </tr>
        <tr>
            <td colspan="8" class="border-all">
                <div style="width:100%;text-align:center">
                    <strong>AUTHORISED RELEASE CERTIFICATE - DCA FORM 1</strong><br>
                    <strong>USER/INSTALLER RESPONSIBILITIES</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="8" class="border-all">
                <strong>NOTE:</strong><br>
                <p>1. It is important to understand that the existence of the Document alone does not automatically constitute authority to install the part/component/assembly.</p>
                <p>2. Where the user/installer works in accordance with the national regulations of an  Airworthiness Authority different from the Airworthiness Authority specified in block [2] it is essential that the user/installer ensures that his/her Airworthiness Authority accepts parts/components/assemblies from the Airworthiness Authority specified in block [2].</p>
                <p>3. Statements 13 and 18 do not constitute installation certification. In all cases the aircraft maintenance record must contain an installation certification issued in accordance with the national regulations  by the user/installer before the aircraft may be flown.</p>
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
