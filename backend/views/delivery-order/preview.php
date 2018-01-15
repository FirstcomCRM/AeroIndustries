<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\User;
use common\models\WorkOrder;


$poNumber = "DO-" . sprintf("%008d", $model->delivery_order_no);
$id = $model->id;
$this->title = "DO-" . sprintf("%008d", $model->delivery_order_no);
$this->params['breadcrumbs'][] = ['label' => 'Delivery Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$dataWorkOrder = ArrayHelper::map(WorkOrder::find()->all(), 'id', 'work_order_no');

/*plugins*/
use kartik\file\FileInput;
?>
<div class="purchase-order-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($poNumber) ?>
            <small></small>
        </h1>
    </section>
    <div class="col-sm-4 text-left">
            <?php Html::a('<i class="fa fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>

           
    </div>
    <div class="col-sm-8 text-right">

            <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>

            <?= Html::a( 'Print', Url::to(['print', 'id' => $model->id]), array('class' => 'btn btn-warning' ,'target' => '_blank')) ?>
        <br>
        <br>
        <!-- /.box-header -->
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= Html::encode($poNumber) ?></h3>
                    </div>

                    

                    <div class="box-body preview-po">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Customer:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $dataCustomer[$model->customer_id] ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Contact No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->contact_no ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Ship To:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->ship_to ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Date Issued:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?php 
                                        $exIssue = explode(' ',$model->date);
                                        $is = $exIssue[0];
                                        
                                        $time = explode('-', $is);
                                        $monthNum = $time[1];
                                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                        $monthName = $dateObj->format('M'); // March
                                        $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                    ?>
                                    <?= $issueDate ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php /* product ordered */ ?>
                <div class="box box-success">

                    <div class="box-header with-border">
                      <h3 class="box-title">Parts Ordered</h3>
                    </div>

                    <div class="po-table box-body">
                        <div class="po-table-header">
                            <div class="row">
                                <div class="col-sm-1">
                                    #
                                </div>
                                <div class="col-sm-2">
                                    Part No
                                </div>
                                <div class="col-sm-2">
                                    Description
                                </div>
                                <div class="col-sm-1">
                                    Qty
                                </div>
                                <div class="col-sm-2">
                                    WO
                                </div>
                                <div class="col-sm-2">
                                    Remarks
                                </div>
                                <div class="col-sm-2">
                                    PO/RO No.
                                </div>
                            </div>
                        </div>
                        <?php $loop = 1 ; foreach ( $detail as $dd ) { ?>

                            <div class="row">
                                <div class="col-sm-1">
                                    <?= $loop ?> 
                                </div>
                                <div class="col-sm-2">
                                    <?= $dd->part_no ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $dd->desc ?>
                                </div>
                                <div class="col-sm-1">
                                    <?= $dd->quantity ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $dd->work_order_no ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $dd->remark ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $dd->po_no ?>
                                </div>
                            </div>

                        <?php $loop ++; } ?>
                   
                    </div>


                </div>
                <?php /* product ordered e*/ ?>
                <?php /* po payment */ ?>

            </div>
        </div>
    </section>
</div>
