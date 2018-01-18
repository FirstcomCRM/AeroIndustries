<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GpoSupplier */

$this->title = 'Gpo Supplier';
$this->params['breadcrumbs'][] = ['label' => 'Gpo Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Gpo Supplier';
?>
<div class="gpo-supplier-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
