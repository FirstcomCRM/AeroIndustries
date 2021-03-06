<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Quarantine */

$this->title = 'Quarantine';
$this->params['breadcrumbs'][] = ['label' => 'Quarantines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update ' . $model->id;
?>
<div class="quarantine-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

      <?php if ($model->work_type == 'work_order'): ?>
        <?= $this->render('_form-model', [
           'model' => $model,
           'subTitle' => $subTitle,
       ]) ?>
      <?php else: ?>
        <?= $this->render('_form-model-up', [
            'model' => $model,
            'subTitle' => $subTitle,
        ]) ?>
      <?php endif; ?>


</div>
