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


$id = $model->id;
$this->title = $upNumber . ' (Sticker) ' ;
$this->params['breadcrumbs'][] = ['label' => 'Uphosterys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$icon = 1;

/*plugins*/
use kartik\file\FileInput;
?>
<div class="final-sticker-form">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sticker printing
        </h1>
    </section>
    <?php $form = ActiveForm::begin(); ?>

        <section class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Print</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box-body">
                            
                            <table align="center" style="font-size: 16px; width:210mm; height: 100%">
                                <tr>
                                    <td style="padding: 2px">
                                        <table style="">
                                            <tr>
                                                <td valign="top" width="25%">
                                                    <?php if ( $icon == '1') { ?>
                                                    <img src="images/logo.png" style="width:160px;margin-left: 20px">
                                                    <?php } else { ?>
                                                    <img src="images/fwd.png" style="width:40px;margin-left: 40px">
                                                    <?php } ?>
                                                </td>
                                                <td width="75%">
                                                    <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="height:115px;width:100%;margin-left: 20px;" >
                                                        <tr>
                                                            <td colspan="2" class="uppercase">
                                                                <strong style="font-size: 18px">Aero Industries (Singapore) Pte ltd</strong>
                                                            </td>         
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong style="font-size: 18px"><i>28, Changi North Way, Singapore 498813</i></strong>
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
                                                            <td colspan="2" style="font-size:14;">
                                                                Form AI-023&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rev: 3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dated: 9 Sep 2016
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-default close-button pull-right"><i class="fa fa-close"></i> Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php ActiveForm::end(); ?>
</div>


<?php 


        /*    'type',
            'uphostery_no',
            'customer_id',
            'customer_po_no',
            'date',
            'part_no',
            'received_date',
            'qc_notes',
            'inspection',
            'corrective',
            'disposition_note',
            'hidden_damage',
            'arc_remark',
            'created',
            'created_by',
            'updated',
            'updated_by',
            'approved',
            'deleted',
*/
?>