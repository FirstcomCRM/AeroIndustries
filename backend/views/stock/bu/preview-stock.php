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
use common\models\PurchaseOrder;
use common\models\Unit;


$dataPO = ArrayHelper::map(PurchaseOrder::find()->all(), 'id', 'purchase_order_no');
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');
$dataStorage = ArrayHelper::map(StorageLocation::find()->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
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
            <?= Html::a('<i class="fa fa-print"></i> Receiver', ['receiver', 'id' => $model->receiver_no], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('<i class="fa fa-print"></i> Sticker', ['sticker', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <?php Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>

            <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
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
                                    <?= $model->storage_location_id ? $dataStorage[$model->storage_location_id] : '' ?>
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
                                    <strong><?= "PO-" . sprintf("%008d", $dataPO[$model->purchase_order_id]) ?></strong>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Receiver No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <strong><?= "RE-" . sprintf("%008d", $dataPO[$model->receiver_no]) ?></strong>
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
                                    &nbsp;
                                    </div>
                                    <div class="col-sm-8">
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
                                        <label>Quantity:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->quantity ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Quantity Per Set:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->sub_quantity ?>
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
                                        <label>Total Quantity:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong><?= $model->sub_quantity * $model->quantity ?></strong>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php /*other batches */ ?>

                    <div class="box box-warning">

                        <div class="box-header with-border">
                          <h3 class="box-title">Other batches</h3>
                        </div>
                        <div class="box-body preview-po">
                            
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Quantity:</label>
                                </div>
                                <div class="col-sm-8">
                                    <strong><?= $otherBatchesQty ?></strong>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Sub Quantity:</label>
                                </div>
                                <div class="col-sm-8">
                                    <strong><?= $otherBatchesTotalQty ?></strong>
                                </div>
                            </div>

                            
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Total Quantity:</label>
                                </div>
                                <div class="col-sm-8">
                                    <strong><?= $otherBatchesQty + $model->quantity ?></strong>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Total Sub Quantity:</label>
                                </div>
                                <div class="col-sm-8">
                                    <strong><?= $otherBatchesTotalQty + ($model->sub_quantity * $model->quantity) ?></strong>
                                </div>
                            </div>


                        </div>
                    </div>
            
                <?php /* attachment*/ ?>
                    <div class="box box-danger">

                        <div class="box-header with-border">
                          <h3 class="box-title">Attachments</h3>
                        </div>

                        <div class="box-body preview-po">
                            <div class="row">

                                <div class="col-sm-6">
                                    <h5>Stock attachments:</h5>
                                <?php if ( !empty ( $oldAttachment ) ) { ?> 
                                    <?php foreach ( $oldAttachment as $at ) { 
                                        $attachmentClass = explode('\\', get_class($at))[2]; ?>
                                        <div class="col-sm-3 col-xs-12 shorten-text ">
                                            <a href="<?= 'uploads/'.$attachmentClass . '/' .$at->value ?>" target="_blank" style="text-overflow:ellipsis"><?= $at->value ?></a>
                                        </div>
                                    <?php } ?> 
                                <?php } else { ?> 
                                    <i>No attachment found!</i>
                                <?php } ?> 
                                </div>

                                <div class="col-sm-6">
                                        <h5>Attachment of <?= "PO-" . sprintf("%008d", $dataPO[$model->purchase_order_id]); ?>:</h5>
                                    <?php if ( !empty ( $poAttachment ) ) { ?> 
                                        <?php foreach ( $poAttachment as $poA ) { 
                                            $attachmentClass = explode('\\', get_class($poA))[2]; ?>
                                            <div class="col-sm-3 col-xs-12 shorten-text ">
                                                <a href="<?= 'uploads/'.$attachmentClass . '/' .$poA->value ?>" target="_blank" style="text-overflow:ellipsis"><?= $poA->value ?></a>
                                            </div>
                                        <?php } ?> 
                                    <?php } else { ?> 
                                        <i>No attachment found!</i>
                                    <?php } ?> 
                                </div>

                            </div>
                            <div class="row">
                            <br>
                            <br>
                            <br>
                                <div class="col-sm-6 col-xs-12">
                                    
                                    <?php $form = ActiveForm::begin(); ?>
                                       
                                       <?= $form->field($attachment, 'attachment[]')->widget(FileInput::classname(), [
                                            'options' => ['accept' => 'image/*'],
                                        ])->fileInput(['multiple' => true,])->label("Upload Stock's Attachment(s)") ?>



                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php /* attachmente */ ?>

                
                
            </div>
        </div>
    </section>
</div>
