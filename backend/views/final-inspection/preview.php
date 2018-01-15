<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\FinalInspection */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Final Inspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
?>
<div class="final-inspection-view">


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
                        <?= Html::a('<i class=\'fa fa-trash\'></i> Delete', ['delete', 'id' => $model->id], [
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
                                'build',
                                'created',
                                [
                                    'label'=>'Created By',
                                    'value'=> $model->created_by ? $dataUser[$model->created_by] : '',
                                ],
                                [
                                    'label'=>'Last Update',
                                    'value'=> $model->updated ? $model->updated : '',
                                ],
                                [
                                    'label'=>'Updated By',
                                    'value'=> $model->updated_by ? $dataUser[$model->updated_by] : '',
                                ],
                                ],
                            ]) ?>
                        <div class="row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-4">
                            <br>
                                <div class="box final-inspection-content">
                                    <strong><?= $model->title ?></strong>
                                    <?=$model->content?>
                                    <?=$model->form_no?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
