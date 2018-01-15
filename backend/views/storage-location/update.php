<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StorageLocation */

$this->title = 'Store';
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->name;
?>
<div class="storage-location-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
