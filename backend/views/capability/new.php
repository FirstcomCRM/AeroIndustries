<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Capability */

$this->title = 'Capability';
$this->params['breadcrumbs'][] = ['label' => 'Capabilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Capability';
?>
<div class="capability-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
