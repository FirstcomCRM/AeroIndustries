<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\GeneralPo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'General Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="general-po-view">


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

                    <div class="box-body">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
            'purchase_order_no',
            'supplier_id',
            'attention',
            'supplier_ref_no',
            'payment_addr',
            'issue_date',
            'delivery_date',
            'p_term',
            'p_currency',
            'ship_via',
            'ship_to',
            'subtotal',
            'gst_rate',
            'grand_total',
            'usd_total',
            'conversion',
            'remark',
            'clone',
            'status',
            'created',
            'created_by',
            'updated',
            'updated_by',
            'approved',
            'deleted',
                                ],
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
