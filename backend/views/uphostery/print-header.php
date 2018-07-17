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


?>
    <!-- Content Header (Page header) -->

<tr>
    <td width="20%">
        <img src="images/logo.png" style="width: 150px;">
    </td>
    <td align="right" width="60%">
        <div style="text-align:center; font-size: 8pt">
            Aero Industries (Singapore) Pte. Ltd.<br>
            28 Changi North way<br>
            Singapore 498813<br>
            Phone: (65) 6542 6288 &nbsp; &nbsp;
            Email: sales@aeroindustries.sg

        </div>
    </td>
    <td width="20%">
    </td>
</tr>
<tr>
    <td colspan="3">

            <table class="box-body preview-po receiving-table" width="100%">
                <tr style="display: none">
                    <td width="15%">
                    </td>
                    <td width="8%">
                    </td>
                    <td width="8%">
                    </td>
                    <td width="16%">
                    </td>
                    <td width="10%">
                    </td>
                    <td width="10%">
                    </td>
                    <td width="7%">
                    </td>
                    <td width="7%">
                    </td>
                    <td width="7%">
                    </td>
                    <td width="8%">
                    </td>
                    <td width="10%">
                    </td>
                </tr>
                <tr>
                    <td class="" valign="top">
                        <label>Upholstery:</label><br>
                        &nbsp;&nbsp;<?=$woNumber?>
                    </td>
                    <td class="" colspan="2" valign="top">
                        <label>Date Received: </label><br>
                        &nbsp;&nbsp;<?= $model->received_date ?>
                    </td>
                    <td class="" valign="top">
                        <label>Date Approved: </label><br>
                        &nbsp;&nbsp;<?= $model->approval_date ?>
                    </td>
                    <td class="" colspan="4" valign="top">
                        <label>Customer: </label><br>
                        &nbsp;&nbsp;<?= $dataCustomer[$model->customer_id] ?>
                    </td>
                    <td class="" colspan="3" valign="top">
                        <label>Customer PO/RO: </label><br>
                        &nbsp;&nbsp;<?= $model->customer_po_no ?>
                    </td>
                </tr>
                <tr>
                    <td class="" colspan="2" valign="top">
                        <label>Part Number:</label><br>
                        &nbsp;&nbsp;<?= $uphosteryPart->part_no ?>
                    </td>
                    <td class="" colspan="3" valign="top">
                        <label>Part Description: </label><br>
                        &nbsp;&nbsp;<?= $uphosteryPart->desc ?>
                    </td>
                    <td class="" colspan="2" valign="top">
                        <label>Serial Number: </label><br>
                        &nbsp;&nbsp;<?= $uphosteryPart->serial_no ?>
                    </td>
                    <td class="" colspan="3" valign="top">
                        <label>Batch Number: </label><br>
                        &nbsp;&nbsp;<?= $uphosteryPart->batch_no ?>
                    </td>
                    <td class="" valign="top">
                        <label>Qty: </label><br>
                        &nbsp;&nbsp;<?=$uphosteryPart->quantity ?>
                    </td>
                </tr>
                <tr>
                    <td class="" colspan="2" valign="top">
                        <label>Manufacturer:</label><br>
                        &nbsp;&nbsp;<?=$uphosteryPart->manufacturer?>
                    </td>
                    <td class="" colspan="3" valign="top">
                        <label>Eligibility: </label><br>
                        &nbsp;&nbsp;<?= $uphosteryPart->model ?>
                    </td>
                    <td class="" valign="top">
                        <label>A/C Tail No: </label><br>
                        &nbsp;&nbsp;<?=$uphosteryPart->ac_tail_no?>
                    </td>
                    <td class="" colspan="3" valign="top">
                        <label>A/C MSN: </label><br>
                        &nbsp;&nbsp;<?=$uphosteryPart->ac_msn?>
                    </td>
                    <td class="" colspan="2" valign="top">
                        <label>Job Type: </label><br>
                        &nbsp;&nbsp;<?=$model->uphostery_type?>
                    </td>
                </tr>
                <tr>
                    <td class="" colspan="11" valign="top" style="text-align: left;">
                        <label>Remarks:</label><br>
                        <div style=" padding-left: 4px">
                            <?= $model->qc_notes ?>
                        </div>
                    </td>
                </tr>
            </table>
    </td>
</tr>
