<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchTraveller */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Worksheets';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'traveler_no',
    'job_type',
    'desc',
    // 'content',
    'effectivity',
    'revision_no',
    'revision_date',
    // 'created',
    // 'created_by',
    // 'updated',
    // 'updated_by',
    // 'status',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{preview}{edit}{delete}',
        'buttons' => [
            'preview' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                            'title' => Yii::t('app', 'Preview'),
                ]);
            },
            'edit' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, [
                            'title' => Yii::t('app', 'Edit'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this traveler?',
                            ],
                ]);
            },
        ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'preview') {
                $url ='?r=traveler/preview&id='.$model->id;
                return $url;
            }   
            if ($action === 'edit') {
                $url ='?r=traveler/edit&id='.$model->id;
                return $url;
            }   
            if ($action === 'delete') {
                $url ='?r=traveler/remove&id='.$model->id;
                return $url;
            }
        }
    ],
];


?>
<div class="traveler-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>


        <section class="content">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right export-menu">
                        <br>
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Worksheet', ['new'], ['class' => 'btn btn-primary']) ?>
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
                                ]); 
                            ?>
                        </div>
                <!-- /.box-body -->
                     </div>
                     <div class="col-sm-12 text-right">
                        <?= Html::a('<i class=\'fa fa-list\'></i> Discontinued Worksheet', ['old'], ['class' => 'btn btn-default']) ?>
                     </div>
                </div>
            </div>

        </section>
</div>
