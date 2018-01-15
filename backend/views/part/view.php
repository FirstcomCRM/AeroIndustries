<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Part */


use common\models\User;
use common\models\Currency;
use common\models\Supplier;
use common\models\PartCategory;
use common\models\Unit;

$this->title = $model->part_no;
$this->params['breadcrumbs'][] = ['label' => 'Parts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$dataCategory = PartCategory::dataPartCategory();
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'unit');
$dataSupplier = Supplier::dataSupplier();
?>
<div class="part-view">


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
                        <?= Html::a('<i class="fa fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
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
                                    [
                                        'label'=>'Category',
                                        'value'=> $model->category_id ? $dataCategory[$model->category_id] : '',
                                    ],
                                    'part_no',
                                    'desc',
                                    [
                                        'label'=>'Category',
                                        'value'=> $model->unit_id ? $dataUnit[$model->unit_id] : '',
                                    ],
                                    [
                                        'label'=>'Supplier',
                                        'value'=> $model->supplier_id ? $dataSupplier[$model->supplier_id] : '',
                                    ],
                                    'default_unit_price',
                                    'manufacturer',
                                    'restock',
                                    'status',
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
