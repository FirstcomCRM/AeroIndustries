<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use common\models\Quarantine;
use common\models\Scrap;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWorkOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Upholstery';
$this->params['breadcrumbs'][] = $this->title;

use common\models\Setting;
$dataWorkStatus = Setting::dataWorkStatus();

$gridColumns =
[
    [
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => [
            'class' => 'uphostery-checkbox',
        ],
    ],
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'uphostery_no',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            $woNumber = 'Uphostery No Missing';
            if ( $model->uphostery_scope && $model->uphostery_type ) {
                $woNumber = Setting::getWorkNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
            }
            return $woNumber;
        },
    ],
    [
        'attribute' => 'customer_id',
        'value' => 'customer.name',
    ],
    // 'part_no',
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
    'status',
    // 'arc_status',
    // 'received_date',
    // 'qc_notes',
    // 'disposition_note',
    // 'arc_remark',
    // 'created',
    // [
    //     'attribute' => 'created_by',
    //     'value' => 'user.username',
    // ],
    // 'updated',
    // 'updated_by',
    // 'deleted',


    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{cancel}',
        'buttons' => [
            'quarantine' => function ($url, $model) {

                $quarantine = Quarantine::checkQuarantine($model->id);
                if ( $quarantine ) {
                    return Html::a(' <span class="glyphicon glyphicon-warning-sign" style="color: red"></span> ', $url, [
                                'title' => Yii::t('app', 'In Quarantine'),
                    ]);
                }else {
                    return Html::a(' <span class="glyphicon glyphicon-new-window" style="color: red"></span> ', $url, [
                                'title' => Yii::t('app', 'Move to quarantine'),
                    ]);
                }
            },
            'scrap' => function ($url, $model) {

                $scrap = Scrap::checkScrap($model->id);
                if ( $scrap ) {
                    return Html::a(' <span class="glyphicon glyphicon-remove-sign" style="color: blue"></span> ', $url, [
                                'title' => Yii::t('app', 'Scrapped'),
                    ]);
                } else {
                    return Html::a(' <span class="glyphicon glyphicon-new-window" style="color: blue"></span> ', $url, [
                                'title' => Yii::t('app', 'Scrap Part'),
                    ]);
                }
            },
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                            'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'approve' => function ($url, $model) {
                if ( $model->status != 'approved' ) {
                    return Html::a(' <span class="glyphicon glyphicon-ok"></span> ', $url, [
                                'title' => Yii::t('app', 'Approve'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to approve this uphostery?',
                                ],
                    ]);
                }
            },
            'cancel' => function ($url, $model) {
                if ( $model->status != 'cancelled' ) {
                    return Html::a(' <span class="glyphicon glyphicon-ban-circle"></span> ', $url, [
                                'title' => Yii::t('app', 'Cancel'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to cancel this uphostery?',
                                ],
                    ]);
                }
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this uphostery?',
                            ],
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=uphostery/preview&id='.$model->id;
                return $url;
            }
            if ($action === 'approve' && $model->status != 'approved') {
                $url ='?r=uphostery/approve&id='.$model->id;
                return $url;
            }
            if ($action === 'cancel') {
                $url ='?r=uphostery/cancel&id='.$model->id;
                return $url;
            }
            if ($action === 'delete') {
                $url ='?r=uphostery/delete-column&id='.$model->id;
                return $url;
            }
            if ($action === 'scrap') {
                $scrap = Scrap::checkScrap($model->id);
                $url = '?r=scrap/new&uphostery_id='.$model->id;
                if ( $scrap ) {
                    $url ='?r=scrap/index&SearchScrap[id]='.$scrap->id;
                }
                return $url;
            }
            if ($action === 'quarantine') {
                $quarantine = Quarantine::checkQuarantine($model->id);
                $url = '?r=quarantine/new&uphostery_id='.$model->id;
                if ( $quarantine ) {
                    $url ='?r=quarantine/preview&id='.$quarantine->id;
                }
                return $url;
            }
        }
    ],
]
;




$exportColumns =
// $gridColumns =
[
    [
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => [
            'class' => 'uphostery-checkbox',
        ],
    ],
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'uphostery_no',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            $woNumber = 'Uphostery No Missing';
            if ( $model->uphostery_scope && $model->uphostery_type ) {
                $woNumber = Setting::getWorkNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
            }
            return $woNumber;
        },
    ],
    [
        'attribute' => 'customer_id',
        'value' => 'customer.name',
    ],
    'uphostery_scope',
    'uphostery_type',
    'customer_po_no',
    'part_no',
    'date',
    'status',
    'arc_status',
    'received_date',
    'on_dock_date',
    'needs_by_date',
    'approval_date',
    'model',
    'serial_no',
    'batch_no',
    'new_part_no',
    'desc',
    'remark',
    // 'qc_notes',
    'arc_remark',
    'final_inspection_date',
    'disposition_date',
    'preliminary_date',
    'created',
    'updated',
    // [
    //     'attribute' => 'created_by',
    //     'value' => 'user.username',
    // ],
    // 'updated',
    // 'updated_by',
    // 'deleted',


    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{cancel}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                            'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'approve' => function ($url, $model) {
                if ( $model->status != 'approved' ) {
                    return Html::a(' <span class="glyphicon glyphicon-ok"></span> ', $url, [
                                'title' => Yii::t('app', 'Approve'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to approve this uphostery?',
                                ],
                    ]);
                }
            },
            'cancel' => function ($url, $model) {
                if ( $model->status != 'cancelled' ) {
                    return Html::a(' <span class="glyphicon glyphicon-ban-circle"></span> ', $url, [
                                'title' => Yii::t('app', 'Cancel'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to cancel this uphostery?',
                                ],
                    ]);
                }
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this uphostery?',
                            ],
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=uphostery/preview&id='.$model->id;
                return $url;
            }
            if ($action === 'approve' && $model->status != 'approved') {
                $url ='?r=uphostery/approve&id='.$model->id;
                return $url;
            }
            if ($action === 'cancel') {
                $url ='?r=uphostery/cancel&id='.$model->id;
                return $url;
            }
            if ($action === 'delete') {
                $url ='?r=uphostery/delete-column&id='.$model->id;
                return $url;
            }
        }
    ],
]
;


?>
<div class="uphostery-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Upholstery', ['new'], ['class' => 'btn btn-default']) ?>
                        <?= Html::dropDownList('update-status-selection', null, $dataWorkStatus,['id' => 'update-status-selection', 'class' => 'select2'] ) ?>
                        <a class="btn btn-primary" href="javascript:update_up_status()"><i class="fa fa-save"></i> Update Status</a>
                        <?php

                            /*Renders a export dropdown menu*/
                            echo ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $exportColumns,
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
                                    'columns' => $gridColumns
                                ]);
                            ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
