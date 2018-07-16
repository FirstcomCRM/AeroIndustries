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


$dataCurrency = Currency::dataCurrencyISO();
$dataCurrencyISO = Currency::dataCurrencyISO();
$dataPart = Part::dataPart();
$dataPartReusable = Part::dataPartReusable();
$dataUnit = Unit::dataUnit();
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

$this->title = 'Stock Requisition (Issue)';

$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use kartik\file\FileInput;
?>
<div class="stock-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h2>
    </section>
    <div class="col-sm-12 text-right">
        <a class="btn btn-default" href="?r=work-order/preview&id=<?php echo $_GET['id']; ?> ">Back to Work Order</a>
        <br>
        <br>
        <!-- /.box-header -->
    </div>
    <section class="content stock-out-form">
        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php /* required parts */ ?>
                        <div class="modal fade modal-edit-stock" id="editStockId" tabindex="-1" role="dialog" aria-labelledby="editStockLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="editStockLabel">Stock Selection</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <input type="hidden" id="modal-req-id">
                                            <div class="form-group">
                                                <label class="control-label">Select Stock: <i>( hour used - expire date - batch no - shelf life)</i></label>
                                                <select class="select3 stock-dropdown form-control">
                                                </select>
                                            </div>
                                            <div class="modal-show-stock-detail">

                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary save-stock-id">Change</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-header with-border">
                              <h3 class="box-title">Parts Issue</h3>
                            </div>
                            <div class="box-body"> 
                            <?php if ( $requisition ) { ?>
                                <input id="gt" type="hidden" value="1">
                                <table class="table stock-requisition-table stock-out-table" width="100%">
                                    <thead>
                                        <tr>
                                            <td>Stock Out</td>
                                            <td>Quantity Required</td>
                                            <td>Quantity Issued</td>
                                            <td>UoM</td>
                                            <td>To Issue</td>
                                            <td>Issued Date</td>
                                            <td>Issued Time</td>
                                            <td>Issued By</td>
                                            <td>Issued To</td>
                                        </tr>
                                    </thead>
                                    <tbody class="selected-parts">
                                        <?php foreach ( $requisition as $reqq ) : ?>

                                            <?php /* if ( $reqq->qty_issued < $reqq->qty_required ) {*/ ?>
                                                <tr>
                                                    <td width="">
                                                        <?php if($dataPartReusable[$reqq->part_id]==1){ ?>
                                                            <a href="#" 
                                                            data-toggle="modal" 
                                                            data-target="#editStockId" 
                                                            data-stockid="<?=$reqq->stock_id?>"
                                                            data-partid="<?=$reqq->part_id?>"
                                                            data-reqid="<?=$reqq->id?>"
                                                            >
                                                                <?=$dataStock[$reqq->part_id]?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <?=$dataStock[$reqq->part_id]?>
                                                        <?php } ?>
                                                        <input type="hidden" name="WorkStockRequisition[stock_id][]" value="<?=$reqq->stock_id?>">
                                                        <input type="hidden" name="WorkStockRequisition[part_id][]" value="<?=$reqq->part_id?>">
                                                    </td>
                                                    <td width="6%">
                                                        <input type="text" class="form-control" readonly value="<?=$reqq->qty_required?>">
                                                    </td>
                                                    <td width="6%">
                                                        <input type="text" name="WorkStockRequisition[qty_issued][]" class="form-control" value="<?=!empty($reqq->qty_issued)&&$reqq->qty_issued>0?$reqq->qty_issued:'0'?>" readonly >
                                                    </td>
                                                    <td width="6%">
                                                        <input type="text" name="WorkStockRequisition[qty_issued][]" class="form-control" value="<?=!empty($reqq->uom)?$reqq->uom:''?>" readonly >
                                                    </td>
                                                    <td width=7%">
                                                        <input type="text" name="WorkStockRequisition[issue_qty][]" class="form-control" value="<?= $reqq->qty_required - ($reqq->qty_issued>0?$reqq->qty_issued:0)?>" <?=($reqq->qty_issued)>=($reqq->qty_required)?'readonly="readonly"':''?>>
                                                    </td>
                                                    <td width="11%">
                                                        <input type="text" id="datepicker" name="WorkStockRequisition[issued_date][]" class="form-control so-issued_date" value="<?=date('Y-m-d')?>">
                                                    </td>
                                                    <td width="15%">
                                                    <?php 
                                                        // usage without model
                                                        echo TimePicker::widget([
                                                            'name' => 'WorkStockRequisition[issued_time][]',
                                                            'class' => 'start_time form-control', 
                                                            'pluginOptions' => [
                                                                'minuteStep' => 1,
                                                                'showMeridian' => false,
                                                            ],
                                                        ]);?>
                                                    </td>
                                                    <td width="11%">
                                                        <select class="select2" id="so-issued_by" name="WorkStockRequisition[issued_by][]">
                                                            <?php foreach ( Staff::dataStaffId() as $id => $staff ) { ?>
                                                                <option value="<?=$id?>"><?=$staff?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td width="11%">
                                                        <select class="select2" id="so-issued_to" name="WorkStockRequisition[issued_to][]">
                                                            <?php foreach ( Staff::dataStaffId() as $id => $staff ) { ?>
                                                                <option value="<?=$id?>"><?=$staff?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td width="1%">
                                                    </td>
                                                </tr>


                                                <?php if ($reqq->status == 'issued') { ?>
                                                    <tr>
                                                        <td colspan="9">
                                                            <small class="text-red">** <?=$reqq->qty_issued?$reqq->qty_issued:0?> part were already issued ...</small>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            <?php /* } */ ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <table class="table stock-requisition-table stock-out-table">
                                    <tbody class=" added-issue">
                                        
                                    </tbody>
                                </table>
                                <div class="row"> 
                                    <div class="col-sm-12 text-right">
                                        <?php if ($reqq->status == 'issued') { ?>
                                           <a class="btn btn-success" href="?r=work-order/pick-list&id=<?php echo $_GET['id']; ?>&work_order_part_id=<?php echo $_GET['work_order_part_id']; ?>"><i class="fa fa-file"></i> Pick List</a>
                                        <?php } ?>
                                       <a class="btn btn-primary submit-btn" href="javascript:;"><i class="fa fa-save"></i> Issue</a>
                                    </div>
                                </div>
                            <?php  } else { ?>
                                No parts assigned
                            <?php  } ?>
                            </div>
                        </div>

                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
