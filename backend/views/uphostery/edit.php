<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data['model'] common\models\Uphostery */

use common\models\Setting;

$upNumber = 'Uphostery No Missing';
if ( $data['model']->uphostery_scope && $data['model']->uphostery_type ) {
    $upNumber = Setting::getUphosteryNo($data['model']->uphostery_type,$data['model']->uphostery_scope,$data['model']->uphostery_no);
}

$this->title = 'Update ' . $upNumber;
$this->params['breadcrumbs'][] = ['label' => 'Uphosterys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $upNumber, 'url' => ['preview', 'id' => $data['model']->id]];
$this->params['breadcrumbs'][] = 'Update';

$subTitle = $upNumber;
$isEdit = true;

$data['isEdit'] = $isEdit;
$data['subTitle'] = $subTitle;
?>
<div class="uphostery-order-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'data' => $data,
		    ]) ?>

</div>
