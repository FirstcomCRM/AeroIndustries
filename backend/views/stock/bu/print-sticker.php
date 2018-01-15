<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

use common\models\Part;
use common\models\StorageLocation;
use common\models\Unit;
use common\models\PurchaseOrder;
use common\models\Currency;
use common\models\Supplier;
/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['<>','status','inactive'])->all(), 'id', 'company_name');
$dataStorage = ArrayHelper::map(StorageLocation::find()->where(['<>', 'deleted', 1])->andWhere(['<>','status','inactive'])->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'part_no');
$dataPartType = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'type');
$dataUnit = ArrayHelper::map(Unit::find()->where(['<>','status','inactive'])->all(), 'id', 'unit');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPo = ArrayHelper::map(PurchaseOrder::find()->all(), 'id', 'purchase_order_no');
$dataReceiverNo = [];
foreach ( $receiverSelection as $dp) {
    $dataReceiverNo[$dp] =  "RE-" . sprintf("%008d", $dp);
}
/*plugins*/
use kartik\file\FileInput;
if ( isset ( $_GET['id'] ) && !empty ( $_GET['id'] )  ) {
    $model->purchase_order_id = $_GET['id'];
}


$this->title = 'Print Receiver';
$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$oldAttachment = false;
?>



 <section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
    <small>Please key in the following fields</small>
</section>
<div class="stock-form">
    <section class="content">
        <div class="form-group text-right">
            <button type="button" class="btn btn-default back-button"><i class="fa fa-arrow-left"></i> Back</button>
            &nbsp;
        </div>
        <?php $form = ActiveForm::begin(); ?>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Stock Details</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header with-border">
                                </div>
                                <!-- /.box-header -->
                                            
                                <div class="box-body ">

                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'purchase_order_id',['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div> {hint}'])
                                        ->dropDownList($dataReceiverNo, [
                                            'class' => 'select2 form-control',
                                            'prompt' => 'Please select receiver',
                                            'onchange' => 'printStickerRe()',
                                        ])
                                        ->label('Receiver No.') ?>



                                    </div>

                                </div><!--  box body -->

                            </div> <!-- box -->
                            <?php /* retrieve from PO */  ?>
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">PO Details</h3>
                                    </div>
                                    <div class="box-body">            

                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>PO No.:</label>
                                            </div>
                                            <div class="col-sm-8">

                                                <?= $stockWithTheSameReceiverNo[0][0]['purchase_order_id'] ? "PO-" . sprintf("%008d", $dataPo[$stockWithTheSameReceiverNo[0][0]['purchase_order_id']])  : '' ?>
                                            </div>
                                        </div> 

                                        <div class="col-sm-6 col-xs-12">
                                            <div class="col-sm-4">
                                                <label>Supplier:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= $stockWithTheSameReceiverNo[0][0]['supplier_id'] ? $dataSupplier[$stockWithTheSameReceiverNo[0][0]['supplier_id']] : '' ?>
                                            </div>
                                        </div>

                                    </div> <!-- box body -->
                                </div>




                            <?php if ( $stockWithTheSameReceiverNo ) { ?>

                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Stock in</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body table-responsive">            
                                        <table class="table table-striped table-bordered">

                                            <thead>
                                                <tr>
                                                    <th width="20px">#</th>
                                                    <th>Part</th>
                                                    <th width="100px">Received</th>
                                                    <th width="60px">Qty</th>
                                                    <th width="60px">UM</th>
                                                    <th width="100px">Sub Qty</th>
                                                    <th width="150px">Batch</th>
                                                    <th width="150px">Shelf Life (Hours)</th>
                                                    <th width="100px">Expire Date</th>
                                                    <th width="60px">Print</th>
                                                </tr>
                                            </thead>

                                            <?php $loop = 1; ?>

                                            <?php foreach ( $stockWithTheSameReceiverNo as $eachPartType ) { ?>.
                                                <?php foreach ( $eachPartType as $poD ) { ?>

                                                    <?php /* if not yet receive all */  ?>

                                                        <tr>
                                                            <td>
                                                               <?= $loop ?> 
                                                            </td>
                                                            <td>
                                                                <?= $dataPart[$poD['part_id']] ?> [<?= $dataPartType[$poD['part_id']] ?>]

                                                            </td>
                                                            <td>
                                                                <?= $poD['received'] ?>
                                                            </td>
                                                            <td rowspan="">
                                                                <?php 
                                                                    $ty = $poD['quantity'];
                                                                    if ( $dataPartType[$poD['part_id']] == 'tool' ) { 
                                                                        $ty = $toolQty;
                                                                    }
                                                                ?>
                                                                <?= $ty ?>
                                                            </td>
                                                            <td>
                                                                <?= $dataUnit[$poD['unit_id']] ?>
                                                            </td>
                                                            <td>
                                                                <?= $poD['sub_quantity'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $poD['batch_no'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $poD['shelf_life'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $poD['expiration_date'] ?>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="qty-to-print-<?= $poD['id'] ?>" class="form-control">
                                                                <input type="hidden" id="pt-<?= $poD['id'] ?>" class="form-control" value="<?= $poD['part_id'] ?>">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary" onclick="printSticker(<?= $poD['id'] ?>)"> <i class="fa fa-print"></i> Print</button>
                                                            </td>
                                                        </tr>

                                                    <?php $loop ++ ; ?>

                                                <?php } /* foreach poD */ ?>

                                            <?php } /* foreach stockWithTheSameReceiverNo */ ?>

                                        </table><!--  table -->

                                    </div> <!-- box body -->
                                </div> <!-- box -->

                            <?php } /* if stockWithTheSameReceiverNo = true */ ?>


                        </div>
                    </div>
                </div>

            </div> <!--  tab content -->
        </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
