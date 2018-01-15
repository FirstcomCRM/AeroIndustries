<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchPartCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Part Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-category-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>

    

        <section class="content">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right">
                        <br>
                        <?= Html::a('<i class="fa fa-plus"></i> New Part Category', ['create'], ['class' => 'btn btn-default']) ?>
                        <br>
                        <br>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                // 'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    'name',
                                    'desc',
                                              
                                    // ['class' => 'yii\grid\ActionColumn'],
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
                                            $url ='?r=part-category/view&id='.$model->id;
                                            return $url;
                                        }
                                        if ($action === 'amend') {
                                            $url ='?r=part-category/update&id='.$model->id;
                                            return $url;
                                        }
                                        if ($action === 'remove') {
                                            $url ='?r=part-category/delete-column&id='.$model->id;
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
