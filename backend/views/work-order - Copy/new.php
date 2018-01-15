<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WorkOrder */

$this->title = 'Work Order';
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Work Order';
$isEdit = false;

$data['isEdit'] = $isEdit;
$data['subTitle'] = $subTitle;
?>
<div class="work-order-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'data' => $data,
    ]) ?>

</div>
