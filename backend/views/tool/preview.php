<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
use common\models\Supplier;
use common\models\StorageLocation;
use common\models\Part;
use common\models\GeneralPo;
use common\models\Unit;


$dataAllGPO = GeneralPo::dataAllGPO();
$dataSupplier = Supplier::dataSupplier();
$dataLocation = StorageLocation::dataLocation();
$dataPart = Part::dataPart();
$dataUnit = Unit::dataUnit();
$this->title = $dataPart[$model->part_id];

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
            <?= Html::a('<i class="fa fa-edit"></i> Edit', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-print"></i> Receiver', ['stock/receiver', 'id' => $model->receiver_no], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('<i class="fa fa-print"></i> Sticker', ['stock/print-sticker', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <?php Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(' Back', ['preview-tool', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <br>
        <br>
        <!-- /.box-header -->
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Details</h3>
                    </div>

                    <div class="box-body preview-po">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Supplier:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->supplier_id ? $dataSupplier[$model->supplier_id] : '' ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Part No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->part_id ? $dataPart[$model->part_id] : '' ?>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Storage Location:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->storage_location_id ? $dataLocation[$model->storage_location_id] : '' ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Description:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->desc ?>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Batch No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->batch_no ?>
                                </div>
                            </div><div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Serial No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->serial_no ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Date Received:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?php 
                                    if ( $model->received ) { 
                                        $exIssue = explode(' ',$model->received);
                                        $is = $exIssue[0];
                                        
                                        $time = explode('-', $is);
                                        $monthNum = $time[1];
                                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                        $monthName = $dateObj->format('M'); // March
                                        $receivedDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                    ?>
                                    <?= $receivedDate ?>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Notes:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->note ?>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Status:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->status == 1 ? "Active" : "Inactive" ?>
                                </div>
                            </div>
                                
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>PO No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <strong><?= "GPO-" . sprintf("%006d", $dataAllGPO[$model->general_po_id]) ?></strong>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Receiver No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <strong><?= "RE-" . sprintf("%006d", $model->receiver_no) ?></strong>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

                <?php /* stock balance details */ ?>
                    <div class="box box-primary">

                        <div class="box-header with-border">
                          <h3 class="box-title">This Batch</h3>
                        </div>

                        <div class="box-body preview-po">
                            <div class="row">
                                
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Unit Price:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->unit_price ?>
                                    </div>
                                </div>


                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Expiration Date:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php 
                                        if ( $model->expiration_date ) { 
                                            $exDelivery = explode(' ',$model->expiration_date);
                                            $dd = $exDelivery[0];
                                            
                                            $time = explode('-', $dd);
                                            $monthNum = $time[1];
                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                            $monthName = $dateObj->format('M'); // March
                                            $expireDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                        ?>
                                        <?= $expireDate ?>
                                        <?php } ?>
                                    </div>
                                </div>



                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Shelf Life (Hours):</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->shelf_life ?>
                                    </div>
                                </div>


                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Hour used:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->hour_used ?>
                                    </div>
                                </div>


                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Quantity:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->quantity ?>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Unit:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $dataUnit[$model->unit_id] ?>
                                    </div>
                                </div>
                                

                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Last Calibration:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->last_cali ?>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Next Calibration:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->next_cali ?>
                                    </div>
                                </div>
                                

                            </div>
                        </div>
                    </div>

                <?php /*other batches */ ?>

                    
            </div>
        </div>
    </section>
</div>
