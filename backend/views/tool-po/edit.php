<?php

use yii\helpers\Html;
use common\models\ToolPo;

/* @var $this yii\web\View */
/* @var $model common\models\Tool ToolPo */

$this->title = 'Tool Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Tool Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$poNumber = ToolPo::getTPONo($model->purchase_order_no,$model->created);
$subTitle = 'Update ' . $poNumber;
$isEdit = true;
?>
<div class="purchase-order-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>
		    <?= $this->render('_form-model', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		        'detail' => $detail,
		        'supplierAttention' => $supplierAttention,
		        'supplierAddresses' => $supplierAddresses,
    			'isEdit' => $isEdit,
    			'oldDetail' => $oldDetail,
            'currAttachment' => $currAttachment,
            'poAttachment' => $poAttachment,
            'supplier_id' => $supplier_id,
            'dataPartNonReuse' => $dataPartNonReuse,
		    ]) ?>

</div>
