<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FinalInspection */

$this->title = 'Final Inspection';
$this->params['breadcrumbs'][] = ['label' => 'Final Inspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->title;
?>
<div class="final-inspection-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
