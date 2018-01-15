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

$upNumber = 'Uphostery No Missing';
if ( $model->uphostery_scope && $model->uphostery_type ) {
    $upNumber = Setting::getUphosteryNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
}
$id = $model->id;
$this->title = 'ARC - COC ' . $upNumber;
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
<div class="print-area print-arc print-coc">
    <table width="1050" cellpadding="32" height="780" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;">
        <tr>
            <td width="10%" height="0%"></td>
            <td width="12"></td>
            <td width="5%"></td>
            <td width="22%"></td>
            <td width="5%"></td>
            <td width="23%"></td>
            <td width="23%"></td>
        </tr>
        <tr>
            <td align="center" colspan="6" valign="top" class="border-all" height="5%">
                <div style="text-align:center" class="uppercase" colspan="3" >
                    <h3><strong>certificate of conformance</strong></h3>
                </div>
            </td>
            <td align="left" valign="top" class="border-all">
                Certificate Number<br>
                <div style="text-align:center;font-size: 15px;">
                    <?php echo $upNumber; ?>-<?=$arc->reprint?>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" colspan="2" width="150px" class="border-all border-right-none" height="10%">
                <img src="images/logo.png" style="width: 150px;">
            </td> 
            <td align="left" colspan="3" valign="top" class="border-all border-left-none border-right-none">
                <div style="text-align:center; font-size: 14px">
                    <strong>AERO INDUSTRIES (SINGAPORE) PTE LTD<br>
                    28 CHANGI NORTH WAY<br>
                    SINGAPORE 498813</strong>
                </div>
            </td>
            <td align="left" valign="top" class="border-all border-left-none">

            </td>
            <td align="left" valign="top" class="border-all">
               Customer Order Number<br><br>
                <div style="text-align:center; font-size: 15px;">
                    <?php echo $model->customer_po_no; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="minor-padding border-top border-right border-left" height="3%">
               Item
            </td>
            <td align="center" valign="top" colspan="3" class="minor-padding border-top border-right border-left">
               Description
            </td>
            <td align="center" valign="top" colspan="2" class="minor-padding border-top border-right border-left">
               Part Number/Location
            </td>
            <td align="left" valign="top" class="minor-padding border-top border-right border-left">
               Qty
            </td>
        </tr>
        <?php $loop = 1;  foreach ($uphosteryParts as $key => $uParts) { ?>
            <tr>
                <td align="center" valign="top" class="minor-padding border-right border-left" height="3%">
                   <?= $loop; ?>
                </td>
                <td align="center" valign="top" colspan="3" class="minor-padding border-right border-left">
                   <?=$uParts->desc?>
                </td>
                <td align="center" valign="top" colspan="2" class="minor-padding border-right border-left">
                   <?=$uParts->part_no?>
                </td>
                <td align="center" valign="top" class="minor-padding border-right border-left">
                   <?=$uParts->quantity?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td align="left" valign="top" colspan="7" class="border-all" height="30%">
               Remarks
            </td>
        </tr>
        <tr>
            <td align="center" valign="bottom" colspan="3" class="border-all" height="17%">
                Name:<div class="coc-underline"><?= $arc->name ?></div>
            </td>
            <td align="left" valign="bottom" colspan="2" class="border-all">
               Signed: <div class="coc-underline"></div>
            </td>
            <td align="left" valign="bottom" class="border-all">
               Date: <div class="coc-underline"><?= date('j F Y', strtotime($arc->date)); ?></div>
            </td>
            <td align="left" valign="bottom" class="border-all">
               Stamp: <div class="coc-underline"></div>
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
