<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Quarantine */

$this->title = $model->part_no;
$this->params['breadcrumbs'][] = ['label' => 'Quarantines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use common\models\Setting;
use common\models\WorkOrder;
use common\models\Uphostery;

if ($model->work_type == 'work_order') {

  $getWorkOrder = WorkOrder::find()->where(['id' => $model->work_order_id])->one();
  $woNumber = 'Work Order No Missing';
  if($getWorkOrder) {
      if ( $getWorkOrder->work_scope && $getWorkOrder->work_type ) {
          $woNumber = Setting::getWorkNo($getWorkOrder->work_type,$getWorkOrder->work_scope,$getWorkOrder->work_order_no);
      }
  }
}else{
  $data = Uphostery::find()->where(['id'=>$model->work_order_id])->one();
  $woNumber = Setting::getWorkNo($data->uphostery_type,$data->uphostery_scope,$data->uphostery_no);
}



?>
<div class="quarantine-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
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
                        <?= Html::a('<i class=\'fa fa-edit\'></i> Update', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class=\'fa fa-trash\'></i> Delete', ['remove', 'id' => $model->id], [
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
            'part_no',

                                    [
                                        'label' => 'Work Order',
                                        'value'=> $woNumber,
                                    ],
            'serial_no',
            'batch_no',
            'lot_no',
            'desc',
            'quantity',
            'reason',
            'date',
            'status',
            'created',
            'updated',
                                ],
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
