<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small></small>
            </h1>
        </section>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title">User List</h3>
                        </div>

                        <div class="col-sm-12 text-right">
                        <br>
                            <?= Html::a('<i class=\'fa fa-plus\'></i> New User', ['create'], ['class' => 'btn btn-default']) ?>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            // 'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'user_group_id',
                                    'value' => 'userGroup.name',
                                    'label' => 'User Group',
                                    'contentOptions' => ['class' => 'capitalize'],
                                    'headerOptions' => ['class' => 'capitalize']
                                ],
                                [
                                    'attribute' => 'username',
                                    'value' => 'username',
                                    'contentOptions' => ['class' => 'capitalize'],
                                    'headerOptions' => ['class' => 'capitalize']
                                ],
                                'email:email',
                                // 'photo',
                                // 'role',
                                // 'status',
                                // 'lastLogin',
                                // 'previousLogin',
                                // 'created_by',
                                // 'LastUpdatedBy',
                                // 'created_at',
                                // 'updated_at',
                                // 'deleted_at',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
    <!-- /.content -->
</div>
