<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\TpoSupplier */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tpo Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpo-supplier-view">


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
                                    'id',
            'company_name',
            'addr',
            'contact_person',
            'email:email',
            'contact_no',
            'title',
            'p_addr_1',
            'p_addr_2',
            'p_addr_3',
            'p_currency',
            'scope_of_approval',
            'survey_date',
            'approval_status',
            'status',
            'created_by',
            'created',
            'updated_by',
            'updated',
            'deleted',
                                ],
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
