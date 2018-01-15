<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Traveller */

$this->title = 'Worksheet';
$this->params['breadcrumbs'][] = ['label' => 'Worksheet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Worksheet';
?>
<div class="traveler-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
