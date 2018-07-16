<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWorkOrderArc */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\models\WorkOrder;
use common\models\Setting;
$this->title = 'Work Order Arcs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-order-arc-index">

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
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'work_order_id',
            'format' => 'raw',
            'value' => function($model, $index, $column) {
                $work_order_id = $model->work_order_id;
                $workOrder = WorkOrder::getWorkOrder($work_order_id);
                if ( $workOrder->work_scope && $workOrder->work_type ) {
                    $woNumber = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
                }
                return Html::a(Html::encode($woNumber),'?r=work-order/preview&id='.$work_order_id, ['target'=>'_blank']);
            },
        ],
            
    [
        'attribute' => 'date',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            if ( !empty($model->date) ) {
                $exDate = explode(' ',$model->date);
                $is = $exDate[0];
                $time = explode('-', $is);
                $monthNum = $time[1];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('M'); // March
                $newDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                return $newDate;
            }
        },
    ],
            'type',
            // 'first_check',
            // 'second_check',
            // 'form_tracking_no',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{preview}',
                'buttons' => [
                    'preview' => function ($url, $model) {
                        return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                                    'title' => Yii::t('app', 'Preview'),
                                    'target' => '_blank'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this work order?',
                                    ],
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'preview') {
                        $work_order_id = $model->work_order_id;
                        $work_order_part_id = $model->work_order_part_id;
                        if ( $model->type == 'EASA' ) {
                            $url ='?r=work-order-arc/print-easa&id='.$work_order_id.'&work_order_part_id='.$work_order_part_id;
                        }
                        if ( $model->type == 'FAA' ) {
                            $url ='?r=work-order-arc/print-faa&id='.$work_order_id.'&work_order_part_id='.$work_order_part_id;
                        }
                        if ( $model->type == 'CAAS' ) {
                            $url ='?r=work-order-arc/print-caa&id='.$work_order_id.'&work_order_part_id='.$work_order_part_id;
                        }
                        if ( $model->type == 'COC' ) {
                            $url ='?r=work-order-arc/print-coc&id='.$work_order_id.'&work_order_part_id='.$work_order_part_id;
                        }
                        if ( $model->type == 'CAAV' ) {
                            $url ='?r=work-order-arc/print-caav&id='.$work_order_id.'&work_order_part_id='.$work_order_part_id;
                        }
                        if ( $model->type == 'DCAM' ) {
                            $url ='?r=work-order-arc/print-dcam&id='.$work_order_id.'&work_order_part_id='.$work_order_part_id;
                        }
                        return $url;
                    }  
                    if ($action === 'delete') {
                        $url ='?r=work-order/delete-column&id='.$model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
