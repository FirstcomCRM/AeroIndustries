<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data['model'] common\models\UphosteryOrder */

use common\models\Setting;

$woNumber = 'Uphostery No Missing';
if ( $data['model']->uphostery_scope && $data['model']->uphostery_type ) {
    $woNumber = Setting::getUphosteryNo($data['model']->uphostery_type,$data['model']->uphostery_scope,$data['model']->uphostery_no);
}

$this->title = 'Update ' . $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Upholsteries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $woNumber, 'url' => ['preview', 'id' => $data['model']->id]];
$this->params['breadcrumbs'][] = 'Update';

$subTitle = $woNumber;
$isEdit = true;

$data['isEdit'] = $isEdit;
$data['subTitle'] = $subTitle;
?>
<div class="uphostery-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'data' => $data,
		    ]) ?>

</div>
