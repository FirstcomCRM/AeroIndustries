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
use common\models\GeneralPo;
/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['<>','status','inactive'])->all(), 'id', 'company_name');
$dataStorage = ArrayHelper::map(StorageLocation::find()->where(['<>', 'deleted', 1])->andWhere(['<>','status','inactive'])->all(), 'id', 'name');
$dataPart = Part::dataPart();
$dataPartDesc = Part::dataPartDesc();
$dataPartType = Part::dataPartType();
$dataUnit = Unit::dataUnit();
$dataCurrency = Currency::dataCurrency();
$dataCurrencyISO = Currency::dataCurrencyISO();
$dataPO = PurchaseOrder::dataPO();
/*plugins*/
use kartik\file\FileInput;

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
                                <?php foreach ($stockWithTheSameReceiverNo as $faded) : ?>  
                                    <div class="col-sm-6 col-xs-12">
                                    <h3>Quantity: <?= !$isTool?$faded->quantity:$toolQty?></h3>
                                        <small>Store</small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>RECEIVING LABEL </strong> 

                                        <br>
                                        <small>
                                            P/N: <?= Html::encode($dataPart[$faded->part_id]) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            DESC: <?= Html::encode($dataPartDesc[$faded->part_id]) ?>&nbsp;&nbsp;&nbsp;&nbsp;

                                            <br>
                                            BATCH/LOT: <?= Html::encode($faded->batch_no) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            REC#<?= Html::encode(sprintf("%006d", $faded->receiver_no)) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php if(!$isTool) { ?>
                                                <?php $getPO = PurchaseOrder::getPurchaseOrder($faded->purchase_order_id); ?>
                                                <?= Html::encode(PurchaseOrder::getPONo($getPO->purchase_order_no,$getPO->created))?>
                                            <?php } else { ?>
                                                <?php $getGPO = GeneralPo::getGeneralPo($faded->general_po_id); ?>
                                                <?= Html::encode(GeneralPo::getGPONo($getGPO->purchase_order_no,$getGPO->created))?>
                                            <?php }  ?>

                                            <br>

                                            <?php 
                                                $receivedDate = '';
                                                if ( $faded->received ) {
                                                    $is = $faded->received;
                                                    
                                                    $time = explode('-', $is);
                                                    $monthNum = $time[1];
                                                    $receivedDate = $time[2] . '/' .$time[1] . '/' .$time[0] ;
                                                }
                                            ?>
                                            DATE REC: <?= Html::encode($receivedDate) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <?php 
                                                $expireDate = '';
                                                if ( $faded->expiration_date ) {
                                                    $is = $faded->expiration_date;
                                                    
                                                    $time = explode('-', $is);
                                                    $monthNum = $time[1];
                                                    $expireDate = $time[2] . '/' .$time[1] . '/' .$time[0] ;
                                                }
                                            ?>
                                            EXPIRATION DATE: <?= Html::encode($expireDate) ?>
                                            <br>
                                            Form AI-000 &nbsp;&nbsp;Rev: Dated: <?= explode(' ',$faded->created)[0]; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                            INSPECTOR: <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                                        </small> 
                                    </div>
                                <?php endforeach; ?>
                                </div><!--  box body -->
                            </div> <!-- box -->

                        </div>
                    </div>
                </div>

            </div> <!--  tab content -->
        </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
