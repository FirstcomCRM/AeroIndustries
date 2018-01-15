<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCurrency */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Currencies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-index">

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

                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'status',
            'iso',
            'name',
            'rate',
            'updated',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{change_status}{update_rate}',
                'buttons' => [
                    'change_status' => function ($url, $model) {
                        return Html::a(' <span class="glyphicon glyphicon-off"></span> ', $url, [
                                'title' => Yii::t('app', 'Change Status'),
                                'data' => [
                                    'confirm' => 'Are you sure you want to change the status?',
                                ],
                        ]);
                    },
                    'update_rate' => function ($url, $model) {
                        return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, [
                                'title' => Yii::t('app', 'Update Rate'),
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'change_status') {
                        $url ='?r=currency/change-status&id='.$model->id;
                        return $url;
                    }
                    if ($action === 'update_rate') {
                        $url ='?r=currency/update&id='.$model->id;
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
