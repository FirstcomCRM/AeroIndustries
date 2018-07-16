<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

$this->title = 'Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Purchase Order';
$isEdit = false;
?>
<div class="purchase-order-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_po-form', [
        'model' => $model,
        'detail' => $detail,
        'supplierAttention' => $supplierAttention,
        'supplierAddresses' => $supplierAddresses,
        'poAttachment' => $poAttachment,
            'dataPartNonReuse' => $dataPartNonReuse,
            'supplier_id' => $supplier_id,
        'subTitle' => $subTitle,
        'isEdit' => $isEdit,
    ]) ?>

</div>
