<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaffGroup */

$this->title = 'Staff Group';
$this->params['breadcrumbs'][] = ['label' => 'Staff Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Staff Group';
?>
<div class="staff-group-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
