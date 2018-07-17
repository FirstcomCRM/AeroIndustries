<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use kartik\export\ExportMenu;
use common\models\PurchaseOrder;
use common\models\SearchStock;
use common\models\Stock;

$gridColumns =
[
    ['class' => 'yii\grid\SerialColumn'],

    'part_no',
    // 'manufacturer',
    [
        'attribute' => 'sumsQ',
        'label' => 'Quantity in stock',
    ],
    [
        'attribute' => 'unit_id',
        'label' => 'UM',
    ],
    [
        'attribute' => 'restock',
        'label' => 'Re-stock Level',
    ],
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{preview}{restock}',
      'buttons' => [
        'preview' => function ($url, $model) {
            return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                        'title' => Yii::t('app', 'Preview'),
            ]);
        },
        'restock' => function ($url, $model) {
            if ( $model['restock'] >= $model['sumsQ'] ) {
                return Html::a(' <span class="glyphicon glyphicon-warning-sign" style="color: red"></span> ', $url, [
                            'title' => Yii::t('app', 'Low Stock'),
                ]);
            }
        },
      ],
      'urlCreator' => function ($action, $stockQuery, $key, $index) {
        if ($action === 'preview') {
            $url ='?r=stock/preview-stock&id='.$stockQuery['id'];
            return $url;
        }
      }
    ],
];
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?=$totalQuotation?></h3>

          <p>Quotation</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="?r=quotation" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?=$totalWorkOrder?></h3>

          <p>Work Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="?r=work-order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?=$totalWorkOrderInProgress?></h3>

          <p>Work Order in progress</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="?r=work-order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$totalWorkOrderCompleted?></h3>

          <p>Work Order Completed</p>
        </div>
        <div class="icon">
          <i class="ion ion-checkmark-round"></i>
        </div>
        <a href="?r=work-order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>


    <!-- ./col --><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?=$totalUphostery?></h3>

          <p>Upholstery</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="?r=work-order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?=$totalUphosteryInProgress?></h3>

          <p>Upholstery in progress</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="?r=work-order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$totalUphosteryCompleted?></h3>

          <p>Upholstery Completed</p>
        </div>
        <div class="icon">
          <i class="ion ion-checkmark-round"></i>
        </div>
        <a href="?r=work-order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  <!-- /.row -->


<div class="stock-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                          <h3 class="box-title">Low Stock Parts</h3>
                        </div>

                        <div class="col-sm-12 text-right export-menu">
                        <br>
                        <?php
                            /*Renders a export dropdown menu*/
                            ExportMenu::widget([
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
</section>
<!-- /.content -->
