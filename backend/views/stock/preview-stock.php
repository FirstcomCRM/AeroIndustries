<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\Stock */
use common\models\Supplier;
use common\models\StorageLocation;
use common\models\Part;
use common\models\PartCategory;
use common\models\PurchaseOrder;
use common\models\Unit;
use common\models\SearchStock;


$dataPO = ArrayHelper::map(PurchaseOrder::find()->all(), 'id', 'purchase_order_no');
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
    'status',
    [
        'format' => 'raw',
        'attribute' => 'purchase_order_id',
        'value' => function($model, $index, $column) {
            $po = PurchaseOrder::find()->where(['id' => $model->purchase_order_id])->one();
            if ( $po ) {
                return Html::a(Html::encode(PurchaseOrder::getPONo($po->purchase_order_no,$po->created)),'?r=purchase-order/preview&id='.$model->purchase_order_id);
            } else {
                return '';
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
        'label' => 'Storage at',
    ],

    'expiration_date',
    'shelf_life',
    [
        'attribute' => 'quantity',
        'label' => 'Qty',
        'footer'=>SearchStock::pageTotal($dataProvider->models,'quantity'),
    ],

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{quarantine}{preview}{amend}{receiver}',
        'buttons' => [
            'quarantine' => function ($url, $model) {
                    return Html::a(' <span class="glyphicon glyphicon-new-window"></span> ', $url, [
                        'title' => Yii::t('app', 'Move to Quarantine'),
                ]);
            },
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
                return 
                $model->purchase_order_id!=0?Html::a(' <span class="glyphicon glyphicon-print"></span> ', $url, [
                        'title' => Yii::t('app', 'Receiver'),
                ]):'';
            }
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'quarantine') {
                $url ='?r=supplier-quarantine/new&s_id='.$model->id.'&qty='.$model->quantity;
                return $url;
            }
            if ($action === 'preview') {
                $url ='?r=stock/preview&id='.$model->id . '&s=1';
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
<div class="stock-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h2>
    </section>
    <div class="col-sm-12 text-right">
          <?php echo Html::a('View Part Images','#',
            [
              'class'=>'btn btn-warning modalButton',
              'title'=>'View Image',
              'value' => Url::to(['stock/part-image', 'id' => $model->part_id]),
            ]
          );?>
            <?= Html::a( 'Back', Url::to(['stock']), array('class' => 'btn btn-default')) ?>
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
                            <div class="col-sm-6 col-xs-12">
                                <div class="col-sm-4">
                                    <label>Manufacturer:</label>
                                </div>
                                <div class="col-sm-8 capitalize">
                                    <?= $model->part->manufacturer ? $model->part->manufacturer : '' ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">All stocks <?= $model->part_id ? 'of '. $dataPart[$model->part_id] : '' ?></h3>
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


<?php
  Modal::begin([
    'header'=>$dataPart[$model->part_id],
    'id'=>'modals',
    'size'=>'modal-lg',
  //'size'=>'modal-sm',
    //'clientOptions' => ['backdrop' => false],
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
  //  'closeButton'=>'tag',
  ]);

 ?>

<div class="" id="modalContent">

</div>

<?php Modal::end() ?>
