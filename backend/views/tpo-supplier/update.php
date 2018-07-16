<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TpoSupplier */

$this->title = 'Tpo Supplier';
$this->params['breadcrumbs'][] = ['label' => 'Tpo Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->title;
?>
<div class="tpo-supplier-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
            'supplierAttachment' => $supplierAttachment,
		        'oldSA' => $oldSA,
		    ]) ?>

</div>
