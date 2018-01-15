<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchRfq */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request for Quotation ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rfq-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Request for quotation', ['create'], ['class' => 'btn btn-default']) ?>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
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
                'attribute' => 'supplier_id',
                'value' => 'supplier.company_name',
                'label' => 'Supplier',
            ], 
            'quotation_no',
            'manufacturer',
            'trace_certs',
            // 'remark:ntext',
            // 'deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
