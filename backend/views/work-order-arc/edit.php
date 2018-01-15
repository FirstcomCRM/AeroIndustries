<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WorkOrderArc */

$this->title = 'Work Order Arc';
$this->params['breadcrumbs'][] = ['label' => 'Work Order Arcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->id;
?>
<div class="work-order-arc-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
