<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Quarantine */

$this->title = 'Quarantine';
$this->params['breadcrumbs'][] = ['label' => 'Quarantines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Quarantine';
?>
<div class="quarantine-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
