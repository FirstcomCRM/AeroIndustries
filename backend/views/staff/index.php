<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchStaff */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
use common\models\StaffGroup;
?>
<div class="staff-index">

    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>
    </section>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($this->title) ?> List</h3>
                        </div>

                        <div class="col-sm-12 text-right">
                        <br>
                        <?= Html::a('<i class="fa fa-plus"></i> New Staff', ['create'], ['class' => 'btn btn-default']) ?>
                        <br>
                        <br>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'status',
            [
                'attribute' => 'group_id',
                'value' => function($model, $index, $column) {
                    $staffGroupName = '';
                    if ( isset( $model->group_id ) && !empty( $model->group_id ) ) {
                        $staffGroup = StaffGroup::getStaffGroup($model->group_id);
                        $staffGroupName = $staffGroup->name;
                    }
                    return $staffGroupName;
                },
            ],
            'title',
            'name',
            'staff_no',
            'department',
             [
                'attribute' => 'date_joined',
                'format' => 'text',
                'value' => function($model, $index, $column) {
                    if ( !empty($model->date_joined) ) {
                        $exDate = explode(' ',$model->date_joined);
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
            'stamp',
            'auth_no',
            // 'created',
            // 'updated',

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
