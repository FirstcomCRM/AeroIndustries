<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GpoSupplier */

$this->title = 'Gpo Supplier';
$this->params['breadcrumbs'][] = ['label' => 'Gpo Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->title;
?>
<div class="gpo-supplier-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
