<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WorkOrderSub */

$this->title = 'Work Order Sub';
$this->params['breadcrumbs'][] = ['label' => 'Work Order Subs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Work Order Sub';
?>
<div class="work-order-sub-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
