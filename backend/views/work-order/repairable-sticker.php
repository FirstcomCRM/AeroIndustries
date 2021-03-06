<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Setting;
use common\models\Capability;

$woNumber = 'Work Order No Missing';
if ( $model->work_scope && $model->work_type ) {
    $woNumber = Setting::getWorkNo($model->work_type,$model->work_scope,$model->work_order_no);
}



$id = $model->id;
$this->title = $woNumber . ' (Sticker) ' ;
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


/*plugins*/
use kartik\file\FileInput;
?>
<div class="final-sticker-form">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Print Repairable Sticker</h1>
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
                            
                                <div class="print-area">
                                    <table align="center" style="font-size: 15px;">
                                        <tr>
                                            <td style="height:134px;width:362px;">
                                                <div style="margin-left: 10px;">
                                                    <?php
                                                        if ( $model->date ) {
                                                            $e = explode('-', $model->date);
                                                            $newDate = $e[2].'/'.$e[1].'/'.$e[0];
                                                        }
                                                    ?>
                                                   <h5><strong>REPAIRABLE COMPONENT TAG</strong></h5><br>
                                                   CUSTOMER: <?=$model->customer->name?>&nbsp;&nbsp;&nbsp;WO#<?=$woNumber?><br>
                                                   DATE: <?=$newDate?>&nbsp;&nbsp;&nbsp;DESC: <?=Capability::getPartDesc($workOrderPart->part_no)?><br>
                                                   P/N: <?=$workOrderPart->part_no?>&nbsp;&nbsp;&nbsp;S/N: <?=$workOrderPart->serial_no?><br>
                                                   INSPECTOR: _____________________<br>
                                                   Form AI - 018 Rev: Dated 9/1/2008<br>
                                                </div>
                                            </td>   
                                        </tr>
                                    </table>
                                </div>
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
            'work_order_no',
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