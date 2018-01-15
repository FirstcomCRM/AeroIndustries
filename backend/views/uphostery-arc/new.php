<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UphosteryArc */

$this->title = 'Uphostery Arc';
$this->params['breadcrumbs'][] = ['label' => 'Uphostery Arcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Uphostery Arc';
?>
<div class="uphostery-order-arc-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
