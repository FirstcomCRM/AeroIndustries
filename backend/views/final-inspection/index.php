<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchFinalInspection */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Final Inspections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="final-inspection-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Final Inspection', ['new'], ['class' => 'btn btn-default']) ?>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'build',
            'title',
            'created',
            // 'created_by',
            // 'updated',
            // 'updated_by',

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
                                        'confirm' => 'Are you sure you want to delete this final-inspection?',
                                    ],
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'preview') {
                        $url ='?r=final-inspection/preview&id='.$model->id;
                        return $url;
                    }  
                    if ($action === 'edit') {
                        $url ='?r=final-inspection/edit&id='.$model->id;
                        return $url;
                    }   
                    if ($action === 'delete') {
                        $url ='?r=final-inspection/delete&id='.$model->id;
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
