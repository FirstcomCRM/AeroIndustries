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

$this->title = 'Tools';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns =

[
    // ['class' => 'yii\grid\SerialColumn'],

            [
                'class' => 'yii\grid\CheckboxColumn', 
                'checkboxOptions' => [
                    'class' => 'tool-checkbox',
                ],
            ],

    [
        'attribute' => 'status',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            return $model->status == 1 ? 'Active' : 'Inactive' ;
        },
        
        'label' => 'Status',
    ],
    'in_used',
    'work_order_id',
    // [
    //     'attribute' => 'purchase_order_id',
    //     'value' => function($model, $index, $column) {
    //         $po = PurchaseOrder::find()->where(['id' => $model->purchase_order_id])->one();
    //         if ( $po ) {
    //             return "PO-" . sprintf("%008d", $po->purchase_order_no);
    //         } else {
    //             return '';
    //         }
    //     },
    //     'label' => 'PO No.',
    // ],
    [
        'format' => 'raw',
        'attribute' => 'receiver_no',
        'value' => function($model, $index, $column) {
            
            if ( $model->receiver_no ) {
                return Html::a(Html::encode("RE-" . sprintf("%008d", $model->receiver_no)),'?r=stock/receiver&id='.$model->receiver_no);;
            } else {
                return '';
            }
        },
        'label' => 'Receiver No.',
    ],
    // [
    //     'attribute' => 'supplier_id',
    //     'value' => 'supplier.company_name',
    //     'label' => 'Supplier',
    // ],
    [
        'attribute' => 'part_id',
        'value' => 'part.part_no',
        'label' => 'Part',
    ],
    [
        'attribute' => 'storage_location_id',
        'value' => 'storage.name',
        'label' => 'Storage Location',
    ],
    // 'batch_no',
    'note',
    'shelf_life',
    'hour_used',
    'expiration_date',
    'last_cali',
    'next_cali',
    [
        'attribute' => 'unit_price',
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
      'template' => '{preview}{amend}{receiver}{calibrate}',
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
        },
        'calibrate' => function ($url, $model) {
            return Html::a(' <span class="glyphicon glyphicon-wrench"></span> ', $url, [
                        'title' => Yii::t('app', 'Calibrate'),
            ]);
        }
      ],
      'urlCreator' => function ($action, $model, $key, $index) {
        if ($action === 'preview') {
            $url ='?r=tool/preview&id='.$model->id;
            return $url;
        }
        if ($action === 'amend') {
            $url ='?r=tool/edit&id='.$model->id;
            return $url;
        }
        if ($action === 'receiver') {
            $url ='?r=tool/receiver&id='.$model->receiver_no;
            return $url;
        }
        if ($action === 'calibrate') {
            $url ='?r=calibration/new&id='.$model->id;
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
    </section>

        <section class="content">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>
                        <?php /* 
                        <div class="col-sm-6 col-xs-12 text-left">
                        <br>
                            <a href="javascript:issueTool();" class="btn btn-primary"><i class="fa fa-print"></i> Issue Tools for Work</a>
                        </div>
                        */ ?>
                        <div class="col-sm-12 col-xs-12 text-right export-menu">  
                            <br>
                            <?php Html::a('<i class="fa fa-plus"></i> New Tool', ['new'], ['class' => 'btn btn-default']) ?>
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
