<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use kartik\export\ExportMenu;
use common\models\PurchaseOrder;
use common\models\SearchStock;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchStock */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receiver';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns =

[
    ['class' => 'yii\grid\SerialColumn'],

    [
        'format' => 'raw',
        'attribute' => 'receiver_no',
        'value' => function($model, $index, $column) {
            
            if ( $model->receiver_no ) {
                return Html::a(Html::encode("RE-" . sprintf("%008d", $model->receiver_no)),'?r=stock/receiver&id='.$model->receiver_no);
            } else {
                return '';
            }
        },
        'label' => 'Receiver No.',
    ],
    [
        'attribute' => 'part_id',
        'value' => 'part.part_no',
        'label' => 'Part',
    ],
    'purchase_order_id',
    // [
    //     'format' => 'raw',
    //     'attribute' => 'purchase_order_id',
    //     'value' => function($model, $index, $column) {
    //         $po = PurchaseOrder::find()->where(['id' => $model->purchase_order_id])->one();
    //         if ( $po ) {
    //             return Html::a(Html::encode("PO-" . sprintf("%008d", $po->purchase_order_no)),'?r=purchase-order/preview&id='.$model->purchase_order_id);
    //         } else {
    //             return '';
    //         }
    //     },
    //     'label' => 'PO No.',
    // ],
    [
        'attribute' => 'received',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            if ( !empty($model->received) ) {
                $exDate = explode(' ',$model->received);
                $is = $exDate[0];
                $time = explode('-', $is);
                $monthNum = $time[1];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('M'); // March
                $newDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                return $newDate;
            }
        },
        'label' => 'Date Received',
    ],
    [
        'attribute' => 'supplier_id',
        'value' => 'supplier.company_name',
        'label' => 'Supplier',
    ],
    [
        'attribute' => 'storage_location_id',
        'value' => 'storage.name',
        'label' => 'Storage Location',
    ],
    // 'batch_no',
    // 'shelf_life',
    // 'hour_used',
    [
        'attribute' => 'expiration_date',
        'footer'=> '<strong>Total Qty</strong>',
    ],
    [
        'attribute' => 'quantity',
        'label' => 'Qty',
        'footer'=>SearchStock::pageTotal($dataProvider->models,'quantity'),
    ],
    [
        'attribute' => 'unit_id',
        'value' => 'unit.unit',
        'label' => 'UM',
        'contentOptions' => ['class' => 'capitalize'],
        'headerOptions' => ['class' => 'capitalize']
    ],
    // [
    //     'attribute' => 'sub_quantity',
    //     'label' => 'Qty Per Unit',
    //     'footer' => SearchStock::pageTotal($dataProvider->models,'sub_quantity'),
    // ],
    // [
    //     'attribute' => 'total_quantity',
    //     'label' => 'Total Qty',
    //     'value' => function($model, $index, $column) {
    //         return SearchStock::subTimesQty($model->quantity, $model->sub_quantity);
    //     },
    //     'footer' => SearchStock::subTimesQtyTotal($dataProvider->models,'quantity','sub_quantity'),
    // ],
    // 'created',
    // [
    //     'attribute' => 'created_by',
    //     'value' => 'createdBy.username',
    //     'label' => 'Created by',
    // ],
    // 'updated',
    // [
    //     'attribute' => 'updated_by',
    //     'value' => 'updatedBy.username',
    //     'label' => 'Updated by',
    // ],

    // ['class' => 'yii\grid\ActionColumn'],
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{preview}{amend}{receiver}',
      'buttons' => [
        'preview' => function ($url, $model) {
            return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                        'title' => Yii::t('app', 'Preview'),
            ]);
        },
        'amend' => function ($url, $model) {
            return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, [
                        'title' => Yii::t('app', 'Edit'),
            ]);
        },
        'receiver' => function ($url, $model) {
            return Html::a(' <span class="glyphicon glyphicon-print"></span> ', $url, [
                        'title' => Yii::t('app', 'Receiver'),
            ]);
        }
      ],
      'urlCreator' => function ($action, $model, $key, $index) {
        if ($action === 'preview') {
            $url ='?r=stock/preview&id='.$model->id;
            return $url;
        }
        if ($action === 'amend') {
            $url ='?r=stock/edit&id='.$model->id;
            return $url;
        }
        if ($action === 'receiver') {
            $url ='?r=stock/receiver&id='.$model->receiver_no;
            return $url;
        }
      }
    ],
];

?>
<div class="stock-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
        <?= Html::a('<i class="fa fa-arrow-left"></i> Back', ['stock'], ['class' => 'btn btn-default']) ?>
    </section>

        <section class="content">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                        </div>

                        <div class="col-sm-12 text-right export-menu">  
                        <br>
                        <?php Html::a('<i class="fa fa-plus"></i> Stock Receive', ['new'], ['class' => 'btn btn-default']) ?>
                        <?php Html::a('<i class="fa fa-list"></i> Stock', ['stock'], ['class' => 'btn btn-default']) ?>
                        <?php

                            /*Renders a export dropdown menu*/
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
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body table-responsive">
                            <?= 
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => $gridColumns,
                                    'showFooter'=>true,
                                ]); 
                            ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
