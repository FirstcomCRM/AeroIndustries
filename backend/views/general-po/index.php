<?php

use yii\helpers\Html;
use yii\grid\GridView;

use kartik\export\ExportMenu;
use common\models\SearchGeneralPO;
use common\models\GeneralPO;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGeneralPO */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'General POs';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns = 

[
    ['class' => 'yii\grid\SerialColumn'],

    'approved',
    [
        'attribute' => 'purchase_order_no',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            return GeneralPO::getGPONo($model->purchase_order_no,$model->created) ;
        },
        
        'label' => 'PO Number',
    ],
    [
        'attribute' => 'supplier_id',
        'value' => 'supplier.company_name',
        'label' => 'Supplier',
    ], 
    [
        'attribute' => 'supplier_ref_no',
        'value' => 'supplier_ref_no',
        'label' => 'Reference No.',
    ],
    [
        'attribute' => 'issue_date',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            if ( !empty($model->issue_date) ) {
                $exDate = explode(' ',$model->issue_date);
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
   
    // 'subtotal',
    // 'gst_rate',
    [
        'attribute' => 'grand_total',
        'label' => 'Total',
        'footer'=>SearchGeneralPO::pageTotal($dataProvider->models,'grand_total'),
    ],
    // 'clone',
    // 'created',
    // 'updated',

    // ['class' => 'yii\grid\ActionColumn'],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{approve}{cancel}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                            'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'approve' => function ($url, $model) {
                if ( $model->approved != 'approved' ) {
                    return Html::a(' <span class="glyphicon glyphicon-ok"></span> ', $url, [
                                'title' => Yii::t('app', 'Approve'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to approve this purchase order?',
                                ],
                    ]);
                }
            },
            'cancel' => function ($url, $model) {
                if ( $model->approved != 'cancelled' ) {
                    return Html::a(' <span class="glyphicon glyphicon-ban-circle"></span> ', $url, [
                                'title' => Yii::t('app', 'Cancel'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to cancel this purchase order?',
                                ],
                    ]);
                }   
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this purchase order?',
                            ],
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=general-po/preview&id='.$model->id;
                return $url;
            }
            if ($action === 'approve' && $model->approved != 'approved') {
                $url ='?r=general-po/approve&id='.$model->id;
                return $url;
            }
            if ($action === 'cancel') {
                $url ='?r=general-po/cancel&id='.$model->id;
                return $url;
            }
            if ($action === 'delete') {
                $url ='?r=general-po/delete-column&id='.$model->id;
                return $url;
            }
        }
    ],
];

?>
<div class="general-po-index">

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
                    <?= Html::a('<i class="fa fa-plus"></i> New General PO', ['new'], ['class' => 'btn btn-default']) ?>
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

                    <div class="box-body">
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
