<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGpoSupplier */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gpo Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gpo-supplier-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>


        <section class="content">
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right export-menu">
                        <br>
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Gpo Supplier', ['create'], ['class' => 'btn btn-default']) ?>
                        <br>
                        <br>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                // 'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],


                                    'company_name',
                                    // 'addr',
                                    'contact_person',
                                    'email:email',
                                    'contact_no',
                                    'scope_of_approval',
                                    'survey_date',
                                    [
                                      'attribute'=>'survey_date',
                                      'format'=>['date','php:d M Y'],
                                    ],
                                    'approval_status',

                                    [
                                      'class' => 'yii\grid\ActionColumn',
                                      'template' => '{preview}{amend}{remove}',
                                      'buttons' => [
                                        'preview' => function ($url, $model) {
                                            return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                                                        'title' => Yii::t('app', 'Preview'),
                                            ]);
                                        },
                                        'amend' => function ($url, $model) {
                                            return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, [
                                                        'title' => Yii::t('app', 'Amend'),
                                            ]);
                                        },
                                        'remove' => function ($url, $model) {
                                            return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                                                        'title' => Yii::t('app', 'Remove'),
                                                        'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                                        // 'data-method' => 'post',
                                            ]);
                                        }

                                      ],
                                      'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'preview') {
                                            $url ='?r=supplier/view&id='.$model->id;
                                            return $url;
                                        }
                                        if ($action === 'amend') {
                                            $url ='?r=supplier/update&id='.$model->id;
                                            return $url;
                                        }
                                        if ($action === 'remove') {
                                            $url ='?r=supplier/delete-column&id='.$model->id;
                                            return $url;
                                        }
                                      }
                                    ],

                                  //  ['class' => 'yii\grid\ActionColumn'],
                                ],
                            ]); ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
