<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Calibration */

$this->title = 'Calibration';
$this->params['breadcrumbs'][] = ['label' => 'Calibrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Multiple Calibration';
?>
<div class="calibration-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-multiple', [
        'model' => $model,
        'tidDetails' => $tidDetails,
            'atta' => $atta,
        'subTitle' => $subTitle,
    ]) ?>

</div>
