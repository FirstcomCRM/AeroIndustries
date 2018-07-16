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
use common\models\StorageLocation;
use common\models\Stock;
use common\models\PurchaseOrder;
use common\models\Staff;
$this->title = 'Materials Requisition Form';
$woNumber = 'Uphostery No Missing';
if ( $model->uphostery_scope && $model->uphostery_type ) {
    $woNumber = Setting::getUphosteryNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
}
$dataPart = Part::dataPart();
$dataPartDesc = Part::dataPartDesc();
$dataPartUnit = Part::dataPartUnit();
$dataUnit = Unit::dataUnit();
$dataStaffId = Staff::dataStaffId();

            /*'model' => $model,
            'start' => $start,
            'no' => $no,*/

?>

    <!-- Content Header (Page header) -->
<div class="print-area print-mrf-page">
    <?php if ( $UphosteryStockRequisition ) { ?>
        <table width="1050" align="center" class="devicewidth mrf-top" style="background:white;border-radius:0.5rem;">
            <tr>
                <td width="3%">
                </td>
                <td width="36%">
                    <div class="padding-5 border-all">
                        <table class="mrf-top-left-box">
                            <tr>
                                <td align="center" width="20"> 
                                   
                                </td>
                                <td width="20%" align="right">
                                    Part Number: 
                                </td>
                                <td align="center" width="10"> 
                                   
                                </td>
                                <td class="border-bottom" align="center"> 
                                    <?=$uphosteryPart->part_no?>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" width="20"> 
                                   
                                </td>
                                <td width="20%" align="right">
                                    Description:
                                </td>
                                <td align="center" width="10"> 
                                   
                                </td>
                                <td class="border-bottom" align="center"> 
                                    <?=$uphosteryPart->desc?>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" width="20"> 
                                   
                                </td>
                                <td width="20%" align="right">
                                    Uphostery: 
                                </td>
                                <td align="center" width="10"> 
                                   
                                </td>
                                <td class="border-bottom" align="center"> 
                                    <?=$woNumber?>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" width="20"> 
                                   
                                </td>
                                <td width="20%" align="right">
                                    Job Type:
                                </td>
                                <td align="center" width="10"> 
                                   
                                </td>
                                <td class="border-bottom" align="center"> 
                                    <?=$model->uphostery_scope?> 
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td align="center"><h3><strong>MATERIALS REQUISITION FORM</strong></h3></td>
            </tr>
            <tr>
                <td height="10"></td>
            </tr>
        </table>


        <table width="1050" align="center" class="devicewidth mrf-table" style="background:white;border-radius:0.5rem;">
            <tr class="mrf-big-head">
                <td></td>
                <td class="border-all border-right-bold" colspan="4" align="center">To be filled by Supervisor. Signature: </td>
                <td class="border-all background-grey border-right-bold" colspan="6" align="center">To be filled by stockroom personnel upon issue. </td>
                <td class="border-all border-right-bold" align="center">Technician's Signature </td>
                <td class="border-all background-grey border-right-bold" colspan="6" align="center">To be filled upon returning materials. </td>
            </tr>
            <tr class="mrf-head">
                <td class="border-all" width="3%" align="center">S/N</td>
                <td class="border-all" width="12%" align="center">Material<br>Part Number</td>
                <td class="border-all" width="13%" align="center">Description</td>
                <td class="border-all" width="3%" align="center">UOM</td>
                <td class="border-all border-right-bold" width="5%" align="center">Qty Required</td>

                <td class="border-all" width="6%" align="center">Location</td>
                <td class="border-all" width="4%" align="center">PO No.</td>
                <td class="border-all" width="6%" align="center">Lot / Batch No.</td>
                <td class="border-all" width="5%" align="center">Qty Issued</td>
                <td class="border-all" width="6%" align="center">Date & Time Issued</td>
                <td class="border-all border-right-bold" width="5%" align="center">Issued By</td>

                <td class="border-all border-right-bold" width="5%" align="center">Issued To</td>

                <td class="border-all" width="5%" align="center">Qty Returned</td>
                <td class="border-all" width="6%" align="center">Date & Time Returned</td>
                <td class="border-all" width="6%" align="center">Returned By</td>
                <td class="border-all border-right-bold" width="5%" align="center">Returned To</td>

                <td class="border-all border-right-bold" width="5%" align="center">TOTAL<br>Qty Used</td>
            </tr>
            <?php $loopNo = 1; ?>
            <?php foreach ($UphosteryStockRequisition as $wSR ) { ?>
                <tr class="mrf-body">
                    <td class="border-all" width="3%" align="center"><?=$loopNo?></td>
                    <td class="border-all" width="12%" align="center"><?= $dataPart[$wSR->part_id] ?></td>
                    <td class="border-all" width="13%" align="center"><?= $dataPartDesc[$wSR->part_id] ?></td>
                    <td class="border-all" width="3%" align="center"><?= $dataUnit[$dataPartUnit[$wSR->part_id]] ?></td>
                    <td class="border-all border-right-bold" width="5%" align="center"><?= $wSR->qty_required ?></td>
                    
                    <td class="border-all" width="6%" align="center"><?= isset($wSR->stock->storageLocation->name)?$wSR->stock->storageLocation->name:''?></td>
                    <td class="border-all" width="4%" align="center"><?= isset($wSR->stock->purchaseOrder->purchase_order_no)?PurchaseOrder::getPONo($wSR->stock->purchaseOrder->purchase_order_no,$wSR->stock->purchaseOrder->created):''?></td>
                    <td class="border-all" width="6%" align="center"><?= isset($wSR->stock->batch_no)?$wSR->stock->batch_no:''?></td>
                    <td class="border-all" width="5%" align="center"><?=$wSR->qty_issued?></td>
                    <td class="border-all" width="6%" align="center"><?=$wSR->issued_time?></td>
                    <td class="border-all border-right-bold" width="5%" align="center"><?=isset($wSR->issued_by)?$dataStaffId[$wSR->issued_by]:''?></td>

                    <td class="border-all border-right-bold" width="5%" align="center"><?=isset($wSR->issued_to)?$dataStaffId[$wSR->issued_to]:''?></td>

                    <td class="border-all" width="5%" align="center"><?=$wSR->qty_returned>0?$wSR->qty_returned:0?></td>
                    <td class="border-all" width="6%" align="center"><?=$wSR->returned_time?></td>
                    <td class="border-all" width="6%" align="center"><?=isset($wSR->returned_by)?$dataStaffId[$wSR->returned_by]:''?></td>
                    <td class="border-all border-right-bold" width="5%" align="center"><?=isset($wSR->returned_to)?$dataStaffId[$wSR->returned_to]:''?></td>

                    <td class="border-all border-right-bold" width="5%" align="center"><?= Part::checkReusable($wSR->part_id)?1:$wSR->qty_issued - $wSR->qty_returned ?></td>
                </tr>
                <?php $loopNo++; ?>
            <?php } ?>
            <?php if ( $loopNo < 17 ) { ?>
                <?php $leftLoop = 17 - $loopNo; ?>
                <?php $loooop = 1; ?>
                <?php while ($loooop < $leftLoop ) { ?>
                    <tr class="mrf-body">
                        <td class="border-all" width="3%" align="center"><?=$loopNo?></td>
                        <td class="border-all" width="12%" align="center"></td>
                        <td class="border-all" width="13%" align="center"></td>
                        <td class="border-all" width="3%" align="center"></td>
                        <td class="border-all border-right-bold" width="5%" align="center"></td>

                        <td class="border-all" width="6%" align="center"></td>
                        <td class="border-all" width="4%" align="center"></td>
                        <td class="border-all" width="6%" align="center"></td>
                        <td class="border-all" width="5%" align="center"></td>
                        <td class="border-all" width="6%" align="center"></td>
                        <td class="border-all border-right-bold" width="5%" align="center"></td>

                        <td class="border-all border-right-bold" width="5%" align="center"></td>

                        <td class="border-all" width="5%" align="center"></td>
                        <td class="border-all" width="6%" align="center"></td>
                        <td class="border-all" width="6%" align="center"></td>
                        <td class="border-all border-right-bold" width="5%" align="center"></td>

                        <td class="border-all border-right-bold" width="5%" align="center"></td>
                    </tr>
                    <?php $loopNo ++; ?>
                    <?php $loooop ++; ?>
                <?php } ?>
             <?php } ?>
            <tr>
                <td colspan="10" align="left">
                    <u>Notes</u><br>
                    <ol>
                        <li>Stockroom personnel is to notify technician (at the point of issuance) material whose shelf life is affected by storage temperature.</li>
                        <li>Non-shelf life material and material whose shelf life are not room temperature sensitive do not require time recording.</li>
                        <li>Upon completion of this form, production is to ensure this form is filled within the work order package.</li>
                    </ol>

                </td>
                <td colspan="7" align="right" class="text-xsmall">
                    Form AI-137<br>
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
