<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use kartik\export\ExportMenu;

use common\models\TemplateAlt;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchTemplate */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Templates';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = 
[
    ['class' => 'yii\grid\SerialColumn'],

    'id',
    'part_no',
    [
        'format' => 'raw',
        'attribute' => 'alternative',
        'value' => function($model, $index, $column) {
            return nl2br($model->alternative);
        }
        
    ], 
    // [
    //     'format' => 'html',
    //     'contentOptions' => ['style' => ['max-width' => '110px;', 'width' => '110px;', 'word-wrap' => 'break-word']],
    //     'value' => function($model, $index, $column) {
    //         $id = $model->id;
    //         $alt = TemplateAlt::find()->where(['template_id' => $id ])->all();
    //         $data = '';
    //         if ( $alt ) {
    //             foreach ( $alt as $a ) {
    //                 $data .= $a->part_no . "<br>";
    //             } 
    //         }
    //         return $data;

    //     },

        
    //     'label' => 'Alternate P/N',
    // ], 
    'desc',
    'remark',
    'insert',
    // 'location_id',
    // 'created',
    // 'created_by',
    // 'updated',
    // 'udpated_by',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{amend}{remove}',
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
                $url ='?r=template/preview&id='.$model->id;
                return $url;
            }
            if ($action === 'amend') {
                $url ='?r=template/edit&id='.$model->id;
                return $url;
            }
            if ($action === 'remove') {
                $url ='?r=template/remove&id='.$model->id;
                return $url;
            }
        }
    ],
]
?>
<div class="template-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Template', ['new'], ['class' => 'btn btn-default']) ?>
                        
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
                                        ExportMenu::FORMAT_CSV => false,
                                        ExportMenu::FORMAT_TEXT => false,
                                        ExportMenu::FORMAT_HTML => false,
                                        ExportMenu::FORMAT_EXCEL => false,
                                        ExportMenu::FORMAT_EXCEL_X => [
                                            'label' => 'Excel',
                                        ],
                                    ],
                                    'autoWidth' => true,
                                    'filename' => "Template" . date('YmdHis'),
                                    'styleOptions' => [
                                        'font' => [
                                            'bold' => true,
                                        ],
                                    ],
                                    'fontAwesome' => true,
                                    'dropdownOptions' => [
                                        'label' => 'Export All',
                                        'class' => 'btn btn-success export-export-all',
                                        'options' => [
                                            'class' => 'export-export-all'
                                        ]
                                    ],
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
