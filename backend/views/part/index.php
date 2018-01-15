<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Stock;

use kartik\export\ExportMenu;
use common\models\SearchPart;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchPart */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parts';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns =

[
    ['class' => 'yii\grid\SerialColumn'],
    'status',
    'manufacturer',
    [
        'attribute' => 'category_id',
        'value' => 'category.name',
        'label' => 'Category',
    ],
    'part_no',
    [
        'attribute' => 'unit_id',
        'value' => 'unit.unit',
        'label' => 'Unit',
        'contentOptions' => ['class' => 'capitalize'],
        'headerOptions' => ['class' => 'capitalize']
    ],
    'default_unit_price',
    'restock',
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
            $url ='?r=part/view&id='.$model->id;
            return $url;
        }
        if ($action === 'amend') {
            $url ='?r=part/update&id='.$model->id;
            return $url;
        }
        if ($action === 'remove') {
            $url ='?r=part/delete-column&id='.$model->id;
            return $url;
        }
      }
    ],

];



?>
<div class="part-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>

    <section class="content">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                    </div>

                    <div class="col-sm-12 text-right export-menu">                    <br>
                    <?= Html::a('<i class="fa fa-plus"></i> New Part', ['create'], ['class' => 'btn btn-default']) ?>
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
