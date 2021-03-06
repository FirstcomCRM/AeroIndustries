<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUserPermission */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-permission-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New User Permission', ['create'], ['class' => 'btn btn-default']) ?>
                        <?= Html::a('<i class=\'fa fa-plus\'></i> Permission Setting', ['permission-setting'], ['class' => 'btn btn-default']) ?>
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

            'id',
            'controller',
            'action',
            [
                'attribute' => 'user_group_id',
                'value' => 'userGroup.name',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
