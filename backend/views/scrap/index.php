<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchScrap */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scraps';
$this->params['breadcrumbs'][] = $this->title;


use kartik\export\ExportMenu;
use common\models\WorkOrder;
use common\models\Setting;
use common\models\Uphostery;


$gridColumns =
[
    ['class' => 'yii\grid\SerialColumn'],


    [
        'attribute' => 'work_order_id',
        'format' => 'text',
        'value' => function($model, $index, $column) {  
            if ($model->work_type == 'work_order') {
              $getWorkOrder = WorkOrder::find()->where(['id' => $model->work_order_id])->one();
              $woNumber = 'Work Order No Missing';
              if($getWorkOrder) {
                  if ( $getWorkOrder->work_scope && $getWorkOrder->work_type ) {
                      $woNumber = Setting::getWorkNo($getWorkOrder->work_type,$getWorkOrder->work_scope,$getWorkOrder->work_order_no);
                  }
                  return $woNumber;
              }
            }else{
              $data = Uphostery::find()->where(['id'=>$model->work_order_id])->one();
              $woNumber = Setting::getWorkNo($data->uphostery_type,$data->uphostery_scope,$data->uphostery_no);
              return $woNumber;
            }


            return $woNumber;
        },

    ],
    'part_no',
    'serial_no',
    'batch_no',
    // 'date',
    // 'remark',
    // 'created',
    // 'created_by',
    // 'updated',
    // 'updated_by',
    // 'deleted',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{remove}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-print"></span> ', $url, [
                            'title' => Yii::t('app', 'Print'),
                            'target' => '_blank',
                ]);
            },
            'remove' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                            'title' => Yii::t('app', 'Remove'),
                            'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                            // 'data-method' => 'post',
                ]);
            }
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=scrap/disposition-report&id='.$model->id;
                return $url;
            }
            if ($action === 'remove') {
                $url ='?r=scrap/remove&id='.$model->id;
                return $url;
            }
        }
    ],
]


;
?>
<div class="scrap-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>


        <section class="content">
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right export-menu">
                        <br>
                        <?php Html::a('<i class=\'fa fa-plus\'></i> New Scrap', ['new'], ['class' => 'btn btn-default']) ?>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $gridColumns
    ]); ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
