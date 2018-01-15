<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Calibration */
use common\models\User;

$this->title = $model->model;
$this->params['breadcrumbs'][] = ['label' => 'Calibrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
?>
<div class="calibration-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
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
                      <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                    </div>

                    <div class="col-sm-12 text-right">
                    <br>
                        <?= Html::a('<i class=\'fa fa-edit\'></i> Update', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class=\'fa fa-trash\'></i> Delete', ['remove', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>

                        <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                    <br>
                    <br>
                    <!-- /.box-header -->
                    </div>

                    <div class="box-body">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
            'description',
            'manufacturer',
            'model',
            'serial_no',
            'storage_location',
            'con_approval',
            'acceptance_criteria',
            'date',
            'due_date',
            // 'con_limitation',
                                    'created',
                                    [
                                        'label'=>'Created By',
                                        'value'=> $model->created_by ? $dataUser[$model->created_by] : '',
                                    ],
                                    'updated',
                                    [
                                        'label'=>'Updated By',
                                        'value'=> $model->updated_by ? $dataUser[$model->updated_by] : '',
                                    ],
                                ],
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
