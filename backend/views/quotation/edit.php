<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Quotation */

$this->title = 'Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->id;
?>
<div class="quotation-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_quotation-form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
