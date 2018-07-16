<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Calibration */

$this->title = 'Calibration';
$this->params['breadcrumbs'][] = ['label' => 'Calibrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->id;
?>
<div class="calibration-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'model' => $model,
		        'subTitle' => $subTitle,
	            'atta' => $atta,
            'tool' => $tool,
            'currAtta' => $currAtta,
            'partId' => $partId,
            'serialNo' => $serialNo,
		    ]) ?>

</div>
