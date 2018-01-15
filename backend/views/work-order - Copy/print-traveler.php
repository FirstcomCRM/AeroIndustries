<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Work Order */

use common\models\Customer;
use common\models\Setting;


$woNumber = 'Work Order No Missing';
if ( $workOrder->work_scope && $workOrder->work_type ) {
    $woNumber = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
}

$id = $model->id;
$this->title = $model->traveler_no;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');

?>
    <!-- Content Header (Page header) -->
<div class="print-area">
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: 100%">
        <tr>
            <td align="center">
                <h3>
                    Traveler
                    <small><?= Html::encode($model->traveler_no) ?></small>
                </h3>
            </td>
        </tr>
        <tr>
            <td align="center">
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <div class="">

                    <table class="box-body preview-po traveler-table" width="100%">
                        <tr>
                            <td class="border-top border-left border-right">
                                <label>Work Order:</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Part Number</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Serial No/Batch No</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Customer</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Date on dock</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Need by date</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" class="border-bottom border-left border-right">
                                <?= $woNumber ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?= $workOrder->part_no ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?= $workOrder->serial_no ?> <?= $workOrder->batch_no ? '/ ' . $workOrder->batch_no : '' ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?= $dataCustomer[$workOrder->customer_id] ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?php 
                                    if ( $workOrder->on_dock_date ) { 
                                    $exIssue = explode(' ',$workOrder->on_dock_date);
                                    $is = $exIssue[0];
                                    
                                    $time = explode('-', $is);
                                    $monthNum = $time[1];
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('M'); // March
                                    $receDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;

                                ?>
                                <?= $receDate ?>
                                <?php } ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?php 
                                    if ( $workOrder->needs_by_date ) { 
                                    $exIssue = explode(' ',$workOrder->needs_by_date);
                                    $is = $exIssue[0];
                                    
                                    $time = explode('-', $is);
                                    $monthNum = $time[1];
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('M'); // March
                                    $receDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;

                                ?>
                                <?= $receDate ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top border-left border-right" colspan="3">
                                <label>Description</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Effectivity</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Revision Number</label>
                            </td>
                            <td class="border-top border-left border-right">
                                <label>Revision Date</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="3" class="border-bottom border-left border-right">
                                <?= $workOrder->desc ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?= $model->effectivity ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?= $model->revision_no ?>
                            </td>
                            <td align="left" class="border-bottom border-left border-right">
                                <?php 
                                    if ( $model->revision_date ) { 
                                    $exIssue = explode(' ',$model->revision_date);
                                    $is = $exIssue[0];
                                    
                                    $time = explode('-', $is);
                                    $monthNum = $time[1];
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('M'); // March
                                    $receDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;

                                ?>
                                <?= $receDate ?>
                                <?php } ?>
                            </td>
                        </tr>
                        
                    </table>

                </div>
            </td>
        </tr>
        <tr>
            <td align="left">
                <br>
            </td>
        </tr>
    </table> 
    <table id="traveler-content-table" width="646px" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: 100%">
        <tr>
            <td colspan="4">
                <div class="traveler-content">
                    <?=$model->content?>                    
                </div>
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
