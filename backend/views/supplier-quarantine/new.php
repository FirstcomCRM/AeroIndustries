<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SupplierQuarantine */

$this->title = 'Supplier Quarantine';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Quarantines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Supplier Quarantine';
?>
<div class="supplier-quarantine-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
