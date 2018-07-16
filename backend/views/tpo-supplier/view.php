<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Currency;
/* @var $this yii\web\View */
/* @var $model common\models\TpoSupplier */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tpo Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
?>
<div class="tpo-supplier-view">


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
                      <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                    </div>

                    <div class="col-sm-12 text-right">
                    <br>
                        <?= Html::a('<i class="fa fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
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

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Company Name:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->company_name ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Status:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?php $model->status == 1 && !empty ( $model->status ) ? 'Active' : 'Inactive' ?>
                                      <?= $model->status  ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Contact Person:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->contact_person ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Title:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->title ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Email:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->email ?>
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
                                    <label>Address:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->addr ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Payment Address 1:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->p_addr_1 ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Survey Date:</label>
                                </div>
                                <div class="col-sm-8">

                                    <?php
                                    if ( $model->survey_date ) {
                                        $exDelivery = explode(' ',$model->survey_date);
                                        $dd = $exDelivery[0];

                                        $time = explode('-', $dd);
                                        $monthNum = $time[1];
                                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                        $monthName = $dateObj->format('M'); // March
                                        $surveyDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                    ?>
                                    <?= $surveyDate ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Payment Address 2:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->p_addr_2 ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Currency:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->p_currency ? $dataCurrency[$model->p_currency] : '' ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Payment Address 3:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->p_addr_3 ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Scope of Approval:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->scope_of_approval ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Attachments</h3>
                    </div>
                    <div class="box-body ">
                        <?php  foreach ($oldSA as $oS) {
                            $supplierAttachmentClass = explode('\\', get_class($oS))[2];
                            ?>

                            <div class="col-sm-3">
                                <a href="<?= 'uploads/'.$supplierAttachmentClass.'/'. $oS->value ?>" target="_blank"><?= $oS->value ?></a>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </section>


</div>
