<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WorkOrder */

$this->title = 'Upholstery';
$this->params['breadcrumbs'][] = ['label' => 'Upholsteries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Upholstery';
$data['isEdit'] = false;
$data['subTitle'] = $subTitle;
?>
<div class="uphostery-create">

        <section class="content-header">
    		<h1><?= Html::encode($subTitle) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'data' => $data,
    ]) ?>

</div>
