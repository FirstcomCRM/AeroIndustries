<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCalibration */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calibrations';
$this->params['breadcrumbs'][] = $this->title;
use common\models\Part;
use common\models\Tool;
use common\models\StorageLocation;


$gridColumns =

[
    ['class' => 'yii\grid\SerialColumn'],

    // [
    //     'attribute' => 'tool_id',
    //     'format' => 'text',
    //     'value' => function($model, $index, $column) {
    //         $toolId = $model->tool_id;
    //         $tool = Tool::getTool($toolId);
    //         $partId = $tool->part_id;
    //         $dataPart = Part::dataPart();
    //         return $dataPart[$partId];
    //     },
    // ],
    'description',
    'manufacturer',
    'model',
    'serial_no',
    'storage_location',

    [
        'attribute' => 'storage_location',
        'value' => function($model, $index, $column) {
            $storage_location_id = $model->storage_location;
            $storage_location = StorageLocation::getStorageLocation($storage_location_id);
            return $storage_location->name;
        },
    ],
    'acceptance_criteria',
    [
        'attribute' => 'date',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            if ( !empty($model->date) ) {
                $exDate = explode(' ',$model->date);
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
    [
        'attribute' => 'due_date',
        'format' => 'text',
        'value' => function($model, $index, $column) {
            if ( !empty($model->due_date) ) {
                $exDate = explode(' ',$model->due_date);
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

    'con_approval',
    // 'con_limitation',
    // 'created',
    // 'updated',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{remove}',
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
                $url ='?r=calibration/preview&id='.$model->id;
                return $url;
            }
            if ($action === 'amend') {
                $url ='?r=calibration/edit&id='.$model->id;
                return $url;
            }
            if ($action === 'remove') {
                $url ='?r=calibration/remove&id='.$model->id;
                return $url;
            }
        }
    ],
];

?>
<div class="calibration-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Calibration', ['new'], ['class' => 'btn btn-default']) ?>
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
