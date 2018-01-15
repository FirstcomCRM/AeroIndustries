<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GeneralPo */

$this->title = 'General Po';
$this->params['breadcrumbs'][] = ['label' => 'General Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create General Po';
?>
<div class="general-po-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
