<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ToolPurchase Order */

$this->title = 'Tool Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Tool Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Tool Purchase Order';
$isEdit = false;
?>
<div class="tool-po-create">

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
            'poAttachment' => $poAttachment,
        'isEdit' => $isEdit,
        
            'supplier_id' => $supplier_id,
            'dataPartNonReuse' => $dataPartNonReuse,
    ]) ?>

</div>
