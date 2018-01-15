<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchDeliveryOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivery Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-order-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>


        <section class="content">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right export-menu">
                        <br>
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Delivery Order', ['new'], ['class' => 'btn btn-default']) ?>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                // 'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    [
                                        'attribute' => 'delivery_order_no',
                                        'format' => 'text',
                                        'value' => function($model, $index, $column) {
                                            return $model->delivery_order_no ? "DO-" . sprintf("%008d", $model->delivery_order_no) : '' ;
                                        },
                                        'label' => 'DO Number',
                                    ],
                                    [
                                        'attribute' => 'date',
                                        'format' => 'text',
                                        'value' => function($model, $index, $column) {
                                            if ( !empty($model->date) ) {
                                                $exDate = explode(' ',$model->date);
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
                                    [
                                        'attribute' => 'customer_id',
                                        'value' => 'customer.name',
                                    ], 
                                    // 'ship_to',

                                    [
                                        'attribute' => 'is_attachment',
                                        'format' => 'text',
                                        'value' => function($model, $index, $column) {
                                            return $model->is_attachment ? 'Yes' : 'No' ;
                                        },
                                        'label' => 'Attachment',
                                    ],
                                    'contact_no',
                                    'is_attachment',
                                    'status',
                                    'created',
                                    // 'created_by',

                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{print}{delete}',
                                        'buttons' => [
                                            'print' => function ($url, $model) {
                                                return Html::a(' <span class="glyphicon glyphicon-print"></span> ', $url, [
                                                            'title' => Yii::t('app', 'Print'),
                                                ]);
                                            },
                                            'delete' => function ($url, $model) {
                                                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                                                            'title' => Yii::t('app', 'Delete'),
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this delivery order?',
                                                            ],
                                                ]);
                                            },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) {
                                            if ($action === 'print') {
                                                $url ='?r=delivery-order/print&id='.$model->id;
                                                return $url;
                                            }
                                            if ($action === 'delete') {
                                                $url ='?r=delivery-order/delete-column&id='.$model->id;
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
