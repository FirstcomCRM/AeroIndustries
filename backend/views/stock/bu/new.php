<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Stock */

$this->title = 'Stock';
$this->params['breadcrumbs'][] = ['label' => 'Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Stock In';
$oldAttachment = false;
?>
<div class="stock-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_stock-new', [
        'model' => $model,
        'subTitle' => $subTitle,
        'purchaseOrder' => $purchaseOrder,
        'purchaseOrderDetail' => $purchaseOrderDetail,
        'allReceivedStatus' => $allReceivedStatus,
    ]) ?>

</div>
