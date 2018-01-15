<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Setting;
use common\models\Part;
use common\models\Unit;
use common\models\Stock;

$this->title = 'Bill of Materials';
$woNumber = 'Work Order No Missing';
if ( $model->work_scope && $model->work_type ) {
    $woNumber = Setting::getWorkNo($model->work_type,$model->work_scope,$model->work_order_no);
}
$dataPart = Part::dataPart();
$dataPartDesc = Part::dataPartDesc();
$dataPartUnit = Part::dataPartUnit();
$dataUnit = Unit::dataUnit();

            /*'model' => $model,
            'start' => $start,
            'no' => $no,*/
?>

    <!-- Content Header (Page header) -->
<div class="print-area print-bom-page">
    <?php if ( $workStockRequisition ) { ?>
        <table width="1050" align="center" class="devicewidth bom-top" style="background:white;border-radius:0.5rem;">
            <tr>
                <td colspan="7" align="center"><h3><u><i><strong>Bill of Materials</strong></i></u></h3></td>
            </tr>
            <tr>
                <td width="10%" rowspan="3">
                    <img src="images/logo.png" class="bom-logo">
                </td>
                <td width="10%" align="right">
                    Part Number: 
                </td>
                <td class="border-bottom" align="center"> 
                    <?=$model->part_no?>
                </td>
                <td width="5%">
                  
                </td>
                <td width="10%" align="right">
                    Work Order: 
                </td>
                <td class="border-bottom" align="center"> 
                    <?=$woNumber?>
                </td>
                <td width="5%">
                  
                </td>
            </tr>
            <tr>
                <td width="10%" align="right">
                    Description:
                </td>
                <td class="border-bottom" align="center"> 
                    <?=$model->desc?>
                </td>
                <td width="5%">
                  
                </td>
                <td width="10%" align="right">
                    Customer:
                </td>
                <td class="border-bottom" align="center"> 
                    <?=$model->customer->name?> 
                </td>
                <td width="5%">
                  
                </td>
            </tr>
            <tr>
                <td width="10%" align="right">
                    Quantity:
                </td>
                <td class="border-bottom" align="center"> 
                    <?=$model->quantity?>
                </td>
                <td width="5%">
                  
                </td>
                <td width="10%" align="right">
                    Job Type:
                </td>
                <td class="border-bottom" align="center"> 
                    <?=$model->work_scope?> 
                </td>
                <td width="5%">
                  
                </td>
            </tr>
            <tr>
                <td colspan="7" height="25">
                </td>
            </tr>
        </table>
        <table width="1050" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;">
            <tr class="bom-head">
                <td class="border-all" width="3%" align="center">S/N</td>
                <td class="border-all" width="20%" align="center">Part Number</td>
                <td class="border-all" align="center">Description</td>
                <td class="border-all" width="5%" align="center">UOM</td>
                <td class="border-all" width="10%" align="center">Qty Used</td>
                <td class="border-all" width="25%" align="center">Remark</td>
            </tr>
            <?php $loopNo = 1; ?>
            <?php foreach ($workStockRequisition as $wSR ) { ?>
                <tr>
                    <td class="border-all" align="center"><?= $loopNo ?></td>
                    <td class="border-all" align="center"><?= $dataPart[$wSR->part_id] ?></td>
                    <td class="border-all"><?= $dataPartDesc[$wSR->part_id] ?></td>
                    <td class="border-all" align="center"><?= $dataUnit[$dataPartUnit[$wSR->part_id]] ?></td>
                    <td class="border-all" align="center"><?= Part::checkReusable($wSR->part_id)?1:$wSR->qty_issued - $wSR->qty_returned ?></td>
                    <td class="border-all"><?=$wSR->remark?></td>
                </tr>
                <?php $loopNo++; ?>
            <?php } ?>
            <?php if ( $loopNo < 17 ) { ?>
                <?php $leftLoop = 17 - $loopNo; ?>
                <?php $loooop = 1; ?>
                <?php while ($loooop < $leftLoop ) { ?>
                    <tr>
                        <td class="border-all" align="center"><?=$loopNo?></td>
                        <td class="border-all" align="center"></td>
                        <td class="border-all"></td>
                        <td class="border-all" align="center"></td>
                        <td class="border-all" align="center"></td>
                        <td class="border-all"></td>
                    </tr>
                    <?php $loopNo ++; ?>
                    <?php $loooop ++; ?>
                <?php } ?>
             <?php } ?>
            <tr>
                <td colspan="2" align="right">
                    Prepared By:
                </td>
                <td class="border-bottom">
                    <br>
                </td>
                <td colspan="3" align="right" class="text-small">
                    Form AI-135<br>
                    Rev 0, 21 Sep 16
                </td>
            </tr>
        </table>
    <?php } ?>
</div>

<div class="row text-center">
    <div class="col-sm-5">
    </div>
    <div class="col-sm-1"><br>
        <button class="btn btn-danger form-control print-button">Print</button>
    </div>
    <div class="col-sm-1"><br>
        <button class="btn btn-default form-control close-button">Close</button>
    </div>
</div>
