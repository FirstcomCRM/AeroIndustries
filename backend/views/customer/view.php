<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
use common\models\User;
use common\models\Currency;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
?>
<div class="customer-view">


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
                        <?= Html::a('<i class=\'fa fa-edit\'></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
                                    'name',
                                    [
                                        'label'=>'Address 1',
                                        'value'=> $model->addr_1 ? $model->addr_1 : '',
                                    ],
                                    [
                                        'label'=>'Address 2',
                                        'value'=> $model->addr_2 ? $model->addr_2 : '',
                                    ],
                                    'contact_person',
                                    'email:email',
                                    'contact_no',
                                    'title',
                                    [
                                        'label'=>'Shipping Address 1',
                                        'value'=> $model->s_addr_1 ? $model->s_addr_1 : '',
                                    ],
                                    [
                                        'label'=>'Shipping Address 2',
                                        'value'=> $model->s_addr_2 ? $model->s_addr_2 : '',
                                    ],
                                    [
                                        'label'=>'Billing Address 1',
                                        'value'=> $model->b_addr_1 ? $model->b_addr_1 : '',
                                    ],
                                    [
                                        'label'=>'Billing Address 2',
                                        'value'=> $model->b_addr_2 ? $model->b_addr_2 : '',
                                    ],
                                    [
                                        'label'=>'Billing Term',
                                        'value'=> $model->b_term ? $model->b_term : '',
                                    ],
                                    [
                                        'label'=>'Billing Currency',
                                        'value'=> $model->b_currency ? $dataCurrency[$model->b_currency] : '',
                                    ],
                                    'status',
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
