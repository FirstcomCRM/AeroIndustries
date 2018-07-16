<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SupplierQuarantine */

$this->title = 'Supplier Quarantine';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Quarantines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update Quarantine';
?>
<div class="supplier-quarantine-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
