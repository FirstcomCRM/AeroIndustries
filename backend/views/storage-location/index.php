<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchStorageLocation */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-location-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right">
                        <br>
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Store', ['create'], ['class' => 'btn btn-default']) ?>
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

            // 'id',
            'status',
            'name',
            'size',

            
            // ['class' => 'yii\grid\ActionColumn'],
            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{preview}{amend}{remove}',
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
                    $url ='?r=storage-location/view&id='.$model->id;
                    return $url;
                }
                if ($action === 'amend') {
                    $url ='?r=storage-location/update&id='.$model->id;
                    return $url;
                }
                if ($action === 'remove') {
                    $url ='?r=storage-location/delete-column&id='.$model->id;
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
