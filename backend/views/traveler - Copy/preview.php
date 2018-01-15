<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Traveler */

$this->title = $model->traveler_no;
$this->params['breadcrumbs'][] = ['label' => 'Travelers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traveler-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>

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
                        <?php if ( $model->status == 'active') { ?>
                        <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                        <?php } else { ?>
                        <?= Html::a( 'Back', Url::to(['old']), array('class' => 'btn btn-default')) ?>
                        <?php }  ?>
                    <br>
                    <br>
                    <!-- /.box-header -->
                    </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                    </div>


                    <div class="box-body">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                'job_type',
                                'desc',
                                'effectivity',
                                'revision_no',
                                'revision_date',
                                'created',
                                'updated',
                                'status',
                                'discont_reason',
                                ],
                            ]) ?>
                            
                            
                    </div>

                </div>

                <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Content</h3>

                    <div class="col-sm-12 text-right">
                    <br>
                        <?= Html::a('<i class=\'fa fa-print\'></i> Print', ['print', 'id' => $model->id], ['class' => 'btn btn-primary','target' => '_blank']) ?>
                    </div>
                    </div>
                    <div class="box-body text-center">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-6 col-xs-12 traveler-preview">
                            <?=$model->content?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
