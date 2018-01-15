<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Stock */
use common\models\Currency;
use common\models\Part;
use common\models\Stock;
use common\models\Unit;
use common\models\WorkOrder;
use common\models\Setting;
use common\models\Staff;


$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$dataWOA= WorkOrder::dataWorkOrder();
$dataWorkScope = WorkOrder::dataWorkScope();
$dataWorkType = WorkOrder::dataWorkType();
$dataWO = [];
foreach ( $dataWOA as $id => $dp) {
    $work_scope = $dataWorkScope[$id];
    $work_type = $dataWorkType[$id];
    if ( $work_scope && $work_type ) {
        $dataWO[$id] = Setting::getWorkNo($work_type,$work_scope,$dp);
    }
}

$dataStock = [];
foreach ( $stockQuery as $key => $dataSot ) {
    $dataStock[$dataSot['part_id']] = $dataSot['part_no'] . " - " . $dataSot['sumsQ'];
}

$this->title = 'Stock Requisition (Return)';

$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


use kartik\file\FileInput;
?>
<div class="stock-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2>
            <?= Html::encode($this->title) ?>
        </h2>
            <small></small>
        </h2>
    </section>
    <div class="col-sm-12 text-right">
            
        <br>
        <br>
        <!-- /.box-header -->
    </div>
    <section class="content stock-return-form">
        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php /* required parts */ ?>

                        <div class="box">
                            <div class="box-header with-border">
                              <h3 class="box-title">Parts Return</h3>
                            </div>
                            <div class="box-body"> 
                            <?php if ( $requisition ) { ?>
                                <input id="gt" type="hidden" value="1">
                                <table class="table stock-requisition-table stock-return-table">
                                    <thead>
                                        <tr>
                                            <td width="20%">Stock Out</td>
                                            <td width="10%">Qty Required</td>
                                            <td width="10%">Qty Issued</td>
                                            <td width="10%">Qty Returned</td>
                                            <td width="10%">Uom</td>
                                            <td width="10%">Return</td>
                                            <td width="10%">Hour Used</td>
                                            <td width="10%">Return Date</td>
                                            <td width="10%">Return Time</td>
                                            <td width="10%">Return By</td>
                                            <td width="10%">Return To</td>
                                        </tr>
                                    </thead>
                                    <tbody class="selected-parts">
                                        <?php foreach ( $requisition as $reqq ) : ?>
                                            <?php /* if ( $reqq->qty_returned < $reqq->qty_issued ) {*/ ?>
                                            <tr>
                                                <td width="">
                                                    <input type="text" class="form-control" value="<?=$dataStock[$reqq->part_id]?>" readonly>
                                                    <input type="hidden" name="WorkStockRequisition[stock_id][]" value="<?=$reqq->stock_id?>">
                                                    <input type="hidden" name="WorkStockRequisition[part_id][]" value="<?=$reqq->part_id?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" readonly value="<?=$reqq->qty_required?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="WorkStockRequisition[qty_issued][]" class="form-control" value="<?=$reqq->qty_issued?$reqq->qty_issued:($reqq->qty_required?$reqq->qty_required:'')?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="WorkStockRequisition[qty_returned][]" class="form-control" value="<?=$reqq->qty_returned>0?$reqq->qty_returned:0?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="WorkStockRequisition[uom][]" class="form-control" value="<?=!empty($reqq->uom)?$reqq->uom:''?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="WorkStockRequisition[return_qty][]" class="form-control" value="<?= $reqq->qty_issued - ($reqq->qty_returned>0?$reqq->qty_returned:0)?>" >
                                                </td>
                                                <td>
                                                    <input type="text" name="WorkStockRequisition[hour_used][]" class="form-control" value="" >
                                                </td>
                                                <td>
                                                    <input type="text" id="datepicker" name="WorkStockRequisition[returned_date][]" class="form-control so-returned_date" value="<?=date('Y-m-d')?>">
                                                </td>
                                                <td>
                                                <?php 
                                                    // usage without model
                                                    echo TimePicker::widget([
                                                        'name' => 'WorkStockRequisition[returned_time][]',
                                                        'class' => 'return_time form-control', 
                                                        'pluginOptions' => [
                                                            'minuteStep' => 1,
                                                            'showMeridian' => false,
                                                        ],
                                                    ]);?>
                                                </td>
                                                <td>
                                                    <select class="select2" id="so-returned_by" name="WorkStockRequisition[returned_by][]">
                                                        <?php foreach ( Staff::dataStaffId() as $id => $staff ) { ?>
                                                            <option value="<?=$id?>"><?=$staff?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="select2" id="so-returned_to" name="WorkStockRequisition[returned_to][]">
                                                        <?php foreach ( Staff::dataStaffId() as $id => $staff ) { ?>
                                                            <option value="<?=$id?>"><?=$staff?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <?php if ($reqq->status == 's') { ?>
                                                <tr>
                                                    <td colspan="9">
                                                        <small class="text-red">** The part above has been returned before...</small>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <?php /* }  if returned quantity moer than issued quantity, means all have returned */ ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <table class="table stock-requisition-table stock-return-table">
                                    <tbody class=" added-issue">
                                        
                                    </tbody>
                                </table>
                                <div class="row"> 
                                    <div class="col-sm-12 text-right">
                                       <a class="btn btn-primary submit-btn-return" href="javascript:;"><i class="fa fa-mail-reply"></i> Return</a>
                                    </div>
                                </div>
                            <?php  } else { /* if requisition */ ?>
                                No parts assigned
                            <?php  } ?>
                            </div>
                        </div>

                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
