<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Traveller */

$this->title = 'Worksheet';
$this->params['breadcrumbs'][] = ['label' => 'Worksheet', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->id;
?>
<div class="traveler-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
	            'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
