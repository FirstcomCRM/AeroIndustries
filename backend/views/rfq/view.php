<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Rfq */

use common\models\Supplier;



$exDelivery = explode(' ',$model->date);
$dd = $exDelivery[0];

$time = explode('-', $dd);
$monthNum = $time[1];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('M'); // March
$date = $time[2] . ' ' .$monthName . ' ' .$time[0] ;

$this->title = $date;
$this->params['breadcrumbs'][] = ['label' => 'Rfqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataSupplier = Supplier::dataSupplier();

?>
<div class="rfq-view">


    <!-- Content Header (Page header) -->
    <section class="content-header capitalize">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title capitalize"><?= Html::encode($this->title) ?></h3>
                    </div>

                    <div class="col-sm-12 text-right">
                    <br>
                        <?= Html::a('<i class=\'fa fa-edit\'></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class=\'fa fa-trash\'></i> Delete', ['delete', 'id' => $model->id], [
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


                    <div class="box-body preview-po">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Supplier:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $dataSupplier[$model->supplier_id] ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Date:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $date ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Quotation No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->quotation_no ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Remark:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->remark ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Manufacturer:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->manufacturer ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Trace Cert:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->trace_certs?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Attachment</h4>
                            </div>
                            <div class="col-sm-12">
                                <?php if ( !empty ( $atta ) ) { ?> 
                                    <?php foreach ( $atta as $at ) { 
                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                        <?php 
                                            $fileNameOnlyEx = explode('-', $at->value);

                                        ?>
                                        <div class="col-sm-3 col-xs-12">
                                            <a href="<?= 'uploads/rfq/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                        </div>
                                    <?php } ?> 
                                <?php } else { ?> 
                                        <div class="col-sm-12 col-xs-12">
                                            No attachment found!
                                        </div>
                                <?php } ?> 
                            </div>
                        </div>
                    </div>


                    
                </div>
            </div>
        </div>
    </section>
</div>
