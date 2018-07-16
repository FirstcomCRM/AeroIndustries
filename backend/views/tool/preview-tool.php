<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
use common\models\Supplier;
use common\models\StorageLocation;
use common\models\Part;
use common\models\PartCategory;
use common\models\ToolPo;
use common\models\Unit;
use common\models\SearchStock;


$dataPO = ArrayHelper::map(ToolPo::find()->all(), 'id', 'purchase_order_no');
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'company_name');
$dataStorage = ArrayHelper::map(StorageLocation::find()->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataPartCat = ArrayHelper::map(PartCategory::find()->all(), 'id', 'name');
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$this->title = $dataPart[$model->part_id];

$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


use kartik\file\FileInput;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'class' => 'yii\grid\CheckboxColumn', 
        'checkboxOptions' => [
            'class' => 'tool-checkbox',
        ],
    ],
    'status',
    [
        'format' => 'raw',
        'attribute' => 'tool_po_id',
        'value' => function($model, $index, $column) {
            if ($model->tool_po_id!=0) {
                return Html::a(Html::encode( ToolPo::getTPONoById($model->tool_po_id) ),'?r=tool-po/preview&id='.$model->tool_po_id);
            } else {
                return 'N/A';      
            }
        },
        'label' => 'PO No.',
    ],
    [
        'format' => 'raw',
        'attribute' => 'receiver_no',
        'value' => function($model, $index, $column) {
            
            if ( $model->receiver_no ) {
                return Html::a(Html::encode("RE-" . sprintf("%006d", $model->receiver_no)),'?r=stock/receiver&id='.$model->receiver_no);
            } else {
                return '';
            }
        },
        'label' => 'Receiver No.',
    ],
    [
        'attribute' => 'received',
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
        'label' => 'Storage at',
    ],
   
    'expiration_date',
    [
        'attribute' => 'quantity',
        'label' => 'Qty',
        'footer'=>SearchStock::pageTotal($dataProvider->models,'quantity'),
    ],

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
                $url ='?r=tool/preview&id='.$model->id . '&s=1';
                return $url;
            }
            if ($action === 'amend') {
                $url ='?r=tool/edit&id='.$model->id;
                return $url;
            }
            if ($action === 'receiver') {
                $url ='?r=stock/receiver&id='.$model->receiver_no;
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
<div class="stock-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h2>
    </section>
    <div class="col-sm-12 text-right">
            <a href="javascript:;" class="back-button btn btn-default">Back</a>
        <br>
        <br>
        <!-- /.box-header -->
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Details</h3>
                    </div>

                    <div class="box-body preview-po">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Part Category:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->part->category_id ? $dataPartCat[$model->part->category_id] : '' ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Part No.:</label>
                                </div>
                                <div class="col-sm-8">
                                    <?= $model->part_id ? $dataPart[$model->part_id] : '' ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Unit Measurement:</label>
                                </div>
                                <div class="col-sm-8 capitalize">
                                    <?= $model->unit->unit ? $model->unit->unit : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">All stocks <?= $model->part_id ? 'of '. $dataPart[$model->part_id] : '' ?></h3>
                        <div class="pull-right"><button class="btn btn-primary calibrate-button">Calibrate</button></div>
                    </div>
                    <div class="box-body table-responsive">
                        <?= 
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $gridColumns,
                                'showFooter'=>true,
                            ]); 
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
