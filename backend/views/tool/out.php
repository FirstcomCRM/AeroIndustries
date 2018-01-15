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
use common\models\StorageLocation;
use common\models\Setting;



$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$dataWOA= WorkOrder::dataWorkOrder();
$dataWorkScope = WorkOrder::dataWorkScope();
$dataLocation = StorageLocation::dataLocation();
$dataWorkType = WorkOrder::dataWorkType();
$dataWO = [];
foreach ( $dataWOA as $id => $dp) {
    $work_scope = $dataWorkScope[$id];
    $work_type = $dataWorkType[$id];
    if ( $work_scope && $work_type ) {
        $dataWO[$id] = Setting::getWorkNo($work_type,$work_scope,$dp);
    }
}

// $dataStock = [];
// foreach ( $stockQuery as $key => $dataSot ) {
//     $dataStock[$dataSot['part_id']] = $dataSot['part_no'] . " - " . $dataSot['sumsQ'];
// }

$this->title = 'Issue Tool for Work';

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
    <section class="content stock-out-form">
        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title">Please fill in the following details</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $form->field($workPartUsed, 'work_order_id',['template' => 
                                        '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}</div> 
                                        {hint}'])->dropDownList($dataWO, ['class' => 'select2 form-control','prompt' => 'Please select Work Order'])->label('Work Order') ?>
                                </div>
                            </div>
                        <hr>
                        </div>

                    </div>

                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title">Tools Selected</h3>
                        </div>
                        <div class="box-body">
                            <table class="tool-out-table">
                                <thead>
                                    <tr>
                                        <td>Part Number</td>
                                        <td>Quantity</td>
                                        <td>UoM</td>
                                        <td width="15%">Quantity Issue</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($t) { ?>
                                        <?php foreach ($t as $tt) { ?>
                                            <tr>
                                                <td>
                                                    <?=$dataPart[$tt->part_id]?>
                                                </td>
                                                <td>
                                                    <?= $tt->qty ?>
                                                </td>
                                                <td>
                                                    <?= $dataUnit[$tt->unit_id] ?>
                                                </td>
                                                <td>
                                                    <input type="text" name="ToolSelected[<?=$tt->part_id?>]" class="form-control" id="issue-tool-<?=$tt->part_id?>">
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="row"> 
                                <div class="col-sm-12 text-right">
                                   <button class="btn btn-primary"><i class="fa fa-save"></i> Issue</button>
                                   <a class="btn btn-default back-button" href="javascript:;">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
