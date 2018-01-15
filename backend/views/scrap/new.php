<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Scrap */

$this->title = 'Scrap';
$this->params['breadcrumbs'][] = ['label' => 'Scraps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Scrap';
?>
<div class="scrap-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
