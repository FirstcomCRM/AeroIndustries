<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Request for Quotation */

$this->title = 'Request for Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Request for Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->quotation_no;
?>
<div class="rfq-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'atta' => $atta,
		        'currAtta' => $currAtta,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
