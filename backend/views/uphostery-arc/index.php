<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUphosteryArc */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\models\Uphostery;
use common\models\Setting;
$this->title = 'Uphostery Arcs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uphostery-arc-index">

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
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'uphostery_id',
            'format' => 'raw',
            'value' => function($model, $index, $column) {
                $uphostery_id = $model->uphostery_id;
                $uphostery = Uphostery::getUphostery($uphostery_id);
                if ( $uphostery->uphostery_scope && $uphostery->uphostery_type ) {
                    $woNumber = Setting::getUphosteryNo($uphostery->uphostery_type,$uphostery->uphostery_scope,$uphostery->uphostery_no);
                }
                return Html::a(Html::encode($woNumber),'?r=uphostery/preview&id='.$uphostery_id, ['target'=>'_blank']);
            },
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
            'type',
            'created',
            // 'first_check',
            // 'second_check',
            // 'form_tracking_no',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{preview}',
                'buttons' => [
                    'preview' => function ($url, $model) {
                        return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                                    'title' => Yii::t('app', 'Preview'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this uphostery?',
                                    ],
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'preview') {
                        $uphostery_id = $model->uphostery_id;
                        $uphostery = Uphostery::getUphostery($uphostery_id);
                        if ( $model->type == 'EASA' ) {
                            $url ='?r=uphostery-arc/print-easa&id='.$uphostery_id;
                        }
                        if ( $model->type == 'FAA' ) {
                            $url ='?r=uphostery-arc/print-faa&id='.$uphostery_id;
                        }
                        if ( $model->type == 'CAAS' ) {
                            $url ='?r=uphostery-arc/print-caa&id='.$uphostery_id;
                        }
                        if ( $model->type == 'COC' ) {
                            $url ='?r=uphostery-arc/print-coc&id='.$uphostery_id;
                        }
                        if ( $model->type == 'CAAV' ) {
                            $url ='?r=uphostery-arc/print-caav&id='.$uphostery_id;
                        }
                        if ( $model->type == 'DCAM' ) {
                            $url ='?r=uphostery-arc/print-dcam&id='.$uphostery_id;
                        }
                        return $url;
                    }  
                    if ($action === 'delete') {
                        $url ='?r=uphostery/delete-column&id='.$model->id;
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
