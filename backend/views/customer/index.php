<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;



$gridColumns = 
[
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'status',
        'value' => 'status',
        'contentOptions' => ['class' => 'capitalize'],
        'headerOptions' => ['class' => 'capitalize']
    ],
    'code',
    [
        'attribute' => 'name',
        'value' => 'name',
        'contentOptions' => ['class' => 'capitalize'],
        'headerOptions' => ['class' => 'capitalize']
    ],
    'contact_person',
    'email:email',
    'contact_no',
    'fax',
    // 's_addr_1',
    // 's_addr_2',
    // 'b_addr_1',
    // 'b_addr_2',
    // 'b_term',
    // 'b_currency',
    // 'created',
    // 'updated',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{amend}{remove}',
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
            $url ='?r=customer/view&id='.$model->id;
            return $url;
        }
        if ($action === 'amend') {
            $url ='?r=customer/update&id='.$model->id;
            return $url;
        }
        if ($action === 'remove') {
            $url ='?r=customer/delete-column&id='.$model->id;
            return $url;
        }
        }
    ],
];

?>
<div class="customer-index">

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
                        <?= Html::a('<i class=\'fa fa-plus\'></i> New Customer', ['new'], ['class' => 'btn btn-default']) ?>
                        <?php

                            /*Renders a export dropdown menu*/
                            echo ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $gridColumns,
                                'columnSelectorOptions'=>[
                                    'label' => 'Filter Export',
                                    'class' => 'export-column'
                                ],
                                'exportConfig' => [
                                    ExportMenu::FORMAT_CSV => true,
                                    ExportMenu::FORMAT_TEXT => false,
                                    ExportMenu::FORMAT_HTML => false,
                                    ExportMenu::FORMAT_EXCEL => true,
                                ],
                                'fontAwesome' => true,
                                'dropdownOptions' => [
                                    'label' => 'Export All',
                                    'class' => 'btn btn-success export-export-all',
                                    'options' => [
                                        'class' => 'export-export-all'
                                    ]
                                ]
                            ]);
                        ?>

                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <?= 
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => $gridColumns
                                ]); 
                            ?>

                        </div>
                <!-- /.box-body -->
                     </div>
                </div>
            </div>

        </section>
</div>
