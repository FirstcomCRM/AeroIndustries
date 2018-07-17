<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchQuarantine */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quarantines';
$this->params['breadcrumbs'][] = $this->title;

use kartik\export\ExportMenu;
use common\models\WorkOrder;
use common\models\Uphostery;
use common\models\Setting;


$gridColumns =

[
    ['class' => 'yii\grid\SerialColumn'],

        'part_no',
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

            },

        ],
        'serial_no',
        'batch_no',
        // 'lot_no',
        // 'desc',
        // 'quantity',
        // 'reason',
        // 'date',
        // 'status',
        // 'created',
        // 'updated',


    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{amend}{remove}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                            'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'amend' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, [
                            'title' => Yii::t('app', 'Amend'),
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
                $url ='?r=quarantine/preview&id='.$model->id;
                return $url;
            }
            if ($action === 'amend') {
                $url ='?r=quarantine/edit&id='.$model->id;
                return $url;
            }
            if ($action === 'remove') {
                $url ='?r=quarantine/remove&id='.$model->id;
                return $url;
            }
        }
    ],
];



?>
<div class="quarantine-index">

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
                        <?php Html::a('<i class=\'fa fa-plus\'></i> New Quarantine', ['new'], ['class' => 'btn btn-default']) ?>
                        <?php

                                // /*Renders a export dropdown menu*/
                                echo ExportMenu::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => $gridColumns,
                                    'columnSelectorOptions'=>[
                                        'label' => 'Filter Export',
                                        'class' => 'export-column'
                                    ],
                                    'exportConfig' => [
                                        ExportMenu::FORMAT_CSV => true,
                                        ExportMenu::FORMAT_TEXT => false,
                                        ExportMenu::FORMAT_HTML => false,
                                        ExportMenu::FORMAT_EXCEL => true,
                                    ],
                                    'fontAwesome' => true,
                                    'dropdownOptions' => [
                                        'label' => 'Export All',
                                        'class' => 'btn btn-success export-export-all',
                                        'options' => [
                                            'class' => 'export-export-all'
                                        ]
                                    ]
                                ]);
                            ?>
                            <br>
                            <br>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <?=
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => $gridColumns,
                                    // 'showFooter'=>true,
                                ]);
                            ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
