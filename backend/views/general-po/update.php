<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeneralPo */

$this->title = 'General Po';
$this->params['breadcrumbs'][] = ['label' => 'General Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->id;
?>
<div class="general-po-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
