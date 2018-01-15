<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UphosteryArc */

$this->title = 'Uphostery Arc';
$this->params['breadcrumbs'][] = ['label' => 'Uphostery Arcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->id;
?>
<div class="uphostery-order-arc-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
