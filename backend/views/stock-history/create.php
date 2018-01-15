<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StockHistory */

$this->title = 'Stock History';
$this->params['breadcrumbs'][] = ['label' => 'Stock Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Stock History';
?>
<div class="stock-history-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
