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

$this->title = 'Stocks';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns =

[
    ['class' => 'yii\grid\SerialColumn'],

    'part_no',
    [
        'attribute' => 'sumsQ',
        'label' => 'Qty in stock',
    ],
    [
        'attribute' => 'unit_id',
        'label' => 'UM',
    ],
    [
        'attribute' => 'sumsSQ',
        'label' => 'Qty per unit item',
    ],
    [
        'attribute' => 'sub_unit_id',
        'label' => 'UM',
    ],
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{preview}',
      'buttons' => [
        'preview' => function ($url, $model) {
            return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                        'title' => Yii::t('app', 'Preview'),
            ]);
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
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right export-menu">  
                        <br>
                        <?= Html::a('<i class="fa fa-plus"></i> Stock Receive', ['new'], ['class' => 'btn btn-default']) ?>
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
