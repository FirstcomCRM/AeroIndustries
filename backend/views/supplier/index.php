<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchSupplier */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>


        <section class="content">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right">
                        <br>
                        <?= Html::a('<i class="fa fa-plus"></i> New Supplier', ['create'], ['class' => 'btn btn-default']) ?>
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

                                    'status',
                                    'company_name',
                                    
                                    // [
                                    //     'attribute' => 'addr',
                                    //     'format' => 'html',
                                    //     'label' => 'Address',
                                    // ],
                                    'contact_person',
                                    'email:email',
                                    'contact_no',
                                    // 'title',
                                    // 'p_addr_1',
                                    // 'p_addr_2',
                                    // 'p_addr_3',
                                    // 'p_currency',
                                    'scope_of_approval',
                                    [
                                        'attribute' => 'survey_date',
                                        'format' => 'text',
                                        'value' => function($model, $index, $column) {
                                            if ( !empty($model->survey_date) ) {
                                                $exDate = explode(' ',$model->survey_date);
                                                $is = $exDate[0];
                                                $time = explode('-', $is);
                                                $monthNum = $time[1];
                                                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                $monthName = $dateObj->format('M'); // March
                                                $newDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                                return $newDate;
                                            }
                                        },
                                    ],
                                    'approval_status',
                                    // 'created',
                                    // 'updated',

                                    // ['class' => 'yii\grid\ActionColumn'],
                                    [
                                      'class' => 'yii\grid\ActionColumn',
                                      'template' => '{preview}{amend}{delete}',
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
                                        'delete' => function ($url, $model) {
                                            return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                                                        'title' => Yii::t('app', 'Delete'),
                                                        'data' => [
                                                            'confirm' => 'Are you sure you want to delete this setting?',
                                                        ],
                                            ]);
                                        },

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
                                        if ($action === 'delete') {
                                            $url ='?r=supplier/delete-column&id='.$model->id;
                                            return $url;
                                        }
                                      }
                                    ],
                                ],
                            ]); ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
