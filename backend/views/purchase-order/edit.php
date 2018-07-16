<?php

use yii\helpers\Html;
use common\models\PurchaseOrder;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

$this->title = 'Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$poNumber = PurchaseOrder::getPONo($model->purchase_order_no,$model->created);
$subTitle = 'Update ' . $poNumber;
$isEdit = true;
?>
<div class="purchase-order-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>
		    <?= $this->render('_po-form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		        'detail' => $detail,
		        'supplierAttention' => $supplierAttention,
		        'supplierAddresses' => $supplierAddresses,
    			'dataPartNonReuse' => $dataPartNonReuse,
            'supplier_id' => $supplier_id,
    			'isEdit' => $isEdit,
    			'oldDetail' => $oldDetail,
	            'currAttachment' => $currAttachment,
	            'poAttachment' => $poAttachment,
		    ]) ?>

</div>
