<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Quotation */

$this->title = 'Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Quotation';
?>
<div class="quotation-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_quotation-form', [
        'model' => $model,
        'subTitle' => $subTitle,
        'detail' => $detail,
        'qAttachment' => $qAttachment,
        'customerAddresses' => $customerAddresses,
    ]) ?>

</div>
