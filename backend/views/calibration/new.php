<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Calibration */

$this->title = 'Calibration';
$this->params['breadcrumbs'][] = ['label' => 'Calibrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Calibration';
?>
<div class="calibration-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'tool'=>$tool,
        'partId' => $partId,
        'subTitle' => $subTitle,
        'serialNo' => $serialNo,
    ]) ?>

</div>
