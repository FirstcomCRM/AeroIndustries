<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TpoSupplier */

$this->title = 'Tpo Supplier';
$this->params['breadcrumbs'][] = ['label' => 'Tpo Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Tpo Supplier';
?>
<div class="tpo-supplier-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
        'supplierAttachment' => $supplierAttachment,
        'oldSA' => $oldSA,
    ]) ?>

</div>
