<?php

use yii\helpers\Html;
use common\models\GeneralPo;

/* @var $this yii\web\View */
/* @var $model common\models\General GeneralPo */

$this->title = 'General Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'General Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$poNumber = GeneralPo::getGPONo($model->purchase_order_no);
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
		    ]) ?>

</div>
