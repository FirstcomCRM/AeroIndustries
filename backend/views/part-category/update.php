<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PartCategory */

$this->title = 'Part Category';
$this->params['breadcrumbs'][] = ['label' => 'Part Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->name;
?>
<div class="part-category-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
