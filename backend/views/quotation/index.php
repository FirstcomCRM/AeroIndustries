<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\models\SearchQuotation;

use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchQuotation */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quotations';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns =
[
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'quotation_no',
        'format' => 'text',
        'value' => function($model, $index, $column) {
          if ($model->quotation_type == 'work_order') {
            $x = '-w';
          }elseif($model->quotation_type == 'uphostery'){
            $x = '-u';
          }else{
            $x = '';
          }
            //var_dump($model);die();
            return $model->quotation_no ? "QUO-" . sprintf("%008d", $model->quotation_no).$x : '' ;
        },

        'label' => 'Quotation No.',
    ],
    [
        'attribute' => 'customer_id',
        'value' => 'customer.name',
        'label' => 'Customer',
    ],
     [
        'attribute' => 'date',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            $exDate = explode(' ',$model->date);
            $is = $exDate[0];
            $time = explode('-', $is);
            $monthNum = $time[1];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('M'); // March
            $newDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
            return $newDate;
        },
    ],
    // 'attention',
    // 'p_term',
    [
        'attribute' => 'p_currency',
        'value' => 'currency.iso',
        'label' => 'Payment Currency',
        'footer'=> '<strong>Grand Total</strong>',
    ],
    // 'd_term',
    [
        'attribute' => 'grand_total',
        'label' => 'Total',
        'footer'=>SearchQuotation::pageTotal($dataProvider->models,'grand_total'),
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{delete}',
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
                                    'confirm' => 'Are you sure you want to approve this quotation?',
                                ],
                    ]);
                }
            },
            'cancel' => function ($url, $model) {
                if ( $model->approved != 'cancelled' ) {
                    return Html::a(' <span class="glyphicon glyphicon-ban-circle"></span> ', $url, [
                                'title' => Yii::t('app', 'Cancel'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to cancel this quotation?',
                                ],
                    ]);
                }
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this quotation?',
                            ],
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=quotation/preview&id='.$model->id;
                return $url;
            }
            if ($action === 'approve' && $model->approved != 'approved') {
                $url ='?r=quotation/approve&id='.$model->id;
                return $url;
            }
            if ($action === 'cancel') {
                $url ='?r=quotation/cancel&id='.$model->id;
                return $url;
            }
            if ($action === 'delete') {
                $url ='?r=quotation/delete-column&id='.$model->id;
                return $url;
            }
        }
    ],

];

?>
<div class="quotation-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Quotation', ['new'], ['class' => 'btn btn-default']) ?>
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
