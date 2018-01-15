<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Currency;
use common\models\Supplier;
use common\models\Part;
$reNumber = "RE-" . sprintf("%008d", $model->receiver_no);
$poNumber = "PO-" . sprintf("%008d", $po->purchase_order_no);
// $id = $model['id'];
$this->title = $reNumber;
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['receiver']];
$this->params['breadcrumbs'][] = $this->title;

$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
?>

    <!-- Content Header (Page header) -->
<div class="print-area">

    <table align="center" style="font-size: 12px; width:210mm; height: 100%">

        <tr class="">
            <td>
               <br> 
            </td>
        </tr>
        <tr class="">
            <?php $loop = 1; // for ( $loop = 1 ; $loop < $qty+1 ; $loop ++ )  { ?>
            <?php  while ( $loop < $q + 1  )  { ?>

            <td style="height:115px">
                <small>Store</small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>RECEIVING LABEL </strong> 

                <br>
                <small>
                    P/N: <?= Html::encode($dataPart[$model->part_id]) ?>&nbsp;&nbsp;
                    DESC: <?= Html::encode($model->desc) ?>&nbsp;&nbsp;

                    <br>
                    BATCH/LOT: <?= Html::encode($model->batch_no) ?>&nbsp;&nbsp;
                    <?= Html::encode($reNumber) ?>&nbsp;&nbsp;
                    <?= Html::encode($poNumber) ?>

                    <br>

                    <?php 
                        $receivedDate = '';
                        if ( $model->received ) {
                            $is = $model->received;
                            
                            $time = explode('-', $is);
                            $monthNum = $time[1];
                            $receivedDate = $time[2] . '/' .$time[1] . '/' .$time[0] ;
                        }
                    ?>
                    DATE REC: <?= Html::encode($receivedDate) ?>&nbsp;&nbsp;

                    <?php 
                        $expireDate = '';
                        if ( $model->expiration_date ) {
                            $is = $model->expiration_date;
                            
                            $time = explode('-', $is);
                            $monthNum = $time[1];
                            $expireDate = $time[2] . '/' .$time[1] . '/' .$time[0] ;
                        }
                    ?>
                    EXPIRATION DATE: <?= Html::encode($expireDate) ?>
                    <br>
                    Form AI-000 Rev: Dated: <?= explode(' ',$model->created)[0]; ?>&nbsp;&nbsp;
                    INSPECTOR: <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                </small> 
            </td>

            <?php if ( $loop % 2 == 0 ) { ?>
        </tr>

        <tr class="">
            <td>
               <br> 
            </td>
        </tr>
            <?php } ?>


        <?php $loop++; ?>


    <?php } /* foreach */ ?>
 
        
    </table>
</div>

<div class="row text-center">
    <div class="col-sm-5">
    </div>
    <div class="col-sm-1"><br>
        <button class="btn btn-danger form-control print-button">Print</button>
    </div>
    <div class="col-sm-1"><br>
        <button class="btn btn-warning form-control back-button">Back</button>
    </div>
</div>
