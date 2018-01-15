<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tool */

$this->title = 'Tool';
$this->params['breadcrumbs'][] = ['label' => 'Tools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Tool';
?>
<div class="tool-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
