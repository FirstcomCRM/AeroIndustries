<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FinalInspection */

$this->title = 'Final Inspection';
$this->params['breadcrumbs'][] = ['label' => 'Final Inspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Final Inspection';
?>
<div class="final-inspection-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
