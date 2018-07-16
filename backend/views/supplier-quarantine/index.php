<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchSupplierQuarantine */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Part;

$this->title = 'Supplier Quarantines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-quarantine-index">

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
                        <?php Html::a('<i class=\'fa fa-plus\'></i> New Supplier Quarantine', ['new'], ['class' => 'btn btn-default']) ?>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'stock_id',
                'format' => 'text',
                'value' => function($model, $index, $column) {
                    $dataPart = Part::dataPart();
                    return $dataPart[$model->stock->part_id];
                },
                'label' => 'Stock',
            ],
            'quantity',
            'reason',
            'date',
            // 'status',
            // 'created',
            // 'created_by',
            // 'updated',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{amend}{remove}',
                'buttons' => [
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
                    if ($action === 'amend') {
                        $url ='?r=supplier-quarantine/edit&id='.$model->id;
                        return $url;
                    }
                    if ($action === 'remove') {
                        $url ='?r=supplier-quarantine/remove&id='.$model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
