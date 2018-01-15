<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DeliveryOrder */

$this->title = 'Delivery Order';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Delivery Order';
?>
<div class="delivery-order-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
        'workOrderPart' => $workOrderPart,
        'workOrder' => $workOrder,
        'customerAddresses' => $customerAddresses,
        'detail' => $detail,
    ]) ?>

</div>
