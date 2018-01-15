<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

        <!-- Content Header (Page header) -->
        <section class="content-header capitalize">
            <h1>
                <?= Html::encode($this->title) ?>
                <small></small>
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title capitalize"><?= $model->username ?></h3>
                        </div>

                        <div class="col-sm-12 text-right">
                        <br>
                        <?= Html::a('<i class=\'fa fa-edit\'></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class=\'fa fa-trash\'></i> Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= \yii\helpers\Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                        <br>
                        <br>
                        <!-- /.box-header -->
                        </div>

                        <div class="box-body">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'user_group_id',
                                    'username',
                                    'email:email',
                                    'photo',
                                    'role',
                                    'status',
                                    'last_login',
                                    'created_by',
                                    'created_at',
                                    'updated_at',
                                ],
                            ]) ?>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>

</div>
