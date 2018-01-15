<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Rfq */

$this->title = 'Request for Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Request for Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Request for Quotation';
?>
<div class="rfq-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'atta' => $atta,
        'subTitle' => $subTitle,
    ]) ?>

</div>
