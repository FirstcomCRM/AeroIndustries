<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data['model'] common\models\WorkOrder */

use common\models\Setting;

$woNumber = 'Work Order No Missing';
if ( $data['model']->work_scope && $data['model']->work_type ) {
    $woNumber = Setting::getWorkNo($data['model']->work_type,$data['model']->work_scope,$data['model']->work_order_no);
}

$this->title = 'Update ' . $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $woNumber, 'url' => ['preview', 'id' => $data['model']->id]];
$this->params['breadcrumbs'][] = 'Update';

$subTitle = $woNumber;
$isEdit = true;

$data['isEdit'] = $isEdit;
$data['subTitle'] = $subTitle;
?>
<div class="work-order-update">
        <section class="content-header">
		    <h1><?= Html::encode($this->title) ?></h1>
	    </section>

		    <?= $this->render('_form-model', [
		        'data' => $data,
		    ]) ?>

</div>
