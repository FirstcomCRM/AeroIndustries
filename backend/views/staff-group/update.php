<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffGroup */

$this->title = 'Staff Group';
$this->params['breadcrumbs'][] = ['label' => 'Staff Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->name;
?>
<div class="staff-group-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
