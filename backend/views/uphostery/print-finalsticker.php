<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Setting;

$upNumber = 'Uphostery No Missing';
if ( $model->uphostery_scope && $model->uphostery_type ) {
    $upNumber = Setting::getUphosteryNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
}

$this->title = $upNumber . ' (Sticker) ' ;
if ( isset($_GET['start']) && isset( $_GET['no'] ) && isset($_GET['icon']) ) {
    $start = $_GET['start'];
    $no = $_GET['no'];
    $icon = $_GET['icon'];
}
?>

    <!-- Content Header (Page header) -->
<div class="print-area">
<br>
    <table align="center" style="font-size: 10px; width:210mm; height: 100%">
        <tr>
            <?php $loop = 1; ?>
            <?php $countNo = 1; ?>
            <?php while ( $loop < 17 ) { ?>
                <?php if ( $loop >= $start ) { ?>
                    <?php if ( $countNo <= $no ) { ?>
                        <td style="padding: 2px">
                            <table style="">
                                <tr>
                                    <td valign="top" width="25%">
                                        <?php if ( $icon == '1') { ?>
                                        <img src="images/logo.png" style="width:100px;margin-left: 20px">
                                        <?php } else { ?>
                                        <img src="images/fwd.png" style="width:40px;margin-left: 40px">
                                        <?php } ?>
                                    </td>
                                    <td width="75%">
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="height:115px;width:100%;margin-left: 20px;" >
                                            <tr>
                                                <td colspan="2" class="uppercase">
                                                    <strong style="font-size: 11px">Aero Industries (Singapore) Pte ltd</strong>
                                                </td>         
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong style="font-size: 11px"><i>28, Changi North Way, Singapore 498813</i></strong>
                                                </td>         
                                            </tr>
                                            <tr>
                                                <td width="20%">
                                                    DESC:
                                                </td>
                                                <td width="80%">    
                                                    <?= $uphosteryPart->desc ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    P/N:
                                                </td>
                                                <td>    
                                                    <?= $uphosteryPart->part_no ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Batch No:
                                                </td>
                                                <td>    
                                                    <?= $uphosteryPart->batch_no ? $uphosteryPart->batch_no : "N/A" ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    S/N:
                                                </td>
                                                <td>    
                                                    <?= $uphosteryPart->serial_no ? $uphosteryPart->serial_no : "N/A" ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    W/O:
                                                </td>
                                                <td>    
                                                    <?= $upNumber ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    DATE:
                                                </td>
                                                <td>    
                                                    <?= $model->date ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-size:8px;">
                                                    Form AI-023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rev: 3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dated: 9 Sep 2016
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
              
                        <?php $countNo ++; ?>
                    <?php }  ?>
                <?php } else { ?>
                    <td style="height:34mm; width:96mm;">
                       
                    </td>
                <?php } ?>

                <?php if ( $loop % 2 == 0 ) { ?>
                    </tr>
                <?php } ?>
            <?php $loop++; ?>
        <?php } /* foreach */ ?>
    </table>
</div>

<div class="row text-center">
    <div class="col-sm-5">
    </div>
    <div class="col-sm-1"><br>
        <button class="btn btn-danger form-control print-button">Print</button>
    </div>
    <div class="col-sm-1"><br>
        <button class="btn btn-warning form-control back-button">Back</button>
    </div>
</div>
