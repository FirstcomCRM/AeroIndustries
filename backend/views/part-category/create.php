<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PartCategory */

$this->title = 'Part Category';
$this->params['breadcrumbs'][] = ['label' => 'Part Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Part Category';
?>
<div class="part-category-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
