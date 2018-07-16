<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
use common\models\Currency;
use common\models\Part;
use common\models\Stock;
use common\models\Unit;
use common\models\WorkOrder;
use common\models\Setting;



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

$this->title = 'Stock Requisition (Required)';

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
                        <div class="box">
                            <div class="box-header with-border">
                              <h3 class="box-title">Parts Required</h3>
                            </div>
                            <div class="box-body"> 
                                <table class="table stock-requisition-table stock-required-table">
                                    <thead>
                                        <tr>
                                            <td>Parts Required</td>
                                            <td>Quantity Required</td>
                                            <td>UOM</td>
                                            <td>Remark</td>
                                            <td style="background: #fff"></td>
                                            <td align="left" colspan="2">Quantity Available</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="">
                                                <select id="so-part_id" class="form-control select2">
                                                    <option value="empt">Please select stock</option>
                                                    <?php foreach ( $dataStock as $partId => $dat ) { ?>
                                                        <option value="<?= $partId ?>"><?= $dat ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td width="8%">
                                                <input type="text" id="so-qty" class="form-control">
                                            </td>
                                            <td width="7%">
                                                <input type="text" id="so-uom" class="form-control">
                                            </td>
                                            <td width="30%">
                                                <input type="text" id="so-remark" class="form-control">
                                            </td>
                                            <td width="1%">
                                            </td>
                                            <td width="9%">
                                                <input type="text" id="so-st_qty" class="form-control" readonly>
                                            </td>
                                            <td width="5%">
                                                <a href='javascript:addStockRequired();'><i class="fa fa-plus"></i></a>
                                                <input type="hidden" id="n" value="0">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table added-required stock-requisition-table">
                                </table>

                                <div class="row"> 
                                    <div class="col-sm-12 text-right">
                                       <a class="btn btn-primary submit-btn" href="javascript:;"><i class="fa fa-save"></i> Save</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-header with-border">
                              <h3 class="box-title">Parts Required (History)</h3>
                            </div>
                            <div class="box-body"> 
                                <table class="table stock-requisition-table stock-required-table">
                                    <thead>
                                        <tr>
                                            <td>Parts Required</td>
                                            <td>Quantity Required</td>
                                            <td>Remark</td>
                                            <td style="background: #fff"></td>
                                            <td align="left" colspan="2">Quantity Available</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($currRequisition as $cR ): ?>
                                        <tr>
                                            <td width="">
                                                <?= $dataPart[$cR->part_id]?>
                                            </td>
                                            <td width="15%">
                                                <?= $cR->qty_required?>
                                            </td>
                                            <td width="30%">
                                                <?= $cR->remark?>
                                            </td>
                                            <td width="1%">
                                            </td>
                                            <td width="9%">
                                                <?= $cR->qty_stock?>
                                            </td>
                                            <td width="5%">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>

<script type="text/javascript"> confi(); </script>