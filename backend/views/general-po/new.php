<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GeneralPurchase Order */

$this->title = 'General Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'General Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create General Purchase Order';
$isEdit = false;
?>
<div class="general-po-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'detail' => $detail,
        'subTitle' => $subTitle,
        'supplierAttention' => $supplierAttention,
        'supplierAddresses' => $supplierAddresses,
        'isEdit' => $isEdit,
    ]) ?>

</div>
